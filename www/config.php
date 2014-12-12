<?php

$config = array(

	'base_path' => '/', // base path of index.php
	
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
    
        // server info
	'base_domain' => 'http://mvc-loc.com',
	
	'cache_storage_dir' => DOC_ROOT . '/cache',
	
        // security properties
	'pass_hash_salt' => '100500-qwerty-salt!', // salt for user passwords hashing
	'auth_key_life' => 3600 * 24 * 30

);
