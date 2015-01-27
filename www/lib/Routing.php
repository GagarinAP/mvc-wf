<?php

require_once 'RoutingRule.php';

/**
 * Container for routing rules
 */
class Routing {
	private $rules = [];
	private $default;
	
	function __construct(RoutingRule $rule = null) {
		$this->default = $rule != null ? $rule : new DefaultRoutingRule();
	}
	
	/**
	 * test each rule from rule list, and return first correct rule
	 * 
	 * @param type $url
	 * @return type
	 */
	function find($url){
		foreach($this->rules as $rule){
			if($rule->test($url)){
				return $rule;
			}
		}
		$this->default->setUrl($url);
		return $this->default;
	}
	
	/**
	 * adds new rule to list
	 * @param RoutingRule $rule
	 */
	function add(RoutingRule $rule){
		$this->rules[] = $rule;
	}
}
