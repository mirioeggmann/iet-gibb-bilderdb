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
 * Handles all actions that include multiple photos.
 */
class PhotosController extends Controller
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
        
        $view = new View('general/head',array("title" => "Photos - lychez.ch"));
        $view->display();
        $view = new View('general/header');
        $view->display();
    }

    /**
     * Displays all photos of the current user.
     */
    public function index()
    {
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
}
