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

require_once ('libraries/ThumbnailCreator.php');
require_once ('models/UserModel.php');
require_once ('models/PhotoModel.php');

class UploadController
{
    /**
     * Creates the header of the page.
     */
    public function __construct()
    {
        $view = new View ('general/head', array(
            "title" => "Upload - lychez.ch"
        ));
        $view->display();
        $view = new View ('general/header');
        $view->display();
    }

    /**
     * Default & startpage of the upload controller.
     */
    public function index()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset ($_SESSION ['loggedIn']) && $_SESSION ['loggedIn'] == true) {
            $view = new View ('general/main_start', array(
                "heading" => "Upload"
            ));
            $view->display();
            $view = new View ('upload/index');
            $view->display();
            $view = new View ('general/main_end');
            $view->display();
        } else {
            header('Location: /home');
        }
    }

    /**
     * Is called when the user uploaded something. Validates the content and inserts it in the database if its valid.
     */
    public function doUpload()
    {
        if (isset ($_SESSION ['loggedIn']) && $_SESSION ['loggedIn'] == true) {
            if (isset ($_POST ['upload'])) {
                $validExtensions = array(
                    "jpeg",
                    "gif",
                    "jpg",
                    "png"
                );

                $total = count($_FILES ['files'] ['name']);
                for ($i = 0; $i < $total; $i++) {
                    $tmpFilePath = $_FILES ['files'] ['tmp_name'] [$i];

                    if ($tmpFilePath != "") {
                        $userModel = new UserModel();
                        $id = $userModel->readIdByUsername($_SESSION['userName']);

                        $uniqueId = uniqid();
                        $newFilePath = "./userHomes/" . $id . "/photos/" . $uniqueId . "_" . basename($_FILES ['files'] ['name'] [$i]);
                        $thumbnailPath = "./userHomes/" . $id . "/thumbnails/" . $uniqueId . "_" . basename($_FILES ['files'] ['name'] [$i]);

                        $splittedName = explode(".", basename($_FILES['files']['name'][$i]));
                        $extension = end($splittedName);

                        if (in_array($extension, $validExtensions, true)) {
                            if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                                array_pop($splittedName);

                                $name = $uniqueId."_".implode(".", $splittedName);
                                $size = $_FILES['files']['size'][$i];
                                $height = getimagesize($newFilePath)[1];
                                $width = getimagesize($newFilePath)[0];

                                date_default_timezone_set('Europe/Zurich');
                                $date = date("Y-m-d H:i:s");

                                $photoModel = new PhotoModel();

                                //$name, $type, $height, $width, $size, $date, $title, $description, $userId
                                $photoModel->create($name,$extension,$height,$width,$size,$date,$id);

                                $thumbnailCreator = new ThumbnailCreator();
                                $thumbnailCreator->createThumbnail($newFilePath, $thumbnailPath);
                            }
                        } else {

                        }
                    }
                }
                header('Location: /photos');
            } else {
                header('Location: /upload');
            }
        }
    }

    /**
     * Creates the footer of the page.
     */
    public function __destruct()
    {
        $view = new View ('general/footer');
        $view->display();
        $view = new View ('general/foot');
        $view->display();
    }
}
