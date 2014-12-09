<?php


class Cache {
	
	const NONE = 1;
	const TEXT = 2;
	const JSON = 3;
	
	private $rootDir = "";
	private $currentPath;
	private $currentDir;
	
	function __construct($dir){
		$this->rootDir = $dir;
		$this->setPath();
	}
	
	/**
	 * set current storage using relative path.
	 * method will make dir if dir is not exists
	 * @param type $path - relative path in $rootDir (sub1/sub2/../subN)
	 */
	function setPath($path=null){
		p("set: $path");
		$this->currentPath = $path;
		if($path != null){
			$path = "/$path";
		}
		$dirs = explode('/', trim($path, " \/"));
		$targetDir = $this->rootDir;
		foreach($dirs as $name){
			$targetDir = $targetDir . "/" . $name;
			if(is_file($targetDir)){
				throw new Exception("Cache trying make dir instead existing file");
			}
			if(!is_dir($targetDir)){
				mkdir($targetDir);
				chmod($targetDir, 755);
			}
		}
		$this->currentDir = $this->rootDir . $path;
	}
	
	/**
	 * get data from file as object deserialized from json
	 * @param type $key
	 * @return type
	 */
	function get($key){
		p($this->currentDir);
		return $this->getFromPath($this->currentDir . '/' . $this->fileName($key), self::JSON);
	}
	
	/**
	 * save data to file with werializing to json
	 * @param type $key
	 * @param type $val
	 */
	function save($key, $val){
		p($this->currentDir);
		$this->saveToPath($this->currentDir . '/' . $this->fileName($key), $val, self::JSON);
	}
	
	function getFromPath($file, $type=self::NONE){
		$content = file_get_contents($file);
		switch($type){
			case self::NONE : break;
			case self::TEXT : break;
			case self::JSON : $content = json_decode($content); break; 
			default : break;
		}
		return $content;
	}
	
	function saveToPath($file, $content='', $type=self::NONE){
		switch($type){
			case self::NONE : break;
			case self::TEXT : break;
			case self::JSON : $content = json_encode($content); break;
			default : break;
		}
		if(!is_string($content)){
			$content = serialize($content);
		}
		file_put_contents($file, $content);
	}
	
	protected function fileName($name){
		return $name . '.cache';
	}
	
}