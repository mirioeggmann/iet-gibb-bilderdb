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

// Include all Models, because they are used in many views.
require_once ('models/AlbumModel.php');
require_once ('models/UserModel.php');
require_once ('models/PhotoModel.php');
require_once ('models/TagModel.php');
require_once ('models/PhotoTagModel.php');
require_once ('models/PhotoAlbumModel.php');

// Include some helper functions
require_once ('libraries/Validator.php');
require_once ('libraries/MySessionHandler.php');

/**
 * Superclass that includes default values for the header and the footer.
 */
class Controller {

    /**
     * Is called when the Sub Controller has no header setted.
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
        
        $view = new View('general/head',array("title" => "Lychez - lychez.ch"));
        $view->display();

        $view = new View('general/header');
        $view->display();
    }

    /**
     * Is called when the Sub Controller has no footer setted.
     */
    public function __destruct()
    {
        $view = new View('general/footer');
        $view->display();
        $view = new View('general/foot');
        $view->display();
    }
}