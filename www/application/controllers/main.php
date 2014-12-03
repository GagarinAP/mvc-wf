<?php

class MainController extends Controller{
	
	function index(){
            print Wf::view('main')->render();
	}
        
        function hello(){
            p('<div style="border: 1px solid #ccc; color: #800;">Welcome to the best of the best MAIN controller, noob!</div>');
        }
	
}