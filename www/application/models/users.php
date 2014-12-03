<?php

/**
 * using:
 *  $model = Wf::model('users');
 *  $info = $model->create(array('name'=>'Vasya', 'login'=>'vasya', 'pass'=>'123', 'email'=>'vasya@test.local'));
 */

class UsersModel extends Model{

	private $hashSalt = 'qwerty-salt!';

	function __construct(){
		parent::__construct('users');
	}

	function create($data){
		if(! $this->checkUnique($data['login'], $data['email'])){
			return array('success' => false, 'msg' => 'same user (login or email)) already created');
		}
		if(isset($data['id']))
			unset($data['id']);
		if(isset($data['password'])){
			$data['password'] = $this->hashPass($data['password']);
		}
		$id = parent::create($data);
		return array('success' => true, 'id' => $id);
	}

	function checkUnique($login, $email){
            $res = $this->db->select("SELECT id FROM `{$this->table}` WHERE login = ? OR email = ?", array($login, $email ));
            return (0 == count ($res));
	}

	function checkAuth($login, $pass){
           // p($this->hashPass($pass));
            $res = $this->db->select("SELECT id FROM `{$this->table}` WHERE login = ? AND password = ?",
                    array($login, $this->hashPass($pass) ));
            //p($res);
            return $res;
	}

	function hashPass($pass){
		$res = hash_hmac('sha512', $pass, Wf::conf('pass_hash_salt'));
		//p($res);
		return $res;
	}
        
        function checkByCookie($key){
            $res = $this->db->select("SELECT * FROM `{$this->table}` WHERE authkey = ?;", array($key));
            if(empty($res))
                return false;
            return $res[0];
        }

}
