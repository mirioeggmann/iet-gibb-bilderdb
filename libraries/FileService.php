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

/**
 * Handles the actions with the filesystem.
 */
class FileService {

    /**
     * Creates the user home of the new user.
     *
     * @param $userId The id of the user which is created.
     */
    public function createUsereHome($userId) {
        if (!file_exists('./userHomes/'.$userId)) {
            mkdir('./userHomes/'.$userId.'/photos', 0777, true);
            mkdir('./userHomes/'.$userId.'/thumbnails', 0777, true);
        }
    }

    // Snipped: http://stackoverflow.com/questions/1334398/how-to-delete-a-folder-with-contents-using-php
    // ----
    /**
     * Deletes folders with all content in it or single files.
     *
     * @param $path The path to delete.
     * @return bool True if successfull, false if error or no file/directory.
     */
    public function delete($path)
    {
        if (is_dir($path) === true)
        {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file)
            {
                $this->delete(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        }

        else if (is_file($path) === true)
        {
            return unlink($path);
        }

        return false;
    }
    //----

    /**
     * Deletes a single file.
     *
     * @param $path The file to delete.
     * @return bool if it was successfull.
     */
    public function deleteFile($path) {
        if (is_file($path) === true)
        {
            return unlink($path);
        }
        return false;
    }
}