<?php

class HomeController
{
	public function __construct()
	{
		$view = new View('general/head',array("title" => "Home - lychez.ch"));
		$view->display();
		$view = new View('general/header');
		$view->display();
	}

	public function index()
	{
		$view = new View('general/main_start', array("heading" => "Home"));
		$view->display();
		$view = new View('home/index');
		$view->display();
		$view = new View('general/main_end');
		$view->display();
	}

	public function __destruct()
	{
		$view = new View('general/footer');
		$view->display();
		$view = new View('general/foot');
		$view->display();
	}
}
