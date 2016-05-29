<?php

class LogoutController
{
	public function __construct()
	{
    $view = new View('general/head',array("title" => "Logout - lychez.ch"));
		$view->display();
		$view = new View('general/header');
		$view->display();
	}

	public function index()
	{
    $this->doLogout();
	}

  public function doLogout()
  {

    // Initialize the session.
    session_start();

    // Remove all session variables.
    session_unset();

    // Snippet to delete session cookies properly - https://wwww.owasp.org/index.php/PHP_Security_Cheat_Sheet
    // ----
    setcookie(session_name(), "", 1);
    setcookie(session_name(), false);
    unset($_COOKIE[session_name()]);
    // ----

    //Destroy the session.
    session_destroy();

    header('Location: /home');
  }

	public function __destruct()
	{
    $view = new View('general/footer');
		$view->display();
		$view = new View('general/foot');
		$view->display();
	}
}
