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

require_once ('libraries/Model.php');

/**
 * Handle all the sql queries of the photo tag table.
 */
class PhotoTagModel extends Model
{
    /**
     * @var string The name of the table.
     */
    protected $tableName = 'photo_tag';

    /**
     * Create a new photo tag entry.
     *
     * @param $photoId The id of the photo.
     * @param $tagId The id of the tag.
     */
    public function create($photoId, $tagId)
    {
        $query = "INSERT INTO $this->tableName (photo_id, tag_id) VALUES (?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $photoId, $tagId);

        if (!$statement->execute()) {
            throw new Exception ($statement->error);
        }
    }

    /**
     * Check if the photo tag connection is setted.
     *
     * @param $photoId The id of the photo.
     * @param $tagId The id of the tag.
     * @return bool True if the connection is setted, else false.
     */
    public function readIsPhotoTagSetted($photoId, $tagId) {
        $query = "SELECT * FROM $this->tableName WHERE photo_id=? AND tag_id=?";

        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 'ii', $photoId, $tagId );
        $statement->execute ();

        $statement->store_result ();
        $num_of_rows = $statement->num_rows;

        if ($num_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Read all tags where the photo id is correct.
     *
     * @param $photoId The id of the photo.
     * @return array All Tags where the photo id is setted.
     */
    public function readAllTagsByPhotoId($photoId)
    {
        $query = "SELECT tag.name AS name FROM $this->tableName JOIN tag ON tag.id=photo_tag.tag_id AND photo_id=?";

        $statement = ConnectionHandler::getConnection ()->prepare($query);
        $statement->bind_param ( 'i', $photoId );
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        $rows = array();
        while ($row = $result->fetch_object()) {
            $rows[] = $row;
        }

        return $rows;
    }
}