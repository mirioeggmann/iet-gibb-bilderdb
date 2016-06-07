<?php

require_once ('models/UserModel.php');
require_once ('models/PhotoModel.php');
require_once ('models/AlbumModel.php');
require_once ('models/TagModel.php');
require_once ('models/PhotoTagModel.php');
require_once ('models/PhotoAlbumModel.php');
require_once ('libraries/FileService.php');

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
            $userModel = new UserModel();
            if ($photoModel->readIsPhotoFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
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
                    header('Location: /photos');
                }
            } else {
                header('Location: /photos');
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
            } else {
                header ( 'Location: /photos' );
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

                if ($photoModel->readIsPhotoFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
                    $photoModel->updateDescriptionById(htmlspecialchars($_POST['description']),$id);
                    $photoModel->updateTitleById(htmlspecialchars($_POST['title']),$id);

                    $tags = $_POST['tags'];
                    $tagsReplaced = str_replace(' ', '', $tags);
                    $tagsArray = explode(',',$tagsReplaced);
                    foreach($tagsArray as $tag) {
                        if (!$tagModel->readIsTagSetted($tag) && $tag != "") {
                            $tagModel->create(htmlspecialchars($tag));
                        }
                        if ($tag != "" && !$photoTagModel->readIsPhotoTagSetted($id,$tagModel->readIdByName($tag))) {
                            $photoTagModel->create($id,$tagModel->readIdByName($tag));
                        }
                    }

                    header('Location: /photo/index/'.$id);
                } else {
                    header('Location: /photos');
                }
            } else {
                header('Location: /photo/edit/'.$id);
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    public function delete($id) {
        header ( 'Location: /photo/doDelete/' . $id );
    }

    public function doDelete($id) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $photoModel = new PhotoModel();
            $userModel = new UserModel();
            $fileService = new FileService();

            if ($photoModel->readIsPhotoFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
                $fileService->deleteFile('./userHomes/'.$userModel->readIdByUsername($_SESSION['userName']).'/photos/'.$photoModel->readById($id)->name.'.'.$photoModel->readById($id)->type);
                $fileService->deleteFile('./userHomes/'.$userModel->readIdByUsername($_SESSION['userName']).'/thumbnails/'.$photoModel->readById($id)->name.'.'.$photoModel->readById($id)->type);
                $photoModel->deleteById($id);
                header('Location: /photos');
            } else {
                header ( 'Location: /photos' );
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    public function addTo($id) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $albumModel = new AlbumModel();
            $photoModel = new PhotoModel();
            $userModel = new UserModel();
            $photoAlbumModel = new PhotoAlbumModel();

            if ($photoModel->readIsPhotoFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
                $photo = $photoModel->readById($id);
                $albums = $albumModel->readAllByUserId($userModel->readIdByUsername($_SESSION['userName']));
                $settedAlbums = $photoAlbumModel->readAllAlbumsByPhotoId($id);

                $view = new View('general/main_start', array("heading" => "Photo"));
                $view->display();
                $view = new View('photo/addTo', array("albums" => $albums, "photo" => $photo, "settedAlbums" => $settedAlbums));
                $view->display();
                $view = new View('general/main_end');
                $view->display();
            } else {
                header ( 'Location: /photos' );
            }

        } else {
            header ( 'Location: /home' );
        }
    }

    public function doAddTo($id) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $photoModel = new PhotoModel();
            $userModel = new UserModel();
            $photoAlbumModel = new PhotoAlbumModel();

            if ($photoModel->readIsPhotoFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
                if (!$photoAlbumModel->readIsAlbumIdSettedByPhotoId($_POST['selectAlbum'], $id)) {
                    $photoAlbumModel->create($id, $_POST['selectAlbum']);
                    header('Location: /photo/index/' . $id);
                } else {
                    header ( 'Location: /photo/addTo/'.$id );
                }
            } else {
                header ( 'Location: /photo/addTo/'.$id );
            }
        } else {
            header ( 'Location: /photo/addTo/'.$id );
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
