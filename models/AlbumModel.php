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
class AlbumModel extends Model {
    protected $tableName = 'album';

    public function create($name, $isShared, $userId) {
        $query = "INSERT INTO $this->tableName (name, isShared, user_id) VALUES (?, ?, ?)";

        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 'sii', $name, $isShared, $userId );

        if (! $statement->execute ()) {
            throw new Exception ( $statement->error );
        }
    }

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

    public function updateNameById($name, $id)
    {
        $query = "UPDATE $this->tableName SET name=? WHERE id=?";

        $statement = ConnectionHandler::getConnection ()->prepare($query);
        $statement->bind_param ( 'si', $name, $id );

        if (! $statement->execute ()) {
            throw new Exception ( $statement->error );
        }
    }

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