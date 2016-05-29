<?php

require_once ('models/AlbumModel.php');
require_once ('models/UserModel.php');

class AlbumsController
{
    public function __construct()
    {
        $view = new View('general/head',array("title" => "Albums - lychez.ch"));
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

    public function __destruct()
    {
        $view = new View('general/footer');
        $view->display();
        $view = new View('general/foot');
        $view->display();
    }
}
