<?php

class ArticleController extends Controller {
    
    function index(){
        // show all articles
		$this->all();
    }
    
    function create(){
        // show form
        $this->form();
    }
    
    function edit($id){
        // show form
        $id = intval($id);
        $this->form($id);
    }
    
    private function form($id = null){
        if($id){
            // case for edit
            $model = Wf::model('articles');
            $art = $model->read($id);
            if(!$art){
                return "No same atricles!";
            }
        } else {
            // case for create
            $art = (object) [
                'id' => '',
                'title' => '',
                'content' => ''
            ];
        }
        
        Wf::view('articles/form', ['art' => $art])->render(1);
    }
    
    function handler(){
        if(! isset($_SESSION['user_id'])){
            header('location:'. Wf::conf('base_domain') .'/login');
            return;
        }
        
        $artId = Wf::post('art_id');
        $model = Wf::model('articles');
        $data = $this->getFormData();
        $data['user_id'] = $_SESSION['user_id'];
        if($artId){
            // update
            $res = $model->update($artId, $data);
            if($res){
                p("article <a href='/article/view/$artId'>{$data['title']}</a> updated");
            }
        } else {
            // create
            $data['date_created'] = time();
            $artId = $model->create($data);
            p("created article <a href='/article/view/$artId'>{$data['title']}</a>");
        }
		//$this->view($artId);
		Wf::redirectTo("/article/view/{$artId}");
    }
    
    private function getFormData(){
        $fields = ['title', 'content'];
        $data = [];
        foreach($fields as $field){
            $val = Wf::post($field);
            if($val === null){
                $val = '';
            }
            $data[$field] = $val;
        }
        return $data;
    }
    
    function view($id){
        $model = Wf::model('articles');
        $art = $model->read($id);
        print "<h3>{$art->title}</h3><div>{$art->content}</div>";
    }
    
    function all(){
        $model = Wf::model('articles');
        $list = $model->all(0, 100, true, 'desc');
		$table = Wf::view('articles/list', ['list' => $list])->render();
		Wf::view('main', ['content' => $table])->render(1);
    }
}
