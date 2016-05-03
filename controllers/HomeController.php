<?php

class HomeController
{
	public function __construct()
	{
		$view = new View('header', array('title' => 'Startseite', 'heading' => 'Startseite'));
		$view->display();
	}

	public function index()
	{
		$view = new View('default_index');
		$view->display();
	}

	public function __destruct()
	{
		$view = new View('footer');
		$view->display();
	}
}
