<?php
require_once ('libraries/Model.php');
class TagModel extends Model
{
    protected $tableName = 'tag';

    public function create($name)
    {
        $query = "INSERT INTO $this->tableName (name) VALUES (?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $name);

        if (!$statement->execute()) {
            throw new Exception ($statement->error);
        }
    }

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