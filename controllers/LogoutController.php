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
 * Handles the logout prozess.
 */
class LogoutController extends Controller
{
    /**
     * Displays a custom header.
     */
	public function __construct()
	{
        $view = new View('general/head',array("title" => "Logout - lychez.ch"));
		$view->display();
		$view = new View('general/header');
		$view->display();
	}

    /**
     * Directly calls the logout function.
     */
    public function index()
	{
        $this->doLogout();
	}

    /**
     * Performs the logout of the user.
     */
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
}
