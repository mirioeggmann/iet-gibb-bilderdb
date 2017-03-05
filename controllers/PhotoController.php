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

require_once ('libraries/FileService.php');
require_once ('Controller.php');

/**
 * Handles all actions that include a single photo.
 */
class PhotoController extends Controller
{
    /**
     * Displays a custom header.
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

        $view = new View('general/head',array("title" => "Photo - lychez.ch"));
        $view->display();
        $view = new View('general/header');
        $view->display();
    }

    /**
     * The single site with all the informations of the selected photo.
     *
     * @param $id The id of the photo.
     * @throws Exception If the photo doesn't exist.
     */
    public function index($id)
    {
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

    /**
     * Displays the edit form of a photo to add a description etc.
     *
     * @param $id The id of the photo.
     * @throws Exception If the photo doesn't exist.
     */
    public function edit($id)
    {
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

    /**
     * Performs the edit of the picture informations.
     *
     * @param $id The id of the photo.
     * @throws Exception If the photo doesn't exist.
     */
    public function doEdit($id) {
        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {

            if (isset ( $_POST ['photoEdit'] )) {

                $photoModel = new PhotoModel();
                $userModel = new UserModel();
                $tagModel = new TagModel();
                $photoTagModel = new PhotoTagModel();
                $validator = new Validator();
                $formValues = $this->getFormValues();

                if ($photoModel->readIsPhotoFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
                    $descriptionValid = $validator->isValid ( "/^.{0,500}$/", $formValues ['description'] );
                    $titleValid = $validator->isValid  ( "/^[a-zA-Z0-9. -äöüÄÖÜ]{0,45}$/", $formValues ['title'] );
                    $tagsValid = $validator->isValid  ( "/^[a-zA-Z0-9, ]{0,}$/", $formValues ['tags'] );
                    if ($descriptionValid && $titleValid && $tagsValid) {
                        $photoModel->updateDescriptionById(htmlspecialchars($formValues['description']),$id);
                        $photoModel->updateTitleById(htmlspecialchars($formValues['title']),$id);

                        $tags = $formValues['tags'];
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
                        header('Location: /photo/edit/'.$id);
                    }
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

    /**
     * Displays a form if the user really wants to delete the photo.
     *
     * @param $id The id of the photo.
     */
    public function delete($id) {
        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $photoModel = new PhotoModel();
            $userModel = new UserModel();
            if ($photoModel->readIsPhotoFromUser($id, $userModel->readIdByUsername($_SESSION['userName']))) {
                $photo = $photoModel->readById($id);

                $view = new View('general/main_start', array("heading" => "Photo"));
                $view->display();
                $view = new View('photo/delete', array("photo" => $photo));
                $view->display();
                $view = new View('general/main_end');
                $view->display();
            } else {
                header('Location: /photos');
            }

        } else {
            header ( 'Location: /home' );
        }
    }

    /**
     * Performs the deletion of a photo.
     *
     * @param $id The id of the photo.
     * @throws Exception When the photo doesn't exist.
     */
    public function doDelete($id) {
        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $photoModel = new PhotoModel();
            $userModel = new UserModel();
            $fileService = new FileService();
            if (isset ( $_POST ['photoDelete'] )) {
                if ($photoModel->readIsPhotoFromUser($id, $userModel->readIdByUsername($_SESSION['userName']))) {
                    $fileService->deleteFile('./userHomes/' . $userModel->readIdByUsername($_SESSION['userName']) . '/photos/' . $photoModel->readById($id)->name . '.' . $photoModel->readById($id)->type);
                    $fileService->deleteFile('./userHomes/' . $userModel->readIdByUsername($_SESSION['userName']) . '/thumbnails/' . $photoModel->readById($id)->name . '.' . $photoModel->readById($id)->type);
                    $photoModel->deleteById($id);
                    header('Location: /photos');
                } else {
                    header('Location: /photos');
                }
            } else {
                header('Location: /photo/delete/'.$id);
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    /**
     * Displays a form to select an album to add the picture to.
     *
     * @param $id The id of the picture.
     * @throws Exception If the picture doesn't exist.
     */
    public function addTo($id) {
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

    /**
     * Performs the adding to an album.
     *
     * @param $id The id of the picture.
     * @throws Exception When the photo doesn't exist.
     */
    public function doAddTo($id) {
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

    /**
     * @return array With all values of the photo forms.
     */
    private function getFormValues() {
        $values = array (
            'description' => (isset ( $_POST ['description'] ) ? $_POST ['description'] : ""),
            'tags' => (isset ( $_POST ['tags'] ) ? $_POST ['tags'] : ""),
            'title' => (isset ( $_POST ['title'] ) ? $_POST ['title'] : "")
        );
        return $values;
    }
}
