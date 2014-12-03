<?php

class LoginController extends Controller {
    
    private $loginRule = '#^[a-zA-Z][\w\-]{2,31}$#';
    private $emailRule = '#^[\w\-\.]+@([\w\-]+\.)+[a-z]{2,4}$#';
    private $passRule = '#^[\w\-!@]{3,16}$#';
    
    function index(){
        $this->form();
    }
    
    function register($warning=null){
        $data = [
            'login' => !empty($_POST) ? Wf::post('login') : '',
            'email' => !empty($_POST) ? Wf::post('email') : ''
        ];
        $view = Wf::view("login/reg_form", $data);
        if($warning){
            $view->warning = $warning;
        }
        Wf::view('main', ['content' => $view->render(), 'title' => 'Register'])->render(true);
    }
    
    function reg_handler(){
        //  проверка входящих данных
        $login = Wf::post('login');
        $email = Wf::post('email');
        $pass = Wf::post('pass');
        $pass2 = Wf::post('pass2');
        
        if(! preg_match($this->loginRule, $login)){
            return $this->register("Incorrect login!");
        }
        if(!preg_match($this->emailRule, $email)){
            return $this->register("Incorrect email!");
        }
        if($pass == ''){
            return $this->register("Password can't be empty!");
        }
        if($pass != $pass2){
            return $this->register("Password confirmation is not correct!");
        }
        if(! preg_match($this->passRule, $pass)){
            return $this->register("Incorrect password!");
        }
        
        $model = Wf::model('users');
        // проверка уникальности login, email
        // добавление новой записи в БД
        // hash: md5, sha1, sha512
        //p(strlen($model->hashPass($pass)));
		
        $res = $model->create([
            'login' => $login,
            'email' => $email,
            'password' => $pass
        ]);
        
        if(! $res['success']){
             return $this->register($res['msg']);
        }
        
        header('location:'.Wf::conf('base_domain').'/login');
        
    }
    
    function form($warning=null){
        $data = [];
        if($warning){
            $data['warning'] = $warning;
        }
        $content = Wf::view("login/form", $data)->render();
		Wf::view('main', ['content' => $content, 'title' => 'Login'])->render(true);
    }
    
    function handler(){
        $login = Wf::post('login');
        $pass = Wf::post('pass');
        $warning = "No same login or password.";
        if(! preg_match($this->loginRule, $login)){
            return $this->form($warning);
        }
        if(! preg_match($this->passRule, $pass)){
            return $this->form($warning);
        }
        
        $model = Wf::model('users');
        $res = $model->checkAuth($login, $pass);
        if(count($res) == 0){
            sleep(10);
            return $this->form($warning);
        }
        $id = $res[0]->id;
        //p($userData); return;
        $userData = $model->read($id);
        
        $_SESSION['user_id'] = $userData->id;
        $_SESSION['user_login'] = $userData->login;
        
        
        $key = $model->hashPass('dsf.k;gh589tuedhspe58' . microtime() . mt_rand());
        $model->update($userData->id, ['authkey' => $key]);
        $this->longTimeAuth($key);
        
        header('location:'.Wf::conf('base_domain').'/main');
    }
    
    private function longTimeAuth($hashKey){
        setcookie('auth_key', $hashKey, Wf::conf('auth_key_life') + time(), '/');
    }
    
}