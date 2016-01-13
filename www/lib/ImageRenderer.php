<?php

class ImageRenderer {
	private $image;
	private $bin = null;
	
	function __construct($image) {
		$this->image = $image;
	}
	
	function render(){
		ob_start();
		$this->output();
		$this->bin = ob_get_contents();
		ob_end_clean();
		return $this;
	}
	
	function output(){
		imagepng($this->image);
	}
	
	function result(){
		return $this->bin;
	}
	
	function save($file){
		imagepng($this->image, $file);
	}
}
