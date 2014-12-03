<?php

class UsersController extends Controller {

	function __construct(){

	}

	function index(){
		return $this->all();
	}

	function all(){
		$model = Wf::model('users');
		$info = $model->all(0, 100, false);
		$tab = html_table($info, array('td'=>'border:1px solid gray;','th'=>'border:1px solid gray;','table'=>'border:1px solid gray;'));
		$view = Wf::view('main', array('table' => $tab));
		$view->render(true);
	}
	
	function test1($a='', $b='', $c=''){
		p('Users - > test 1 ');
		p("A = $a, B = $b, C = $c!!! " . $this->hello());
		
	}
	
	function test2(){
		$model = Wf::model('test');
		$model->fillByCount(20);
		$data = $model->all(0, 20, false);
		$tab = html_table($data, array('td'=>'border:1px solid gray;','th'=>'border:1px solid gray;','table'=>'border:1px solid gray;'));
		$view = Wf::view('test');
		$view->setData(array('table' => $tab));
		$html = $view->render();
		print $html;
	}
	
	private function hello(){
		return 'Hello, world!';
	}
	
	function reg(){
		if(! empty($_POST))
			return $this->regHandler();
		return $this->regForm();
	}
	
	function regForm(){
		Wf::view('users/reg_form')->render(1);
	}
	
	function regHandler(){
		$fields = array('login', 'pass', 'email');
		
		$data = array();
		foreach($fields as $field){
			if(! isset($_POST[$field]))
				return $this->regForm();
			$val = $_POST[$field];
			if(! $this->checkUserInput($field, $val))
				return $this->regForm();
			$data[$field] = $_POST[$field];
		}
		$model = Wf::model('users');
		$info = $model->create($data);
		p($info);
	}
	
	private function checkUserInput($field, $val){
		return true;
	}
	
}
