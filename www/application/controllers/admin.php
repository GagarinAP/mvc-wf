<?php

class AdminController {
	
	function __construct(){
		if(! User::current()->logged){
			Wf::redirect('/login?redirect=admin');
		}
	}
}