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
 * All actions which include a single album are done in this controller.
 */
class AlbumController extends Controller
{
    /**
     * Creates a custom header of the page.
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
        $view = new View('general/head',array("title" => "Album - lychez.ch"));
        $view->display();
        $view = new View('general/header');
        $view->display();
    }

    /**
     * The single site with all photos of the album and a tag filter to search a photo.
     *
     * @param $id The selected album id.
     * @throws Exception When the album doesn't exist.
     */
    public function index($id)
    {


        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $time = time();

            $timeout_duration = 60;

            if (isset($_SESSION['lastActivity']) && ($time - $_SESSION['lastActivity']) > $timeout_duration) {
                session_unset();
                setcookie(session_name(), "", 1);
                setcookie(session_name(), false);
                unset($_COOKIE[session_name()]);
                session_destroy();
                session_start();
                header ( 'Location: /home' );
            }
            $_SESSION['lastActivity'] = $time;

        } else {
            header ( 'Location: /home' );
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $photoTagModel = new PhotoTagModel();
            $photoAlbumModel = new PhotoAlbumModel();
            $userModel = new UserModel();
            $albumModel = new AlbumModel();
            $tagModel = new TagModel();


            if ($albumModel->readIsAlbumFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
                $photos = $photoAlbumModel->readAllPhotosByAlbumId($id);
                $album = $albumModel->readById($id);

                $tagIds = isset ($_GET ['tags']) ? $_GET ['tags'] : "";

                $tagArray = explode('-', $tagIds);
                $tagArray = array_unique($tagArray);
                $selectedTags = array();
                foreach ($tagArray as $tagId) {
                    if ($tagId != "") {
                        if ($tagModel->readById($tagId)) {
                            array_push($selectedTags, $tagModel->readById($tagId));
                        }
                    }
                }
                $selectedPhotos = array();
                if (count($selectedTags) > 0) {
                    foreach ($photos as $photo) {
                        foreach ($selectedTags as $selectedTag) {
                            if ($photoTagModel->readIsPhotoTagSetted($photo->id, $selectedTag->id)) {
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
                if (isset ($_GET ['page']) && $_GET['page'] * 12 - 12 <= count($photos)) {
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

                $tags = $tagModel->readAllTags();

                $view = new View('general/main_start', array("heading" => "Album"));
                $view->display();
                $view = new View('album/index', array("album" => $album, "tags" => $tags, "selectedTags" => $selectedTags, "tagIds" => $tagIds, "photos" => $photos, "amountOfPages" => $amountOfPages, "selectedPage" => $page));
                $view->display();
                $view = new View('general/main_end');
                $view->display();
            } else {
                header ( 'Location: /albums' );
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    /**
     * Displays page where you can create a new album.
     */
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

    /**
     * Takes the values of the create page and adds the new album.
     */
    public function doCreate() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $validator = new Validator();
            if (isset ($_POST ['createAlbum'])) {
                $formValues = $this->getFormValues();

                if ($validator->isValid("/^[a-zA-Z0-9. ]{1,45}$/", $formValues['name'])) {
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

    /**
     * Displays the page to edit an album.
     *
     * @param $id The id of the selected album.
     * @throws Exception If the album does not exist
     */
    public function edit($id) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $albumModel = new AlbumModel();
            $userModel = new UserModel();

            if ($albumModel->readIsAlbumFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
                $album = $albumModel->readById($id);

                $view = new View('general/main_start', array("heading" => "Album edit"));
                $view->display();
                $view = new View('album/edit', array("album" => $album));
                $view->display();
                $view = new View('general/main_end');
                $view->display();
            } else {
                header ( 'Location: /albums' );
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    /**
     * Takes the values of the edit page and changes the values in the database.
     *
     * @param $id The id of the selected album.
     */
    public function doEdit($id) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $albumModel = new AlbumModel();
            $userModel = new UserModel();
            $validator = new Validator();
            if ($albumModel->readIsAlbumFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
                if (isset ($_POST ['editAlbum'])) {
                    $formValues = $this->getFormValues();

                    if ($validator->isValid("/^[a-zA-Z0-9. ]{1,45}$/", $formValues['name'])) {
                        $albumModel->updateNameById($formValues['name'], $id);

                        header('Location: /album/index/' . $id);
                    } else {
                        header('Location: /album/edit/' . $id);
                    }
                } else {
                    header('Location: /album/edit/' . $id);
                }
            } else {
                header ( 'Location: /albums' );
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    /**
     * Displays a page that asks if the user really wants to delete the album.
     *
     * @param $id The id of the album.
     */
    public function delete($id) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $albumModel = new AlbumModel();
            $userModel = new UserModel();
                if ($albumModel->readIsAlbumFromUser($id, $userModel->readIdByUsername($_SESSION['userName']))) {
                    $album = $albumModel->readById($id);

                    $view = new View('general/main_start', array("heading" => "Album edit"));
                    $view->display();
                    $view = new View('album/delete', array("album" => $album));
                    $view->display();
                    $view = new View('general/main_end');
                    $view->display();
                } else {
                    header('Location: /albums');
                }

        } else {
            header ( 'Location: /home' );
        }
    }

    /**
     * Is called when the user accepted to delete the album and this function deletes it in the database.
     *
     * @param $id The id of the album.
     */
    public function doDelete($id) {
        if (isset ( $_SESSION ['loggedIn'] ) && $_SESSION ['loggedIn'] == true) {
            $albumModel = new AlbumModel();
            $userModel = new UserModel();
            if (isset ( $_POST ['albumDelete'] )) {
                if ($albumModel->readIsAlbumFromUser($id,$userModel->readIdByUsername($_SESSION['userName']))) {
                    $albumModel->deleteById($id);
                    header('Location: /albums');
                } else {
                    header ( 'Location: /albums' );
                }
            } else {
                header('Location: /album/delete/'.$id);
            }
        } else {
            header ( 'Location: /home' );
        }
    }

    /**
     * This method gets all form values and returns them as an array.
     *
     * @return array All album elements of a form.
     */
    private function getFormValues() {
        $values = array (
            'name' => (isset ( $_POST ['name'] ) ? htmlspecialchars($_POST ['name']) : "")
        );
        return $values;
    }
}
