<?php

class TestController extends Controller {
    
    function index(){
        p("Hello my dier test controller!");
        if(isset($_SESSION['user_id'])){
           p("User login from session : " . $_SESSION['user_login']);
        } else {
            $authKey = filter_input(INPUT_COOKIE, 'auth_key'); // $_COOKIE
            if($authKey){
                $userData = Wf::model('users')->checkByCookie($authKey);
                if($userData !== false){
                    p("User from cookies: {$userData->login}");
                    $_SESSION['user_id'] = $userData->id;
                    $_SESSION['user_login'] = $userData->login;
                }
            } else {
                p('<a href="/login">Go to login, man</a>');
            }
        }
		$methods = get_class_methods($this);
		unset($methods[array_search('index', $methods)]);
		$methods = array_values($methods);
		//p($methods);
		print "\n<div>tests:<br>";
		foreach($methods as $meth){
			print "<div><a href='/test/$meth'>$meth</a></div>\n";
		}
		print "</div>\n";
    }
    
    function test_tpl(){
        $data = array(
            'title' => 'Test main page'
        );
        $view = Wf::view('tests/main_test', $data);
        
        $content = "lorem ipsum dolor";
        
        $view->pageContent = $content;
        
        $html = $view->render();
        
        print $html;
    }
    
    function test123($x=123, $y = 'qwerty', $z = 'Vasya'){
            $message = 'Hello 123 test! x = ' . "$x $y $z";
            $view = Wf::view('main_test123');
            $view->setData(array('msg' => $message, 'title' => 'Test 123'));
            $view->userName = $z;
            $html = $view->render(true);
            //print $html;
    }
    
    function mdhash($str=null){
		if(is_null($str))
			return p('no param :(');
        for($i=0; $i<5; ++$i){
            ob_start();
            p($i);
            ob_flush();
            flush();
            sleep(1);
        }
            
        $salt = 'd.fkjge984w5t kjehfgpei4t513;kj4nr';
        print md5(md5($str). $salt );
    }
    
    function server(){
        p($_SERVER['HTTP_HOST']);
    }
	
	function cache(){
		$data = ['name'=>'Vasya', 'noname'=>'Asya', 'x-name'=>'Nasya'];
		Wf::cache('test/test2/test3')->save('data01', $data);
		
		$data2 = Wf::cache()->get('data01');
		p($data2);
	}
	
	function routing_class($p1, $p2){
		p("Test: routing [$p1, $p2]");
		p(Wf::subUrl('/contr/func/param1/param2'));
	}
	
	function get_mail(){
		p('<a href="/test">return to test</a>');
		p(file_get_contents('http://mail.ru'));
	}
	
	function view_import(){
		Wf::view('tests/extra_tpl', ['title'=>'test of view import',
			'names'=>['Mery', 'John', 'Ricardo', 'Vasya'],
			'name'=>'Superman'])->render(1);
	}
	
	function cookie(){
		$val = Wf::cookie('test_wf');
		p("stored: $val");
		Wf::cookie('test_wf', 1, 1);
		Wf::cookie('test_wf', 'test_' . time(), [5, Wf::TIME_UNIT_MIN]);
	}
}
