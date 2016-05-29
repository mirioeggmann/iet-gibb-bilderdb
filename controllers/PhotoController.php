<?php

require_once ('models/PhotoModel.php');
require_once ('models/UserModel.php');

class PhotoController
{
    public function __construct()
    {
        $view = new View('general/head',array("title" => "Photo - lychez.ch"));
        $view->display();
        $view = new View('general/header');
        $view->display();
    }

    public function index($id)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $userModel = new UserModel();
            $photoModel = new PhotoModel();

            $photo = $photoModel->readById($id);

            if (true) {
                $view = new View('general/main_start', array("heading" => "Photo"));
                $view->display();
                $view = new View('photo/index', array("photo" => $photo));
                $view->display();
                $view = new View('general/main_end');
                $view->display();
            }
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
