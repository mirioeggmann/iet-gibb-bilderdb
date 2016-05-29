<?php

require_once ('models/PhotoModel.php');
require_once ('models/UserModel.php');

class PhotosController
{
    public function __construct()
    {
        $view = new View('general/head',array("title" => "Photos - lychez.ch"));
        $view->display();
        $view = new View('general/header');
        $view->display();
    }

    public function index()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $userModel = new UserModel();
            $photoModel = new PhotoModel();
            //$min = (true) ? 0 : 0;
            //,$min,($min+12)
            $photos = $photoModel->readAllByUserId($userModel->readIdByUsername($_SESSION['userName']));

            $view = new View('general/main_start', array("heading" => "Photos"));
            $view->display();
            $view = new View('photos/index', array("photos" => $photos));
            $view->display();
            $view = new View('general/main_end');
            $view->display();
        } else {
            header ( 'Location: /home' );
        }
    }

    public function __destruct()
    {
        $view = new View('general/footer');
        $view->display();
        $view = new View('general/foot');
        $view->display();
    }
}
