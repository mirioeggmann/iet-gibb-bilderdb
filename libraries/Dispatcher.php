<?php

class Dispatcher
{
	public static function dispatch()
	{
		$url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

		$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'DefaultController';
		$method         = !empty($url[1]) ? $url[1] : 'index';
        $args           = array_slice($url, 2);

		require_once ("controller/$controllerName.php");
		$controller = new $controllerName();

        call_user_func_array(array($controller, $method), $args);
		
		unset($controller);
	}
}
