<?php

require_once ('models/PhotoModel.php');
require_once ('models/UserModel.php');
require_once ('models/TagModel.php');
require_once ('models/PhotoTagModel.php');

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
            $photoTagModel = new PhotoTagModel();
            $tagModel = new TagModel();
            $photos = $photoModel->readAllByUserId($userModel->readIdByUsername($_SESSION['userName']));

            $tagIds = isset ( $_GET ['tags'] ) ? $_GET ['tags'] : "";

            $tagArray = explode('-',$tagIds);
            $tagArray =  array_unique($tagArray);
            $selectedTags = array();
            foreach ($tagArray as $tagId) {
                if ($tagId != "") {
                    if($tagModel->readById($tagId)) {
                        array_push($selectedTags, $tagModel->readById($tagId));
                    }
                }
            }
            $selectedPhotos = array();
            if(count($selectedTags) > 0) {
                foreach ($photos as $photo) {
                    foreach($selectedTags as $selectedTag) {
                        if ($photoTagModel->readIsPhotoTagSetted($photo->id,$selectedTag->id)) {
                            array_push($selectedPhotos, $photo);
                            break;
                        }
                    }
                }
            } else {
                $selectedPhotos = $photos;
            }

            $photos = $selectedPhotos;

            $page = 1;
            if (isset ( $_GET ['page'] ) && $_GET['page'] * 12 - 12 <= count($photos)) {
                $page = $_GET['page'];
            }

            $lastPic = $page * 12;
            $firstPic = $page * 12 - 12;
            $photosDisplay = array();
            $amountOfPages = ceil(count($photos) / 12);

            $i = 0;
            foreach ($photos as $photo) {
                if ($i >= $firstPic) {
                    if ($firstPic < $lastPic) {
                        array_push($photosDisplay, $photo);
                        $firstPic += 1;
                    } else {
                        break;
                    }
                }
                $i++;
            }
            $photos = $photosDisplay;

            $view = new View('general/main_start', array("heading" => "Photos"));
            $view->display();
            $view = new View('photos/index', array("photos" => $photos,"tags" => $tagModel->readAllTags(), "tagIds" => $tagIds, "selectedTags" => $selectedTags, "amountOfPages" => $amountOfPages,
            "selectedPage" => $page));
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
