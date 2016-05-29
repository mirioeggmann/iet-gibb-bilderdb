<?php
require_once ('libraries/Model.php');
class PhotoModel extends Model {
	protected $tableName = 'photo';
	
	public function create($name, $type, $height, $width, $size, $date, $userId, $title = "", $description = "") {
		$query = "INSERT INTO $this->tableName (name, type, height, width, size, date, title, description, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

		$statement = ConnectionHandler::getConnection ()->prepare ( $query );
		$statement->bind_param ( 'ssiiisssi', $name, $type, $height, $width, $size, $date, $title, $description, $userId );

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
}