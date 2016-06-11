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

require_once('ConnectionHandler.php');

/**
 * Basic Model which is the superclass of all others.
 */
class Model
{
    /**
     * @var null The tablename.
     */
    protected $tableName = null;

    /**
     * Read the rows that includes the id.
     *
     * @param $id The id to search with.
     * @return object|stdClass Returns an array of the row which includes the id.
     * @throws Exception If it doesn't return any result.
     */
    public function readById($id)
    {
        $query = "SELECT * FROM $this->tableName WHERE id=?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($result->error);
        }

        $row = $result->fetch_object();

        $result->close();

        return $row;
    }

    /**
     *
     * Delete a row by the given id.
     *
     * @param $id The id of the row to delete.
     */
    public function deleteById($id)
    {
        $query = "DELETE FROM $this->tableName WHERE id=?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);

        if (!$statement->execute()) {}
    }
}
