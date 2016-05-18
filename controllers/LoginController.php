<?php
require_once ('models/UserModel.php');
class LoginController {
	public function __construct() {
		$view = new View ( 'head', array (
				"title" => "Home - lychez.ch" 
		) );
		$view->display ();
		$view = new View ( 'header' );
		$view->display ();
	}
	public function index() {
		$email = (isset ( $_POST ['email'] ) ? $_POST ['email'] : "");
		
		$view = new View ( 'main_start', array (
				"heading" => "Login" 
		) );
		$view->display ();
		$view = new View ( 'login_index', $email );
		$view->display ();
		$view = new View ( 'main_end' );
		$view->display ();
	}
	public function doLogin() {
		if (isset ( $_POST ['login'] )) {
			session_start ();
			// Get the values of the Form.
			$formValues = $this->getFormValues ();
			$emailValid = ($this->isFieldValid ( "/^[A-Z0-9\._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i", $formValues ['email'] ) || $this->isFieldValid ( "/^[a-zA-Z0-9.]{3,45}$/", $formValues ['email'] ));
			$passwordValid = $this->isFieldValid ( "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $formValues ['password'] );
			if ($emailValid && $passwordValid) {
				$userModel = new UserModel ();
				if ($userModel->readIsEmailUsed ( $formValues ['email'] ) || $userModel->readIsUsernameUsed( $formValues ['email'] )) {
					if (password_verify ( $formValues ['password'], $userModel->readPasswordByEmail ( $formValues ['email'] ) ) || password_verify ( $formValues ['password'], $userModel->readPasswordByUsername( $formValues ['email'] ) )) {
						// Login the user.
						session_start ();
						$_SESSION ['userName'] = $formValues ['userName'];
						$_SESSION ['loggedIn'] = true;
						
						// Clear the Form fields.
						$this->clearFormValues ();
						header ( 'Location: /home' );
					} else {
						header ( 'Location: /login' );
					}
				} else {
					header ( 'Location: /login' );
				}
			} else {
				header ( 'Location: /login' );
			}
		} else {
			header ( 'Location: /login' );
		}
	}
	private function getFormValues() {
		$values = array (
				'email' => (isset ( $_POST ['email'] ) ? $_POST ['email'] : ""),
				'password' => (isset ( $_POST ['password'] ) ? $_POST ['password'] : "") 
		);
		return $values;
	}
	private function clearFormValues() {
		$POST ['email'] = "";
		$POST ['password'] = "";
	}
	private function isFieldValid($regex, $value) {
		if (preg_match ( $regex, $value )) {
			return true;
		} else {
			return false;
		}
	}
	public function __destruct() {
		$view = new View ( 'footer' );
		$view->display ();
		$view = new View ( 'foot' );
		$view->display ();
	}
}
