<?php

require_once ('models/AlbumModel.php');
require_once ('models/UserModel.php');

class AlbumController
{
    public function __construct()
    {
        $view = new View('general/head',array("title" => "Album - lychez.ch"));
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

            //$photos = $photoModel->readAllByUserId($userModel->readIdByUsername($_SESSION['userName']));

            $view = new View('general/main_start', array("heading" => "Album"));
            $view->display();
            $view = new View('album/index', array());
            $view->display();
            $view = new View('general/main_end');
            $view->display();
        } else {
            header ( 'Location: /home' );
        }
    }

    public function create()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $view = new View('general/main_start', array("heading" => "Album create"));
            $view->display();
            $view = new View('album/create',array("name" => ""));
            $view->display();
            $view = new View('general/main_end');
            $view->display();
        } else {
            header ( 'Location: /home' );
        }
    }

    public function doCreate() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            if (isset ($_POST ['createAlbum'])) {
                $formValues = $this->getFormValues();

                if ($this->isFieldValid("/^[a-zA-Z0-9. ]{1,45}$/", $formValues['name'])) {
                    $albumModel = new AlbumModel();
                    $userModel = new UserModel();
                    $id = $userModel->readIdByUsername($_SESSION['userName']);
                    $albumModel->create($formValues['name'], 0, $id);

                    header ( 'Location: /albums' );
                } else {
                    header ( 'Location: /album/create' );
                }
            } else {
                header ( 'Location: /album/create' );
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    private function getFormValues() {
        $values = array (
            'name' => (isset ( $_POST ['name'] ) ? $_POST ['name'] : "")
        );
        return $values;
    }

    private function clearFormValues() {
        $POST ['name'] = "";
    }

    private function isFieldValid($regex, $value) {
        if (preg_match ( $regex, $value )) {
            return true;
        } else {
            return false;
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
