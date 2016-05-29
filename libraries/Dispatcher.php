<?php

class Dispatcher
{
	public static function dispatch()
	{
		$validControllerNames = array(	"Album"			=> array("index","create","doCreate", "edit", "doEdit", "delete", "doDelete"),
									  	"Albums"		=> array("index"),
									  	"Home" 			=> array("index"),
									  	"Login"			=> array("index","doLogin"),
										"Logout"		=> array("index","doLogout"),
										"Photo"			=> array("index", "edit", "doEdit", "delete", "doDelete"),
									  	"Photos"		=> array("index"),
										"Register"		=> array("index","doRegister"),
										"Search"		=> array("index"),
									  	"Upload"		=> array("index","doUpload"),
										"User"			=> array("index", "edit", "doEdit", "delete", "doDelete"));

		$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

		if (!empty($url[0]) && array_key_exists(ucfirst($url[0]),$validControllerNames)) {
			$controllerName = ucfirst($url[0]);
			$method 		= !empty($url[1]) && in_array($url[1],$validControllerNames[$controllerName]) ? $url[1] : 'index';
			$args 			= array_slice($url, 2);
		} else {
			$controllerName = 'Home';
			$method 		= 'index';
			$args 			= array();
		}

		require_once ("controllers/".$controllerName."Controller.php");
        $controllerName = $controllerName."Controller";
		$controller = new $controllerName();

		call_user_func_array(array($controller, $method), $args);
		
		unset($controller);
		unset($validControllerNames);
	}
}
