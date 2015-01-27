<?php

class Router {

	private $segments = array();
	private $controller;
	private $method;
	private $params = array();
	private $path;
	private $queryString = '';
	private $GET = array();
	private $routing = null;

	function __construct(){
		$this->controller = Wf::conf('default_controller');
		$this->method = Wf::conf('default_method');
	}
	
	function setRules(Routing $routing){
		$this->routing = $routing;
	}

	function load(){
	//	p($_SERVER);
		if($this->routing != null){
			$this->loadByRule();
		} else {
			$this->loadBySegments();
		}
		return $this->context();
	}
	
	function loadBySegments(){
		$path = $_SERVER['REQUEST_URI'];
		$posQMark = strpos($path, '?');
		if($posQMark != false){
			$subs = explode('?', $path);
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
		
		$path = $this->routingPath($path);
		$path = trim($path, '/');
		if(strlen($path) < 1)
			return $this->context();
		$seg = explode('/', $path);
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
	}
	
	function loadByRule(){
		$path = $_SERVER['REQUEST_URI'];
		$path = $this->routingPath($path);
		$routingData = $this->routing->find($path)->getRouting();
		foreach(['controller', 'method', 'params'] as $key){
			if(isset($routingData[$key])){
				$this->{$key} = $routingData[$key];
			}
		}
	}
	
	function routingPath($path){
		$base = Wf::conf('base_path');
		if(	strlen($base) > 0
			&& strlen($path)
			&& strpos($path, $base) !== false
			&& substr($path, 0, strlen($base)) === $base ){
			$path = substr($path, strlen($base));
		}
		$this->path = $path;
		return $path;
	}

	function context(){
		$res = [];
		foreach(['controller', 'method', 'params', 'path'] as $key){
			$res[$key] = $this->{$key};
		}
		return (object)$res;
	}
	
	function queryVal($key){
		return isset($this->GET[$key]) ? $this->GET[$key] : null;
	}
}