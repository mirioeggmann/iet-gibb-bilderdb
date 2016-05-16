<?php

require_once('models/UserModel.php');

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
		// Get the values of the Form.
		$formValues = $this->getFormValues();

		print_r($formValues);

		$view = new View('main_start', array("heading" => "Register"));
		$view->display();
		$view = new View('register_index', array("firstName" 	=> $formValues['firstName'],
																						 "lastName" 	=> $formValues['lastName'],
																						 "userName" 	=> $formValues['userName'],
																						 "email" 			=> $formValues['email']));
		$view->display();
		$view = new View('main_end');
		$view->display();
	}

  public function doRegister()
  {
		// Check if the submit button of the register form was pressed.
		if (isset($_POST['register'])) {
			session_start();
			// Get the values of the Form.
			$formValues = $this->getFormValues();

			// Insert the new user in the db.
			$userModel = new UserModel();
			$userModel->create($formValues['firstName'], $formValues['lastName'], $formValues['userName'], $formValues['email'], $formValues['password']);

			// Login the user.
			session_start();
			$_SESSION['userName'] = $userName;
			$_SESSION['loggedIn'] = true;

			if (false) {
				// Clear the Form fields.
				$this->clearFormValues();

				header('Location: /home');
			} else {
				header('Location: /register');
			}
		} else {
			header('Location: /register');
		}
  }

	private function getFormValues() {
		$values = array(
			'firstName' => (isset($_POST['firstName'])? $_POST['firstName'] : ""),
			'lastName'  => (isset($_POST['lastName'])? $_POST['lastName'] : ""),
			'userName'  => (isset($_POST['userName'])? $_POST['userName'] : ""),
			'email'     => (isset($_POST['email'])? $_POST['email'] : ""),
			'password'  => (isset($_POST['password'])? $_POST['password'] : ""),
			'password2' => (isset($_POST['password2'])? $_POST['password2'] : "")
		);
		return $values;
	}

	private function clearFormValues() {
		$POST['firstName'] = "";
		$POST['lastName'] = "";
		$POST['userName'] = "";
		$POST['email'] = "";
		$POST['password'] = "";
		$POST['password2'] = "";
	}

	public function __destruct()
	{
		$view = new View('footer');
		$view->display();
		$view = new View('foot');
		$view->display();
	}
}
