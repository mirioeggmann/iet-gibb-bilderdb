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
 * Handles all queries of the user table.
 */
class UserModel extends Model {

    /**
     * @var string The table name.
     */
	protected $tableName = 'user';

    /**
     * Create a new user entry.
     *
     * @param $firstName The first name.
     * @param $lastName The last name.
     * @param $userName The user name.
     * @param $email The email of the user.
     * @param $password The password of the user.
     */
	public function create($firstName, $lastName, $userName, $email, $password) {
		$password = password_hash ( $password, PASSWORD_BCRYPT );
		
		$query = "INSERT INTO $this->tableName (firstName, lastName, userName, email, password) VALUES (?, ?, ?, ?, ?)";
		
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'sssss', $firstName, $lastName, $userName, $email, $password );
		
		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

    /**
     * Read all infos of the user.
     *
     * @param $id The user id.
     * @return array All elements of the user.
     */
	public function readAllByUserId($id)
	{
		$query = "SELECT * FROM $this->tableName WHERE id=?";

		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'i', $id );
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
     * Read the user id by the user name.
     *
     * @param $userName The user name.
     * @return mixed The id of the user.
     */
	public function readIdByUsername($userName) {
		$query = "SELECT id FROM $this->tableName WHERE userName=?";
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 's', $userName );
		$statement->execute ();
		$result = $statement->get_result();

		$row = $result->fetch_assoc();
		$value = $row['id'];

		$result->close();

		return $value;
	}

    /**
     * Read the user id by the user email.
     *
     * @param $email The email of the user.
     * @return mixed the id of the user.
     */
	public function readIdByEmail($email) {
		$query = "SELECT id FROM $this->tableName WHERE email=?";
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 's', $email );
		$statement->execute ();
		$result = $statement->get_result();

		$row = $result->fetch_assoc();
		$value = $row['id'];

		$result->close();

		return $value;
	}

    /**
     * Read the username by the user id.
     *
     * @param $id The id of the user.
     * @return mixed The username of the user.
     */
	public function readUserNameById($id) {
		$query = "SELECT userName FROM $this->tableName WHERE id=?";
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 's', $id );
		$statement->execute ();
		$result = $statement->get_result();

		$row = $result->fetch_assoc();
		$value = $row['userName'];

		$result->close();

		return $value;
	}

    /**
     * Read the password by the email.
     *
     * @param $email The email of the user.
     * @return mixed The password of the user.
     */
	public function readPasswordByEmail($email) {
		$query = "SELECT password FROM $this->tableName WHERE email=?";
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 's', $email );
		$statement->execute ();
		$result = $statement->get_result();
		
		$row = $result->fetch_assoc();
		$value = $row['password'];
		
		$result->close();
	
		return $value;
	}

    /**
     * Read the password by the username.
     *
     * @param $userName The username of the user.
     * @return mixed The password of the user.
     */
	public function readPasswordByUsername($userName) {
		$query = "SELECT password FROM $this->tableName WHERE userName=?";
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 's', $userName );
		$statement->execute ();
		$result = $statement->get_result();
	
		$row = $result->fetch_assoc();
		$value = $row['password'];
	
		$result->close();
	
		return $value;
	}
	
	/**
	 * Checks if email was already used and returns true or false.
	 *
	 * @param unknown $email        	
	 */
	public function readIsEmailUsed($email) {
		$query = "SELECT * FROM $this->tableName WHERE email=?";
		
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 's', $email );
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
	 * Checks if email was already used and returns true or false.
	 *
	 * @param unknown $email        	
	 */
	public function readIsUsernameUsed($userName) {
		$query = "SELECT * FROM $this->tableName WHERE userName=?";
		
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 's', $userName );
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
     * Update the first name by the user id.
     *
     * @param $firstName The new first name.
     * @param $id The user id.
     */
	public function updateFirstNameById($firstName, $id)
	{
		$query = "UPDATE $this->tableName SET firstName =? WHERE id=?";

		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $firstName, $id );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

    /**
     * Update the last name by the user id.
     *
     * @param $lastName The new last name.
     * @param $id The user id.
     */
	public function updateLastNameById($lastName, $id)
	{
		$query = "UPDATE $this->tableName SET lastName =? WHERE id=?";

		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $lastName, $id );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

    /**
     * Update the email by the user id.
     *
     * @param $email The new email.
     * @param $id The user id.
     */
	public function updateEmailById($email, $id)
	{
		$query = "UPDATE $this->tableName SET email =? WHERE id=?";

		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $email, $id );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

    /**
     * Update the username by the user id.
     *
     * @param $userName The new username.
     * @param $id The user id.
     */
	public function updateUserNameById($userName, $id)
	{
		$query = "UPDATE $this->tableName SET userName =? WHERE id=?";

		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $userName, $id );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

    /**
     * Update the password by the user id.
     *
     * @param $password The new password.
     * @param $id The user id.
     */
	public function updatePasswordById($password, $id)
	{
		$password = password_hash ( $password, PASSWORD_BCRYPT );

		$query = "UPDATE $this->tableName SET password =? WHERE id=?";

		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $password, $id );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}
}
