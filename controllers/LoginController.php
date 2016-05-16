<?php

class LoginController
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
    $email = (isset($_POST['email'])? $_POST['email'] : "");

		$view = new View('main_start', array("heading" => "Login"));
		$view->display();
		$view = new View('login_index', $email);
		$view->display();
		$view = new View('main_end');
		$view->display();
	}

  public function doLogin()
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
