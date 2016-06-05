<?php

require_once ('models/UserModel.php');
require_once ('libraries/FileService.php');

class UserController {
	public function __construct() {
		$view = new View ( 'general/head', array (
				"title" => "User - lychez.ch" 
		) );
		$view->display ();
		$view = new View ( 'general/header' );
		$view->display ();
	}
	public function index() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {

			$userModel = new UserModel();
			$user = $userModel->readById($userModel->readIdByUsername($_SESSION['userName']));

			$view = new View ( 'general/main_start', array (
				"heading" => "User"
			) );
			$view->display ();
			$view = new View ( 'user/index', array(
				"user" => $user
			) );
			$view->display ();
			$view = new View ( 'general/main_end' );
			$view->display ();
		} else {
			header ( 'Location: /home' );
		}
	}

	public function edit() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {

			$userModel = new UserModel();
			$user = $userModel->readById($userModel->readIdByUsername($_SESSION['userName']));

			$view = new View ( 'general/main_start', array (
				"heading" => "User"
			) );
			$view->display ();
			$view = new View ( 'user/edit', array(
				"user" => $user
			) );
			$view->display ();
			$view = new View ( 'general/main_end' );
			$view->display ();
		} else {
			header ( 'Location: /home' );
		}
	}

	public function doEdit() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
			if (isset ( $_POST ['userEdit'] )) {
				// Get the values of the Form.
				$formValues = $this->getFormValues ();

				$firstNameValid = $this->isFieldValid ( "/^[a-zA-Z0-9.-]{0,45}$/", $formValues ['firstName'] );
				$lastNameValid = $this->isFieldValid ( "/^[a-zA-Z0-9.-]{0,45}$/", $formValues ['lastName'] );
				$userNameValid = $this->isFieldValid ( "/^[a-zA-Z0-9.]{3,45}$/", $formValues ['userName'] );
				$emailValid = $this->isFieldValid ( "/^[A-Z0-9\._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i", $formValues ['email'] );

				if ($firstNameValid && $lastNameValid && $userNameValid && $emailValid) {
					$userModel = new UserModel ();
					$id = $userModel->readIdByUsername($_SESSION['userName']);
					if (! $userModel->readIsEmailUsed( $formValues ['email'] ) || $formValues['email'] == $userModel->readById($id)->email) {
						if (! $userModel->readIsUsernameUsed ( $formValues ['userName'] ) || $formValues['userName'] == $userModel->readById($id)->userName) {
							// Insert the new user in the db.
							
							$userModel->updateFirstNameById($formValues['firstName'], $id);
							$userModel->updateLastNameById($formValues['lastName'], $id);
							$userModel->updateEmailById($formValues['email'], $id);
							$userModel->updateUserNameById($formValues['userName'], $id);

							$_SESSION ['userName'] = $formValues ['userName'];

							// Clear the Form fields.
							$this->clearFormValues ();
							header ( 'Location: /user' );
						} else {
							header ( 'Location: /user/edit' );
						}
					} else {
						header ( 'Location: /user/edit' );
					}
				} else {
					header ( 'Location: /user/edit' );
				}
			} else {
				header ( 'Location: /user/edit' );
			}
		}


	}

	public function delete() {

	}

	public function doDelete() {
		if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
			$userModel = new UserModel();
			$fileService = new FileService();
			$fileService->delete('./userHomes/'.$userModel->readIdByUsername($_SESSION['userName']));
			$userModel->deleteById($userModel->readIdByUsername($_SESSION['userName']));
			header('Location: /logout/doLogout');
		} else {
			header ( 'Location: /home' );
		}
	}

	public function changepw() {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {

			$view = new View ( 'general/main_start', array (
				"heading" => "User"
			) );
			$view->display ();
			$view = new View ( 'user/changepw');
			$view->display ();
			$view = new View ( 'general/main_end' );
			$view->display ();
		} else {
			header ( 'Location: /home' );
		}
	}

	public function doChangepw() {
		if (isset ( $_POST ['userChangepw'] )) {

			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$passwordOld = (isset($_POST ['passwordold'])? $_POST ['passwordold']: "" );
			$passwordNew = (isset($_POST ['passwordnew'])? $_POST ['passwordnew']: "" );
			$passwordNew2 = (isset($_POST ['passwordnew2'])? $_POST ['passwordnew2']: "" );
			$passwordOld = $this->isFieldValid ( "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $passwordOld);
			$passwordNewValid = $this->isFieldValid ( "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $passwordNew) ;
			$passwordNew2Valid = $this->isFieldValid ( "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $passwordNew2);

			$userModel = new UserModel ();

			if ($passwordOld && $passwordNewValid && $passwordNew2Valid) {
				if (password_verify ( $passwordOld, $userModel->readPasswordByUsername($_SESSION['userName']) )) {
						if ($passwordNew == $passwordNew2) {

							$id = $userModel->readIdByUsername($_SESSION['userName']);
							$userModel->updatePasswordById($passwordNew, $id);

							header ( 'Location: /user' );
						} else {
							header ( 'Location: /user/changepw' );
						}
				} else {
					header ( 'Location: /user/changepw' );
				}
			} else {
				header ( 'Location: /user/changepw' );
			}
		} else {
			header ( 'Location: /user/changepw' );
		}
	}

	private function getFormValues() {
		$values = array (
			'firstName' => (isset ( $_POST ['firstName'] ) ? $_POST ['firstName'] : ""),
			'lastName' => (isset ( $_POST ['lastName'] ) ? $_POST ['lastName'] : ""),
			'userName' => (isset ( $_POST ['userName'] ) ? $_POST ['userName'] : ""),
			'email' => (isset ( $_POST ['email'] ) ? $_POST ['email'] : "")
		);
		return $values;
	}

	private function clearFormValues() {
		$POST ['firstName'] = "";
		$POST ['lastName'] = "";
		$POST ['userName'] = "";
		$POST ['email'] = "";
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
