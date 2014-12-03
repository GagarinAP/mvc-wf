<?php

class MsgController extends Controller {
    
    function index(){
        p('hello msg!!!');
    }
    
    function fulllist(){
        // load model, get data
        $model = Wf::model('messages');
        $list = $model->all(0, 100, true, 'DESC');
        
        // load view, and render
        $view = Wf::view('messages/list', ['list' => $list]);
        $listContent = $view->render();
        //print $listContent;
        
        // use view content as part of main view
        $title = 'All messages';
        Wf::view('main', ['title' => $title, 'content' => $listContent])->render(true);
    }
    
}