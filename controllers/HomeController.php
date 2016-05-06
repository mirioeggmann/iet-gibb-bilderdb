<?php

class HomeController
{
	public function __construct()
	{
		$view = new View('head',array("title" => "Home - lychez.ch"));
		$view->display();
		$view = new View('header');
		$view->display();
	}

	public function index()
	{
		$view = new View('main_start', array("heading" => "Starter Template"));
		$view->display();
		$view = new View('home_index');
		$view->display();
		$view = new View('main_end');
		$view->display();
	}

	public function __destruct()
	{
		$view = new View('footer');
		$view->display();
		$view = new View('foot');
		$view->display();
	}
}
