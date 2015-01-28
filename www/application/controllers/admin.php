<?php

class AdminController extends Controller {
	
	function __construct(){
		if(! User::current()->logged){
			Wf::redirect('/login?redirect=admin');
		}
	}
}