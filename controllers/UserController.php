<?php

class UserController
{
	public function __construct()
	{
		$view = new View('head',array("title" => "User - lychez.ch"));
		$view->display();
		$view = new View('header');
		$view->display();
	}

	public function index()
	{
    session_start();
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
      $view = new View('main_start', array("heading" => "User"));
  		$view->display();
  		$view = new View('user_index');
  		$view->display();
  		$view = new View('main_end');
  		$view->display();


      
      print_r($_SESSION);
    } else {
      header('Location: /home');
    }
	}

	public function __destruct()
	{
		$view = new View('footer');
		$view->display();
		$view = new View('foot');
		$view->display();
	}
}
