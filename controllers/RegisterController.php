<?php
require_once ('models/UserModel.php');

class RegisterController {
	
	public function __construct() {
		$view = new View ( 'general/head', array (
				"title" => "Register - lychez.ch" 
		) );
		$view->display ();
		$view = new View ( 'general/header' );
		$view->display ();
	}
	
	public function index() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
			// Get the values of the Form.
			$formValues = $this->getFormValues();

			$view = new View ('general/main_start', array(
				"heading" => "Register"
			));
			$view->display();
			$view = new View ('register/index', array(
				"firstName" => $formValues ['firstName'],
				"lastName" => $formValues ['lastName'],
				"userName" => $formValues ['userName'],
				"email" => $formValues ['email']
			));
			$view->display();
			$view = new View ('general/main_end');
			$view->display();
		} else {
			header ( 'Location: /home' );
		}
	}
	
	
	public function doRegister() {
		// Check if the submit button of the register form was pressed.
		if (isset ( $_POST ['register'] )) {
			session_start ();
			// Get the values of the Form.
			$formValues = $this->getFormValues ();
			
			$firstNameValid = $this->isFieldValid ( "/^[a-zA-Z0-9.-]{0,45}$/", $formValues ['firstName'] );
			$lastNameValid = $this->isFieldValid ( "/^[a-zA-Z0-9.-]{0,45}$/", $formValues ['lastName'] );
			$userNameValid = $this->isFieldValid ( "/^[a-zA-Z0-9.]{3,45}$/", $formValues ['userName'] );
			$emailValid = $this->isFieldValid ( "/^[A-Z0-9\._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i", $formValues ['email'] );
			$passwordValid = $this->isFieldValid ( "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $formValues ['password'] );
			$password2Valid = $this->isFieldValid ( "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $formValues ['password2'] );
			
			if ($firstNameValid && $lastNameValid && $userNameValid && $emailValid && $passwordValid && $password2Valid) {
				$userModel = new UserModel ();
				if (! $userModel->readIsEmailUsed( $formValues ['email'] )) {
					if (! $userModel->readIsUsernameUsed ( $formValues ['userName'] )) {
						if ($formValues ['password'] == $formValues ['password2']) {
							// Insert the new user in the db.
							$userModel->create ( $formValues ['firstName'], $formValues ['lastName'], $formValues ['userName'], $formValues ['email'], $formValues ['password'] );
							$id = $userModel->readIdByUsername($formValues['userName']);
							if (!file_exists('./userHomes/'.$formValues ['userName'])) {
								mkdir('./userHomes/'.$id.'/photos', 0777, true);
								mkdir('./userHomes/'.$id.'/thumbnails', 0777, true);
							}

							// Login the user.
							session_start ();
							$_SESSION ['userName'] = $formValues ['userName'];
							$_SESSION ['loggedIn'] = true;
							
							// Clear the Form fields.
							$this->clearFormValues ();
							header ( 'Location: /photos' );
						} else {
							header ( 'Location: /register' );
						}
					} else {
						header ( 'Location: /register' );
					}
				} else {
					header ( 'Location: /register' );
				}
			} else {
				header ( 'Location: /register' );
			}
		} else {
			header ( 'Location: /register' );
		}
	}
	
	private function getFormValues() {
		$values = array (
				'firstName' => (isset ( $_POST ['firstName'] ) ? $_POST ['firstName'] : ""),
				'lastName' => (isset ( $_POST ['lastName'] ) ? $_POST ['lastName'] : ""),
				'userName' => (isset ( $_POST ['userName'] ) ? $_POST ['userName'] : ""),
				'email' => (isset ( $_POST ['email'] ) ? $_POST ['email'] : ""),
				'password' => (isset ( $_POST ['password'] ) ? $_POST ['password'] : ""),
				'password2' => (isset ( $_POST ['password2'] ) ? $_POST ['password2'] : "") 
		);
		return $values;
	}
	
	private function clearFormValues() {
		$POST ['firstName'] = "";
		$POST ['lastName'] = "";
		$POST ['userName'] = "";
		$POST ['email'] = "";
		$POST ['password'] = "";
		$POST ['password2'] = "";
	}
	
	private function isFieldValid($regex, $value) {
		if (preg_match ( $regex, $value )) {
			return true;
		} else {
			return false;
		}
	}
	
	public function __destruct() {
		$view = new View ( 'general/footer' );
		$view->display ();
		$view = new View ( 'general/foot' );
		$view->display ();
	}
}
