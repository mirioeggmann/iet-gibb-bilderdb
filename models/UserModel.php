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
}
