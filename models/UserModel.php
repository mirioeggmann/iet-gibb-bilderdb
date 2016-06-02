<?php
require_once ('libraries/Model.php');
class UserModel extends Model {
	protected $tableName = 'user';
	
	public function create($firstName, $lastName, $userName, $email, $password) {
		$password = password_hash ( $password, PASSWORD_BCRYPT );
		
		$query = "INSERT INTO $this->tableName (firstName, lastName, userName, email, password) VALUES (?, ?, ?, ?, ?)";
		
		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'sssss', $firstName, $lastName, $userName, $email, $password );
		
		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

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

	public function updateFirstNameById($firstName, $id)
	{
		$query = "UPDATE $this->tableName SET firstName =? WHERE id=?";

		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $firstName, $id );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

	public function updateLastNameById($lastName, $id)
	{
		$query = "UPDATE $this->tableName SET lastName =? WHERE id=?";

		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $lastName, $id );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

	public function updateEmailById($email, $id)
	{
		$query = "UPDATE $this->tableName SET email =? WHERE id=?";

		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $email, $id );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

	public function updateUserNameById($userName, $id)
	{
		$query = "UPDATE $this->tableName SET userName =? WHERE id=?";

		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $userName, $id );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}

	public function updatePasswordById($password, $id)
	{
		$query = "UPDATE $this->tableName SET password =? WHERE id=?";

		$statement = ConnectionHandler::getConnection ()->prepare($query);
		$statement->bind_param ( 'si', $password, $id );

		if (! $statement->execute ()) {
			throw new Exception ( $statement->error );
		}
	}
}
