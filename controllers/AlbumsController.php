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
 * All actions which include multiple albums are done in this controller.
 */
class AlbumsController extends Controller
{

    /**
     * Creates a custom header of the page.
     */
    public function __construct()
    {
        $mySessionHandler = new MySessionHandler();
        if($mySessionHandler->isUserLoggedIn()) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        } else {
            header ( 'Location: /home' );
        }

        $view = new View('general/head',array("title" => "Albums - lychez.ch"));
        $view->display();
        $view = new View('general/header');
        $view->display();
    }

    /**
     * Displays all albums of the active user.
     */
    public function index()
    {
        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $userModel = new UserModel();
            $albumModel = new AlbumModel();

            $albums = $albumModel->readAllByUserId($userModel->readIdByUsername($_SESSION['userName']));

            $view = new View('general/main_start', array("heading" => "Albums"));
            $view->display();
            $view = new View('albums/index', array("albums" => $albums));
            $view->display();
            $view = new View('general/main_end');
            $view->display();
        } else {
            header ( 'Location: /home' );
        }
    }
}
