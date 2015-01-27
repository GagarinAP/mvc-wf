<?php

class Wf {
	static $instance = null;
	private $conf;
	private $router;
	private $context;
	private $_cache = null;

	private function __construct(){
		$this->loadConf();
	}

	static function instance(){
		if(self::$instance == null)
			self::$instance = new Wf();
		return self::$instance;
	}

	function prepare(){
		$this->router = new Router();
		if(self::conf('routing.use_rules')){
			$routing = new Routing();
			foreach(self::conf('routing.rules') as $rule){
				$routing->add($rule);
			}
			$this->router->setRules($routing);
		}
		$this->routing();
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
		return $this->runController($class, self::conf('pages.service.404'), array($page));
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
	
	/**
	 * 
	 * @param type $path - relative/cache/path (top lvl id = name of file)
	 */
	static function cache($path=null){
		if(self::$instance->_cache == null){
		//	p('create cache');
			self::$instance->_cache = new Cache(self::conf('cache_storage_dir'));
		}
		if($path){
			p("wf:cache:path: $path");
			self::$instance->_cache->setPath($path);
		}
		return self::$instance->_cache;
	}
	
	/**
	 * redirect to subpath of current website
	 * @param type $subUrl - part of url in current domain
	 */
	static function redirectTo($subUrl){
		self::redirect(self::subUrl($subUrl));
	}
	
	/**
	 * redirect to url
	 * @param type $url
	 */
	static function redirect($url){
		header('location:' . self::subUrl($subUrl));
	}
	
	/**
	 * makes url from subpath like '/controller/method/param'
	 * @param type $path - subpath after domain and base path
	 * @return string
	 */
	static function subUrl($path){
		$divider = $path{0} == '/' ? '' : '/';
		return Wf::conf('protocol') . '://' . $_SERVER['HTTP_HOST'] . Wf::conf('base_path') . $divider . $path;
	}
}
