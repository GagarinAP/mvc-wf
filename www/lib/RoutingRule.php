<?php

interface RoutingRule {
	
	/**
	 * set current url for making routing
	 * @param type $url
	 */
	function setUrl($url);
	
	/**
	 * testing current url by $rule
	 * 
	 * @param type $url
	 * @return boolean
	 */
	function test($url);
	
	/**
	 * compute routing data from url
	 * 
	 * @param type $url
	 * @return type
	 */
	function getRouting($url=null);
}

/**
 * routing by regular expression
 */
class RoutingRegexRule implements RoutingRule {
	
	protected $rule;
	protected $role;
	protected $routing = null;
	protected $url;
	
	/**
	 * 
	 * @param type $rule - string of RegExp. example: '#/(view)/(user)/([0-9]*)/(short|details|json)#'
	 * 
	 * @param type $role - assoc array {roleKey: value|matchIndex},
	 * where key can be : controller (or 'c'), method (or 'm'), 
	 *	and set of param(s): param1, param2,... etc (or short version: p1, p2, ...).
	 * value: correct string, which will be used as controller, method or parameter of method.
	 *	or: index of matching of regexp by passed url 
	 * role examples: {'method':1, controller: 2, param1:3} // indexes of #/(conrollerMask)/(methodMask)/(paramMask)#
	 *  or {controller: 'controller_name', method: 'method_name'} // string values without matches
	 *	or list array: [method, controller, param1], or [m, c, p1] // not implemented variant
	 * 
	 * in common case: each group in regex of rule can be used in role as numeric index (starting from 1).
	 */
	function __construct($rule, $role){
		$this->rule = $rule;
		$aliases = [
			'c' => 'controller',
			'm' => 'method'
		];

		foreach($role as $key => $val){
			// aliases for controller, method
			if(isset($aliases[$key])){
				$role[$aliases[$key]] = $val;
				unset($role[$key]);
			} else {
				// aliases for param(N)
				if(preg_match('#^p(\d+)$#', $key, $m)){
					$role["param{$m[1]}"] = $val;
					unset($role[$key]);
				}
			}
		}
		$this->role = $role;
	}
	
	function setUrl($url){
		$this->url = $url;
	}
	
	function defaultRouting(){
		return ['controller'=>'main', 'method'=>'index', 'params'=>[]];
	}
	
	/**
	 * testing current url by $rule
	 * 
	 * @param type $url
	 * @return boolean
	 */
	function test($url){
		$this->url = false;
		if(preg_match($this->rule, $url)){
			$this->url = $url;
			return true;
		}
		return false;
	}
	
	/**
	 * compute routing data from url according to $role
	 * 
	 * @param type $url - url for computing, can be null when $this->url was entered previously
	 * @return array
	 */
	function getRouting($url=null){
		if($url === null){
			if($this->url !== null){
				$url = $this->url;
			} else {
				return null;
			}
		}
		$this->routing = null;
		preg_match($this->rule, $url, $m);
		$routing = array('url'=>$url);
		$len = count($m);
		
		// not correct situation, when no matches in regexp
		if($len < 1){
			return null;
		}
			
		$params = array();
		// $r - roleKey, $mPart - part of Rule's match
		foreach($this->role as $r => $mPart){
			$rValue = $mPart;
			if(is_integer($mPart)){
				$rValue = isset($m[$mPart]) ? $m[$mPart] : null;
			}
			if(substr($r, 0, strlen('param')) == 'param'){
				// param order index (from 1)
				$pIndex = intval(substr($r, strlen('param')));
				$params[$pIndex - 1] = $rValue;
				continue;
			} else {
				$routing[$r] = $rValue;
			}
		}
		$routing['params'] = $params;
		$this->routing = $routing;
		return $routing;
	}
}

class DefaultRoutingRule extends RoutingRegexRule {
	
	function __construct() {
		parent::__construct('^/([^/]+)/([^/]+)', ['controller'=>1, 'method'=>2]);
	}
	
	function getRouting($url=null){
		//p("this->url: {$this->url}");
		if($url === null){
			if($this->url !== null){
				$url = $this->url;
			} else {
				return null;
			}
		}
		$suburl = $url;
		if(strpos($url, '?') !== FALSE)
			$suburl = substr($url, 0, strpos($url, '?'));
		$parts = explode('/', trim($suburl,'/'));
		$res = $this->defaultRouting();
		$res['url'] = $url;
		if(count($parts) > 0){
			$res['controller'] = $parts[0];
			if(count($parts) > 1){
				$res['method'] = $parts[1];
				if(count($parts) > 2){
					$res['params'] = array_slice($parts, 2);
				}
			}
		}
		return $res;
	}
}