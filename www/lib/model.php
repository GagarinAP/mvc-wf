<?php

class Model {

	protected $db = null;

	protected $table;
//	private $field = [];

	function __construct($table){
		$this->table = $table;
		$info = Wf::conf('db');
		$driverName = $info['driver'];
		$classDriver = ucfirst($driverName) . 'Driver';
		if(!class_exists($classDriver))
			die("Current db type [{$classDriver}] has no driver!");
		// 'mysql:dbname=db_lessons;host=localhost'
		$this->db = new $classDriver("$driverName:dbname={$info['name']};host={$info['host']}", $info['user'], $info['pass']);
                $this->db->query("SET NAMES UTF8;");
	}

// [name => Vasya, age => 25]
	function create($data){
		$keys = array_keys($data);
		$fields = "`".implode("`,`", $keys)."`" ; // `name`,`age`
		$values = substr(str_repeat('?,', count($keys)), 0, -1) ; // ?, ?
		$sql = "INSERT INTO `{$this->table}` ({$fields}) VALUES ({$values}); ";
		$sqlData = array_values($data);
		return $this->db->insert($sql, $sqlData);
	}

// 1
	function read($id){
		$sql = "SELECT * FROM `{$this->table}` WHERE `id` = ?; ";
                $res = $this->db->select($sql, array($id));
		return count($res) > 0 ? $res[0] : null;
	}

	function update($id, $data){
// UPDATE {table} SET field1 = ?, field2 = ?
		$fields = '';
		$sqlData = array();
		foreach($data as $key => $val){
			$fields = "`{$key}` = ?,";
			$sqlData[] = $val;
		}
		$fields = substr($fields, 0 , -1);

		$sql = "UPDATE `{$this->table}` SET $fields WHERE `id` = ?";
		$sqlData[] = $id;
//return;
		return $this->db->update($sql, $sqlData);
	}

	function delete($id){
		$sql = "DELETE FROM `{$this->table}` WHERE `id` = ? ";
		return $this->db->delete($sql, array($id));
	}

	function all($offset=0, $limit=100, $isObj = true, $order = 'ASC'){
		if(! in_array(strtolower($order), ['asc', 'desc'])){
			$order = 'asc';
		}
		$offset = intval($offset);
		$limit = intval($limit);
		return $this->db->select("SELECT * FROM `{$this->table}` ORDER BY `id` {$order} LIMIT $offset, $limit", array(), $isObj);
	}

}