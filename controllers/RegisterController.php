<?php

class RegisterController
{
	public function __construct()
	{
		$view = new View('head',array("title" => "Register - lychez.ch"));
		$view->display();
		$view = new View('header');
		$view->display();
	}

	public function index()
	{
		$view = new View('main_start', array("heading" => "Register"));
		$view->display();
		$view = new View('register_index');
		$view->display();
		$view = new View('main_end');
		$view->display();
	}

  public function doRegister()
  {

  }

	public function __destruct()
	{
		$view = new View('footer');
		$view->display();
		$view = new View('foot');
		$view->display();
	}
}
