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
 * Handles all sql queries of the album table.
 */
class AlbumModel extends Model {

    /**
     * @var string The album table name.
     */
    protected $tableName = 'album';

    /**
     * Creates a new album entry.
     *
     * @param $name string The name of the album
     * @param $isShared int If the album is shared or not.
     * @param $userId int The id of the user which it belongs to.
     */
    public function create($name, $isShared, $userId) {
        $query = "INSERT INTO $this->tableName (name, isShared, user_id) VALUES (?, ?, ?)";

        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 'sii', $name, $isShared, $userId );

        if (! $statement->execute ()) {
            throw new Exception ( $statement->error );
        }
    }

    /**
     * Reads all albums of the user.
     *
     * @param $userId The id of the user.
     * @return array All albums of the user.
     */
    public function readAllByUserId($userId)
    {
        $query = "SELECT * FROM $this->tableName WHERE user_id=?";

        $statement = ConnectionHandler::getConnection ()->prepare($query);
        $statement->bind_param ( 'i', $userId );
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

    /**
     * Update the album informations.
     *
     * @param $name The new name of the album
     * @param $id The id of the album.
     */
    public function updateNameById($name, $id)
    {
        $query = "UPDATE $this->tableName SET name=? WHERE id=?";

        $statement = ConnectionHandler::getConnection ()->prepare($query);
        $statement->bind_param ( 'si', $name, $id );

        if (! $statement->execute ()) {
            throw new Exception ( $statement->error );
        }
    }

    /**
     * Check if the album belongs to the given user.
     *
     * @param $id The id of the album.
     * @param $userId The id of the user.
     * @return bool True if it belongs to the user, false if not.
     */
    public function readIsAlbumFromUser($id, $userId) {
        $query = "SELECT user_id FROM $this->tableName WHERE id=?";

        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 'i', $id );
        $statement->execute ();
        $result = $statement->get_result();

        $row = $result->fetch_assoc();
        $value = $row['user_id'];

        $result->close();

        if ($value == $userId) {
            return true;
        } else {
            return false;
        }
    }
}