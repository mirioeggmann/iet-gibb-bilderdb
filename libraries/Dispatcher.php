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

/**
 * Handles all requests by the user and leads it to the corresponding Controller.
 *
 *  @version    1.0.0
 *	@author		Mirio Eggmann <mirio.eggmann@protonmail.ch>
 */
class Dispatcher
{
	/**
	 * Method that handles the requesteed data. Validates the controller and method names and displays them, if they are valid.
	 */
	public static function dispatch()
	{
		/**
		 * Controllernames and methods saved in an array. Is'ts kind of necessary to open
		 */
		$validControllerNames = array(	"Album"			=> array("index","create","doCreate", "edit", "doEdit", "delete", "doDelete"),
									  	"Albums"		=> array("index"),
									  	"Home" 			=> array("index"),
									  	"Login"			=> array("index","doLogin"),
										"Logout"		=> array("index","doLogout"),
										"Photo"			=> array("index", "edit", "doEdit", "delete", "doDelete", "addTo", "doAddTo"),
									  	"Photos"		=> array("index"),
										"Register"		=> array("index","doRegister"),
										"Search"		=> array("index"),
									  	"Upload"		=> array("index","doUpload"),
										"User"			=> array("index", "edit", "doEdit", "delete", "doDelete", "changepw", "doChangepw"),
										"Error"			=> array("index"));

		// Make an array of the data in the url, separated by "/"
		$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

		// controllername which is setted in the url.
		if (!empty($url[0])) {
			// controllername exists
			if(array_key_exists(ucfirst($url[0]),$validControllerNames)) {
				$controllerName = ucfirst($url[0]);
				// Check if method exist and else call the index method of the controller.
				if (!empty($url[1]) && in_array($url[1],$validControllerNames[$controllerName])) {}
				$method 		= (!empty($url[1]) && in_array($url[1],$validControllerNames[$controllerName])) ? $url[1] : 'index';
				$args 			= array_slice($url, 2);
			  //controllername does not exist.
			} else {
				$controllerName = 'Error';
				$method 		= 'index';
				$args 			= array();
			}
			// If no controllername is setted in the url.
		} else {
			$controllerName = 'Home';
			$method 		= 'index';
			$args 			= array();
		}

		// Add controller and create object
		require_once ("controllers/".$controllerName."Controller.php");
        $controllerName = $controllerName."Controller";
		$controller = new $controllerName();
		call_user_func_array(array($controller, $method), $args);

		// Removes the useless Controllers and valid Controller to save resources
		unset($controller);
		unset($validControllerNames);
	}
}
