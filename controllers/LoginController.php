<?php
require_once ('models/UserModel.php');

class LoginController {
	public function __construct() {
		$view = new View ( 'general/head', array (
				"title" => "Login - lychez.ch"
		) );
		$view->display ();
	}
	
	public function index() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
            $formValues = $this->getFormValues();

            $view = new View ('general/main_start', array(
                "heading" => "Login"));
            $view->display();
            $view = new View ('login/index', array(
                "email" => $formValues['email']));
            $view->display();
            $view = new View ('general/main_end');
            $view->display();
        } else {
            header ( 'Location: /home' );
        }
	}
	
	public function doLogin() {
		if (isset ( $_POST ['login'] )) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
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
                        $id = (strpos($formValues['email'], '@') !== false ? $userModel->readIdByEmail($formValues['email']): $userModel->readIdByUsername($formValues['email']));
						$_SESSION ['userName'] = $userModel->readUserNameById($id);
						$_SESSION ['loggedIn'] = true;
						
						// Clear the Form fields.
						$this->clearFormValues ();
						header ( 'Location: /photos' );
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
		$view = new View ( 'general/foot' );
		$view->display ();
	}
}
