<?php

require_once('libraries/Model.php');

class UserModel extends Model
{
    protected $tableName = 'user';

    public function create($firstName, $lastName, $userName, $email, $password)
    {
        $password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO $this->tableName (firstName, lastName, userName, email, password) VALUES (?, ?, ?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('sssss', $firstName, $lastName, $userName, $email, $password);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }
    }
}
