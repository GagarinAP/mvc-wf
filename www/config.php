<?php

$config = array(

	'base_path' => '', // base path of index.php
	'protocol' => 'http',
	
	// data base options
	'db' => array(
		'driver' => 'mysql',
		'name' => 'test_mvc_wf',
		'user' => 'root',
		'pass' => '',
		'host' => 'localhost',
		'port' => '3306',
		'charset' => 'utf-8'
	),
	
	// default values for routing:
	'default_controller' => 'main',
	'default_method' => 'index',
	'pages.service.404' => 'page404',
	
	// use or no any Routing Rules.
	// false - use simple pattern: /<controller>/<method>/<param1>/<param2>... /<paramN>
	// true - use next block of rules.
	'routing.use_rules' => true,
	
	// list of rules, they should be implementations of RoutingRule interface.
	// rules checks one by one, until wouldn't be found first match of current url.
	// so order of rules is important
	'routing.rules'		=> array(
		new RoutingRegexRule('#^/test-routing(?:/([^/?]+))?(?:/([^/?]+))?$#', ['c' => 'test', 'm' => 'routing_class', 'p1' => 1, 'p2' => 2]),
		new RoutingRegexRule('#^/test-routing-second\b#', ['c' => 'test', 'm' => 'routing_class', 'p1' => 'second', 'p2' => 'rule'])
	),
    
        // server info
	'base_domain' => 'http://mvc-loc.com',
	
	'cache_storage_dir' => DOC_ROOT . '/cache',
	
        // security properties
	'pass_hash_salt' => '100500-qwerty-salt!', // salt for user passwords hashing
	'auth_key_life' => 3600 * 24 * 30

);


