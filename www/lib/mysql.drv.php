<?php


class MysqlDriver extends PDO{

	private $lastQueryStatus = false;

	function query($sql, $params = array()){
            //p($sql); p($params);
		$stat = $this->prepare($sql); // get PdoStatement object
		$this->lastQueryStatus = $stat->execute($params);
		return $stat; // ->fetchAll(PDO::FETCH_CLASS);
	}

	function select($sql, $params = array(), $isObj = true){
		$res = $this->query($sql, $params);
		$resType = $isObj ? PDO::FETCH_OBJ : PDO::FETCH_ASSOC;
		if($this->lastQueryStatus)
			return $res->fetchAll($resType); // method from PdoStatement
		return array();
	}

	function insert($sql, $params = array()){
		$res = $this->query($sql, $params);
		if($this->lastQueryStatus){
			return $this->lastInsertId(); // method from PDO
		}
		return null;
	}

	function update($sql, $params = array()){
		$res = $this->query($sql, $params);
		if($this->lastQueryStatus)
			return $res->rowCount(); // method from PdoStatement
		return 0;
	}

	function delete($sql, $params = array()){
		return $this->update($sql, $params);
	}

	function parent_query($a, $b=null, $c=null){
		return parent::query($a, $b, $c);
	}
}


/*
$db = new MyDB('mysql:dbname=db_lessons;host=localhost', 'root', '');
$data = $db->query("SELECT * FROM users WHERE login = :login ",
[':login' => $_GET['login']]);

*/