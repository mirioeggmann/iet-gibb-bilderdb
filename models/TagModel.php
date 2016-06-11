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
 * Handles all queries of the tag table.
 */
class TagModel extends Model
{
    /**
     * @var string The name of the table.
     */
    protected $tableName = 'tag';

    /**
     * Create a new tag entry.
     *
     * @param $name The tag name.
     */
    public function create($name)
    {
        $query = "INSERT INTO $this->tableName (name) VALUES (?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $name);

        if (!$statement->execute()) {
            throw new Exception ($statement->error);
        }
    }

    /**
     * Read the id by the name.
     *
     * @param $name The tag name
     * @return mixed Returns the id of a given name.
     */
    public function readIdByName($name) {
        $query = "SELECT id FROM $this->tableName WHERE name=?";
        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 's', $name );
        $statement->execute ();
        $result = $statement->get_result();

        $row = $result->fetch_assoc();
        $value = $row['id'];

        $result->close();

        return $value;
    }

    /**
     * Checks if the tag is setted.
     *
     * @param $name The tag name.
     * @return bool True if the tag is setted, false if not.
     */
    public function readIsTagSetted($name) {
        $query = "SELECT * FROM $this->tableName WHERE name=?";

        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 's', $name );
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
     * Read all tags.
     *
     * @return array All tags.
     */
    public function readAllTags()
    {
        $query = "SELECT * FROM $this->tableName";

        $statement = ConnectionHandler::getConnection ()->prepare($query);
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