<?php

class View{
	private $data;
	private $file;
	private $code;

	function __construct($file, $data){
		$this->file = $file;
		$this->code = file_get_contents($this->file);
		$this->setData($data);
	}

	function setData($data){
		$this->data = $data;
	}
	
	function __set($key, $val){
		$this->data[$key] = $val;
	}

	function render($printFlag = false){
		extract($this->data); // ['user' => 'vasya'] ; ->  $user = 'vasya';
		ob_start();
		eval('?>' . $this->code . '<?');
		$resultContent = ob_get_contents();
		ob_end_clean();
		if($printFlag)
			print $resultContent;
		return $resultContent;
	}
}