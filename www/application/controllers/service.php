<?php

class ServiceController extends Controller{

	function page404($page=''){
		print "404 error. Page $page no found!";
	}
}