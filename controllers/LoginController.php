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
 * The user login is handled by this controller.
 */
class LoginController extends Controller {

    /**
     * Creates a custom header.
     */
	public function __construct() {
		$view = new View ( 'general/head', array (
				"title" => "Login - lychez.ch"
		) );
		$view->display ();
	}

    /**
     * Displays the login form.
     */
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

    /**
     * Takes the credentials of the login form and checks if they are in the database.
     */
	public function doLogin() {
		if (isset ( $_POST ['login'] )) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
			// Get the values of the Form.
			$formValues = $this->getFormValues ();
				$userModel = new UserModel ();
				if ($userModel->readIsEmailUsed ( $formValues ['email'] ) || $userModel->readIsUsernameUsed( $formValues ['email'] )) {
					if (password_verify ( $formValues ['password'], $userModel->readPasswordByEmail ( $formValues ['email'] ) ) || password_verify ( $formValues ['password'], $userModel->readPasswordByUsername( $formValues ['email'] ) )) {
						// Login the user.
						session_start ();
						session_regenerate_id();
                        $id = (strpos($formValues['email'], '@') !== false ? $userModel->readIdByEmail($formValues['email']): $userModel->readIdByUsername($formValues['email']));
						$_SESSION ['userName'] = $userModel->readUserNameById($id);
                        $_SESSION['lastActivity'] = time();
                        $_SESSION['lastSessionUpdate'] = time();
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
	}

    /**
     * @return array All values of the login form.
     */
	private function getFormValues() {
		$values = array (
				'email' => (isset ( $_POST ['email'] ) ? $_POST ['email'] : ""),
				'password' => (isset ( $_POST ['password'] ) ? $_POST ['password'] : "")
		);
		return $values;
	}

    /**
     * Clears the post values.
     */
	private function clearFormValues() {
		$POST ['email'] = "";
		$POST ['password'] = "";
	}

    /**
     * A custom footer for the login page.
     */
	public function __destruct() {
		$view = new View ( 'general/foot' );
		$view->display ();
	}
}
