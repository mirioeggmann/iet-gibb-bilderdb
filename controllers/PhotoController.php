<?php

require_once ('models/UserModel.php');
require_once ('models/PhotoModel.php');
require_once ('models/TagModel.php');
require_once ('models/PhotoTagModel.php');
require_once ('libraries/FileSystemHelper.php');

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
            $photoModel = new PhotoModel();
            $photoTagModel = new PhotoTagModel();
            if ($photoModel->readById($id)) {
                $photo = $photoModel->readById($id);

                if (true) {
                    $view = new View('general/main_start', array("heading" => "Photo"));
                    $view->display();
                    $view = new View('photo/index', array("photo" => $photo, "tags" => $photoTagModel->readAllTagsByPhotoId($id)));
                    $view->display();
                    $view = new View('general/main_end');
                    $view->display();
                }
            } else {
                header ( 'Location: /photos' );
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    public function edit($id)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $photoModel = new PhotoModel();
            $userModel = new UserModel();
            $photoTagModel = new PhotoTagModel();

            if ($photoModel->readIsPhotoFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
                $photo = $photoModel->readById($id);

                $tags = "";
                foreach($photoTagModel->readAllTagsByPhotoId($id) as $tag) {
                    $tags = $tags . $tag->name . ', ';
                }

                $view = new View('general/main_start', array("heading" => "Photo"));
                $view->display();
                $view = new View('photo/edit', array("photo" => $photo, "tags" => $tags));
                $view->display();
                $view = new View('general/main_end');
                $view->display();
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    public function doEdit($id) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            if (isset ( $_POST ['photoEdit'] )) {

                $photoModel = new PhotoModel();
                $userModel = new UserModel();
                $tagModel = new TagModel();
                $photoTagModel = new PhotoTagModel();

                if (true) {
                    $photoModel->updateDescriptionById($_POST['description'],$id);
                    $photoModel->updateTitleById($_POST['title'],$id);

                    $tags = $_POST['tags'];
                    $tagsReplaced = str_replace(' ', '', $tags);
                    $tagsArray = explode(',',$tagsReplaced);
                    foreach($tagsArray as $tag) {
                        if (!$tagModel->readIsTagSetted($tag) && $tag != "") {
                            $tagModel->create($tag);
                        }
                        if ($tag != "" && !$photoTagModel->readIsPhotoTagSetted($id,$tagModel->readIdByName($tag))) {
                            $photoTagModel->create($id,$tagModel->readIdByName($tag));
                        }
                    }

                    header('Location: /photo/index/'.$id);
                } else {
                    header('Location: /home');
                }
            } else {
                header('Location: /photo/edit/'.$id);
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    public function delete() {

    }

    public function doDelete($id) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $photoModel = new PhotoModel();
            $userModel = new UserModel();
            $fileSystemHelper = new FileSystemHelper();

            if ($photoModel->readIsPhotoFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
                $fileSystemHelper->deleteFile('./userHomes/'.$userModel->readIdByUsername($_SESSION['userName']).'/photos/'.$photoModel->readById($id)->name.'.'.$photoModel->readById($id)->type);
                $fileSystemHelper->deleteFile('./userHomes/'.$userModel->readIdByUsername($_SESSION['userName']).'/thumbnails/'.$photoModel->readById($id)->name.'.'.$photoModel->readById($id)->type);
                $photoModel->deleteById($id);
                header('Location: /photos');
            } else {
                header ( 'Location: /home' );
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    public function addTo() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
                    $view = new View('general/main_start', array("heading" => "Photo"));
                    $view->display();
                    $view = new View('photo/addTo');
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
