<?php

class Wf {
	static $instance = null;
	private $conf;
	private $router;
	private $context;

	function __construct(){
		$this->loadConf();
	}

	static function instance(){
		if(self::$instance == null)
			self::$instance = new Wf();
		return self::$instance;
	}

	function prepare(){
		$this->router = new Router();
		$this->routing();
                //p($this->router);
	}

	function loadConf(){
		$confFile = DOC_ROOT . '/config.php';
		if(file_exists($confFile)){
			include $confFile;
			if(isset($config))
				$this->conf = $config;
		}
	}

	function routing(){
		$this->context = $this->router->load();
		//p($this->context);
	}

	function run(){
		$controller = $this->context->controller;
		$class = $this->loadController($controller);
		if(! $class){
			return $this->error404();
		}

		$method = $this->context->method;

		if(! method_exists($class, $method)){
			return $this->error404();
		}
		return $this->runController($class, $method, $this->context->params);
	}

	function error404(){
		$page = $this->context->path;
		$class = $this->loadController('service');
		return $this->runController($class, 'page404', array($page));
	}

	function loadController($name){
		$className = ucfirst($name) . 'Controller';
		if(class_exists($className))
			return $className;
		$file = APP_ROOT . '/controllers/' . $name . '.php';
		//p($file);
		if(!file_exists($file))
			return false;
		if(! require_once($file))
			return false;
		return $className;
	}

	function runController($class, $method=null, $params=array()){
		if($method === null){
			$method = 'index';
		}
		$controllerInstance = new $class();

		call_user_func_array(array($controllerInstance, $method), $params);
	}

	static function conf($key){
		return isset(self::$instance->conf[$key]) ? self::$instance->conf[$key] : null;
	}

	static function view($name, $data=array()){
		$file = APP_ROOT . '/views/' . $name. '.php';
		if(file_exists($file)){
			return new View($file, $data);
		}
	}

	static function model($name){
		$file = APP_ROOT . '/models/' . $name. '.php';
		$class = ucfirst($name) . 'Model';

		if(!class_exists($class)){
			if(!file_exists($file)){
				die("No file for model [{$name}]");
			}
			include_once $file;
		}
		return new $class();
	}
	
	static function get($key){
		self::instance()->router->queryVal($key);
	}
	
	static function post($key){
		return isset($_POST[$key]) ? $_POST[$key] : null;
	}
}