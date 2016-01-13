<?php

class Captcha {
	
	private $image;
	private $text;
	private $w;
	private $h;
	
	private $fontParams = [
		'size' => 10, // font size
		'sizeDiff' => 0, // limitation of font size changing to up
		'offset' => 0, // max vertical offset
		'hOffset' => 0, // max horisontal offset
		'angle' => 0, // max angle of char rotation
		'file' => null,
		'color' => true // true - random color for each, false - black, [r,g,b] - current color
	];
	
	function __construct($w, $h, $text='') {
		$this->w = $w;
		$this->h = $h;
		$this->text = $text;
		$this->init();
	}
	
	function init(){
		$this->fontParams['size'] = floor($this->h / 2);
		$this->fontParams['offset'] = $this->fontParams['size'] / 2;
	//	$this->fontParams['angle'] = 0;
		$this->fontParams['file'] = DOC_ROOT . '/resources/fonts/Amperzand.ttf';
		$this->createImage();
	}
	
	/**
	 * params:
	 * size: int - size of font in points
	 * offset: int - max offset of one char
	 * angle: float - max rotation angle
	 * sizeDiff: int - limitation of font size changing to up
	 * 
	 * @param array $params
	 * @return \Captcha
	 */
	function setParams($params){
		foreach($params as $key => $val){
			$this->fontParams[$key] = $val;
		}
		return $this;
	}
	
	function setText($text){
		$this->text = $text;
		return $this;
	}
	
	function getText(){
		return $this->text;
	}
	
	function makeText($length=4){
		$this->text = "";
		$chars = 'abcdefghjkmnopqrstuvwxyz123456789';
		$chLen = strlen($chars);
		for($i=0; $i<$length; ++$i){
			$index = mt_rand(0, $chLen - 1);
			$this->text .= $chars{$index};
		}
		return $this;
	}
	
	function createImage(){
		$this->image = imagecreatetruecolor($this->w, $this->h);
		//vd($this->image);
		return $this;
	}
	
	function bg($color=[255, 255, 255]){
		$bgColor = imagecolorallocate($this->image, $color[0], $color[1], $color[2]);
		imagefill($this->image, 0, 0, $bgColor);
		return $this;
	}
	
	function addLines(){
		return $this;
	}
	
	function addNoise(){
		return $this;
	}
	
	function addText(){
		$x = 0;
		$y = $this->h / 2;
		$curX = $x + 10;
		$len = strlen($this->text);
		$fp = &$this->fontParams;
		$hOffset = $fp['hOffset'];
			$size = $fp['size'];
			$angle = $fp['angle'];
		for($i=0; $i<$len; ++$i){
			$colorParts = $fp['color'] ? $this->randomColor(150) : [0,0,0];
			$curAngle = mt_rand(0, $angle * 2) - $angle;
			//$curAngle = -45;// mt_rand(0, $angle * 2) - $angle;
			$curX += 20 + mt_rand(0, $hOffset * 2) - $hOffset / 2;
			$curY = $y + mt_rand(0, $fp['offset']) + sin($curAngle) * $size / 4;
			$char = mt_rand(0, 1) ? strtoupper($this->text{$i}) : $this->text{$i};
			$color = imagecolorallocate($this->image, $colorParts[0], $colorParts[1], $colorParts[2]);
			imagettftext($this->image, $size, $curAngle, $curX, $curY, $color, $fp['file'], $char);
		//	p("( $size, $angle, $curX, $curY, $color, {$fp['file']}, {$this->text{$i}} )");
		}
		return $this;
	}
	
	function randomColor($mid=127){
		$rn = mt_rand(0, 12);
		$gn = mt_rand(0, 12);
		$bn = mt_rand(0, 12);
		$parts = $rn + $gn + $bn;
		$part = $mid * 3 / $parts;
		$r = round($part * $rn);
		$g = round($part * $gn);
		$b = round($part * $bn);
		return [$r, $g, $b];
	}
	
	function makeDefault(){
		$this->bg()->maleText()->addLines()->addNoise()->addText();
		return $this;
	}
	
	function result($file=null){
		$renderer = new ImageRenderer($this->image);
		if(! $file){
			return $renderer->output();
		}
		$renderer->save($file);
	}
	
	function imageHeader(){
		header('Content-type: image/png');
		return $this;
	}
}
