<?php

class Router {

	private $segments = array();
	private $controller;
	private $method;
	private $params = array();
	private $path;
	private $queryString = '';
	private $GET = array();

	function __construct(){
		$this->controller = Wf::conf('default_controller');
		$this->method = Wf::conf('default_method');
	}

	function load(){
		//p($_SERVER);
		$path = $_SERVER['REQUEST_URI'];
		$this->path = $path;
		$posQMark = strpos($path, '?');
		if($posQMark != false){
			//$path= substr($path, 0, $posQMark);
			$subs = explode('?', $path);
			//p($subs);
			$path = $subs[0];
			if(strlen($subs[1]) > 0){
				$this->queryString = $subs[1];
				parse_str($this->queryString, $get);
				$this->GET = $get;
				if(empty($_GET) && !empty($get)){
					$_GET = $get;
				}
			}
		}
		//p($_GET);
//		p('path = ' . $path);
		$base = Wf::conf('base_path');
		if(strlen($path)
			&& strpos($path, $base) !== false
			&& substr($path, 0, strlen($base)) === $base ){
			$path = substr($path, strlen($base));
			$path = trim($path, '/');
			//p('path = ' . $path);
		}
		//p('path = ' . $path);
		if(strlen($path) < 1)
			return $this->context();
		$seg = explode('/', $path);
		//p($seg);
		$segNum = count($seg);
		$this->segments = $seg;
		if($segNum > 0){
			$this->controller = $seg[0];
			if($segNum > 1){
				$this->method = $seg[1];
				if($segNum > 2){
					$this->params = array_slice($seg, 2);
				}
			}
		}
		//p($this);
		return $this->context();
	}

	function context(){
		return (object) array(
			'controller' => $this->controller,
			'method' => $this->method,
			'params' => $this->params,
			'path' => $this->path
		);
	}
	
	function queryVal($key){
		return isset($this->GET[$key]) ? $this->GET[$key] : null;
	}
}