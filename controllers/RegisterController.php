<?php

/**
 * Lychez : Image database (https://lychez.luvirx.io)
 * Copyright (c) luvirx (https://luvirx.io)
 *
 * Licensed under The MIT License
 * For the full copyright and license information, please see the LICENSE.md
 * Redistributions of the files must retain the above copyright notice.
 *
 * @link 		https://lychez.luvirx.io Lychez Project
 * @copyright 	Copyright (c) 2016 luvirx (https://luvirx.io)
 * @license		https://opensource.org/licenses/mit-license.php MIT License
 */

require_once ('Controller.php');

/**
 * Handles the registration of a new user.
 */
class RegisterController extends Controller{

	/**
	 * Displays a custom header.
	 */
	public function __construct() {
		$view = new View ( 'general/head', array (
				"title" => "Register - lychez.ch"
		) );
		$view->display ();
		$view = new View ( 'general/header' );
		$view->display ();
	}

	/**
	 * Displays the registration form.
	 */
	public function index() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {

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

	/**
	 * Performs the registration of a new user.
	 */
	public function doRegister() {
		if (isset ( $_POST ['register'] )) {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
      $validator = new Validator();

			$formValues = $this->getFormValues ();

			$firstNameValid = $validator->isValid ( "/^[a-zA-Z0-9.-]{0,45}$/", $formValues ['firstName'] );
			$lastNameValid = $validator->isValid ( "/^[a-zA-Z0-9.-]{0,45}$/", $formValues ['lastName'] );
			$userNameValid = $validator->isValid ( "/^[a-zA-Z0-9.]{3,45}$/", $formValues ['userName'] );
			$emailValid = $validator->isValid ( "/^[A-Z0-9\._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i", $formValues ['email'] );
			$passwordValid = $validator->isValid ( "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $formValues ['password'] );
			$password2Valid = $validator->isValid ( "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $formValues ['password2'] );

			if ($firstNameValid && $lastNameValid && $userNameValid && $emailValid && $passwordValid && $password2Valid) {
				$userModel = new UserModel ();
				if (! $userModel->readIsEmailUsed( $formValues ['email'] )) {
					if (! $userModel->readIsUsernameUsed ( $formValues ['userName'] )) {
						if ($formValues ['password'] == $formValues ['password2']) {
							// Insert the new user in the db.
							$userModel->create ( $formValues ['firstName'], $formValues ['lastName'], $formValues ['userName'], $formValues ['email'], $formValues ['password'] );
							$id = $userModel->readIdByUsername($formValues['userName']);
							if (!file_exists('./userHomes/'.$id)) {
								mkdir('./userHomes/'.$id.'/photos', 0777, true);
								mkdir('./userHomes/'.$id.'/thumbnails', 0777, true);
							}

							// Login the user.
							if (session_status() == PHP_SESSION_NONE) {
								session_start();
							}
							session_regenerate_id();
							$_SESSION ['userName'] = $formValues ['userName'];
                            $_SESSION['lastActivity'] = time();
                            $_SESSION['lastSessionUpdate'] = time();
							$_SESSION ['loggedIn'] = true;

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

    /**
     * @return array All values of the registration form.
     */
	private function getFormValues() {
		$values = array (
				'firstName' => (isset ( $_POST ['firstName'] ) ? htmlspecialchars($_POST ['firstName']) : ""),
				'lastName' => (isset ( $_POST ['lastName'] ) ? htmlspecialchars($_POST ['lastName']) : ""),
				'userName' => (isset ( $_POST ['userName'] ) ? $_POST ['userName'] : ""),
				'email' => (isset ( $_POST ['email'] ) ? htmlspecialchars($_POST ['email']) : ""),
				'password' => (isset ( $_POST ['password'] ) ? $_POST ['password'] : ""),
				'password2' => (isset ( $_POST ['password2'] ) ? $_POST ['password2'] : "")
		);
		return $values;
	}

    /**
     * Clear the post values.
     */
	private function clearFormValues() {
		$POST ['firstName'] = "";
		$POST ['lastName'] = "";
		$POST ['userName'] = "";
		$POST ['email'] = "";
		$POST ['password'] = "";
		$POST ['password2'] = "";
	}
}
