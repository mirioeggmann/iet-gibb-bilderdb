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
 * The default landig page of the website.
 */
class HomeController extends Controller
{
    /**
     * Creates a custom header.
     */
	public function __construct()
	{
		$view = new View('general/head',array("title" => "Home - lychez.ch"));
		$view->display();
		$view = new View('general/header');
		$view->display();
	}

    /**
     * Displays a welcome message or news.
     */
	public function index()
	{
		$view = new View('general/main_start', array("heading" => "Home"));
		$view->display();
		$view = new View('home/index');
		$view->display();
		$view = new View('general/main_end');
		$view->display();
	}
}
