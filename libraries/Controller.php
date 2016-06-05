<?php

// Include all Models, because they are used in many views.
require_once ('models/AlbumModel.php');
require_once ('models/UserModel.php');
require_once ('models/PhotoModel.php');
require_once ('models/TagModel.php');
require_once ('models/PhotoTagModel.php');
require_once ('models/PhotoAlbumModel.php');

class Controller {
    public function __construct()
    {
        $view = new View('general/head',array("title" => "Lychez - lychez.ch"));
        $view->display();
        $view = new View('general/header');
        $view->display();
    }

    public function __destruct()
    {
        $view = new View('general/footer');
        $view->display();
        $view = new View('general/foot');
        $view->display();
    }
}