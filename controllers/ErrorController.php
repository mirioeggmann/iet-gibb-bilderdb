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
 * Error Handling Controller
 *
 * Controller used by ErrorHandler to render error views.
 */
class ErrorController extends Controller
{

    /**
     * Displays an error message.
     */
    public function index() {
        $view = new View('errors/404');
        $view->display();
    }
}