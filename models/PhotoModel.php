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
 * Handles all sql queries of the photo table.
 */
class PhotoModel extends Model {
	protected $tableName = 'photo';

    /**
     * Create a new photo entry.
     *
     * @param $name The name of the photo
     * @param $type The ending of the photo.
     * @param $height The height of the photo.
     * @param $width The width of the photo.
     * @param $size The weight of the photo.
     * @param $date The date of the upload.
     * @param $userId The user id of the photo.
     * @param string $title The title of the photo.
     * @param string $description The description of the photo.
     */
	public function create($name, $type, $height, $width, $size, $date, $userId, $title = "", $description = "") {
		$query = "INSERT INTO $this->tableName (name, type, height, width, size, date, title, description, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'ssiiisssi', $name, $type, $height, $width, $size, $date, $title, $description, $userId );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

    /**
     * Read all rows by the user id.
     *
     * @param $userId The user id.
     * @return array All the rows that contain the user id.
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
     * Update the title of the photo.
     *
     * @param $title The new title.
     * @param $id The id of the photo.
     */
	public function updateTitleById($title, $id)
	{
		$query = "UPDATE $this->tableName SET title =? WHERE id=?";
	
		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $title, $id );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

    /**
     * Update the description of the photo.
     *
     * @param $description The new description.
     * @param $id The id of the photo.
     */
	public function updateDescriptionById($description, $id)
	{
		$query = "UPDATE $this->tableName SET description =? WHERE id=?";
	
		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $description, $id );
	
		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

    /**
     * Check if the photo is from the given user.
     *
     * @param $id The id of the photo.
     * @param $userId The id of the user.
     * @return bool True if the photo is from the user, false if not.
     */
	public function readIsPhotoFromUser($id, $userId) {
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