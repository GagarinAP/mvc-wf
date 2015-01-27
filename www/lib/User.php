<?php

class User {
	protected $uData = null;
	protected static $current = null;
	
	function __construct($id, $login){
		$this->uData = [
			'id' => $id,
			'login' => $login
		];
	}
	
	static function current(){
		if( ! (self::$current instanceof User) ){
			if(isset($_SESSION['user_id'])){
				self::$current = new User($_SESSION['user_id'], $_SESSION['user_login']);
			} else {
				self::$current = new User(null, null);
			}
		}
		return self::$current;
	}
	
	function __get($key){
		if($key == 'logged'){
			return is_array($this->uData) 
				&& isset($this->uData['id'])
				&& ! is_null($this->uData['id']);
		}
		if(!is_array($this->uData)){
			return null;
		}
		return (isset($this->uData[$key])) ? $this->uData[$key] : null;
	}
}