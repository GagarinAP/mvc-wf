<?php

class TestModel extends Model {

	function __construct(){
		parent::__construct('test');
	}
	
	function fillByCount($x){
		$this->db->delete("DELETE FROM `{$this->table}` ;");
		for ($i = 0; $i < $x; ++$i){
			$data = array(
				'User' . $i,
				'Val_' . $i * 1000,
				substr($this->hashRand($i) , 0, 32)
			);
			$this->db->insert("INSERT INTO `{$this->table}` 
			(`name`, `value`, `key`) 
			VALUES (?, ?, ?) ", $data);
		}
	}
	
	function hashRand($x){
		$res = hash_hmac('sha512', $x , '__' . microtime());
		return $res;
	}
	
}