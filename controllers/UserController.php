<?php

require_once ('models/UserModel.php');

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
			$view = new View ( 'general/main_start', array (
					"heading" => "User" 
			) );
			$view->display ();
			$view = new View ( 'user/index' );
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
			$view = new View ( 'general/main_start', array (
				"heading" => "User"
			) );
			$view->display ();
			$view = new View ( 'user/edit' );
			$view->display ();
			$view = new View ( 'general/main_end' );
			$view->display ();
		} else {
			header ( 'Location: /home' );
		}
	}

	public function doEdit() {

	}

	public function delete() {

	}

	public function doDelete() {
		$userModel = new UserModel();

		$userModel->deleteById($_SESSION['userModel']);
		header ( 'Location: /logout/doLogout' );
	}

	public function __destruct() {
		$view = new View ( 'general/footer' );
		$view->display ();
		$view = new View ( 'general/foot' );
		$view->display ();
	}
}
