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

require_once ('libraries/FileService.php');
require_once ('Controller.php');

/**
 * Handles the user informations once he is logged in.
 */
class UserController extends Controller{

    /**
     * Displays a custom header.
     */
	public function __construct() {
        $mySessionHandler = new MySessionHandler();
        if($mySessionHandler->isUserLoggedIn()) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        } else {
            header ( 'Location: /home' );
        }

		$view = new View ( 'general/head', array (
				"title" => "User - lychez.ch" 
		) );
		$view->display ();
		$view = new View ( 'general/header' );
		$view->display ();
	}

    /**
     * Displays all informations about the user.
     */
	public function index() {
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

    /**
     * Displays a edit form to edit the user.
     */
	public function edit() {
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

    /**
     * Performs the edit of a user and inserts it in the database, if valid.
     */
	public function doEdit() {
		if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
			if (isset ( $_POST ['userEdit'] )) {
				$formValues = $this->getFormValues ();
                $validator = new Validator();

				$firstNameValid = $validator->isValid ( "/^[a-zA-Z0-9.-]{0,45}$/", $formValues ['firstName'] );
				$lastNameValid = $validator->isValid  ( "/^[a-zA-Z0-9.-]{0,45}$/", $formValues ['lastName'] );
				$userNameValid = $validator->isValid  ( "/^[a-zA-Z0-9.]{3,45}$/", $formValues ['userName'] );
				$emailValid = $validator->isValid  ( "/^[A-Z0-9\._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i", $formValues ['email'] );

				if ($firstNameValid && $lastNameValid && $userNameValid && $emailValid) {
					$userModel = new UserModel ();
					$id = $userModel->readIdByUsername($_SESSION['userName']);
					if (! $userModel->readIsEmailUsed( $formValues ['email'] ) || $formValues['email'] == $userModel->readById($id)->email) {
						if (! $userModel->readIsUsernameUsed ( $formValues ['userName'] ) || $formValues['userName'] == $userModel->readById($id)->userName) {
							// Insert the new user in the db.
							
							$userModel->updateFirstNameById(htmlspecialchars($formValues['firstName']), $id);
							$userModel->updateLastNameById(htmlspecialchars($formValues['lastName']), $id);
							$userModel->updateEmailById(htmlspecialchars($formValues['email']), $id);
							$userModel->updateUserNameById(htmlspecialchars($formValues['userName']), $id);

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

    /**
     * Displays a form to delete the active user.
     */
	public function delete() {
		if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
			$view = new View ( 'general/main_start', array (
				"heading" => "User"
			) );
			$view->display ();
			$view = new View ( 'user/delete' );
			$view->display ();
			$view = new View ( 'general/main_end' );
			$view->display ();
		} else {
			header ( 'Location: /home' );
		}
	}

    /**
     * Performs the deletion if the user accepted the question.
     */
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

    /**
     * Displays form to edit the password.
     */
	public function changepw() {

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

    /**
     * Changes the password of the active user if its valid.
     */
	public function doChangepw() {
		if (isset ( $_POST ['userChangepw'] )) {
            $validator = new Validator();
			$passwordOld = (isset($_POST ['passwordold'])? $_POST ['passwordold']: "" );
			$passwordNew = (isset($_POST ['passwordnew'])? $_POST ['passwordnew']: "" );
			$passwordNew2 = (isset($_POST ['passwordnew2'])? $_POST ['passwordnew2']: "" );
			$passwordOldValid = $validator->isValid  ( "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $passwordOld);
			$passwordNewValid = $validator->isValid  ( "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $passwordNew) ;
			$passwordNew2Valid = $validator->isValid ( "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $passwordNew2);

			$userModel = new UserModel ();

			if ($passwordOldValid && $passwordNewValid && $passwordNew2Valid) {
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

    /**
     * @return array With all values of the user forms.
     */
	private function getFormValues() {
		$values = array (
			'firstName' => (isset ( $_POST ['firstName'] ) ? $_POST ['firstName'] : ""),
			'lastName' => (isset ( $_POST ['lastName'] ) ? $_POST ['lastName'] : ""),
			'userName' => (isset ( $_POST ['userName'] ) ? $_POST ['userName'] : ""),
			'email' => (isset ( $_POST ['email'] ) ? $_POST ['email'] : "")
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
	}
}
