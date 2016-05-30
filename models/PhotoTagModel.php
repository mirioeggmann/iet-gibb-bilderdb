<?php
require_once ('libraries/Model.php');
class PhotoTagModel extends Model
{
    protected $tableName = 'photo_tag';

    public function create($photoId, $tagId)
    {
        $query = "INSERT INTO $this->tableName (photo_id, tag_id) VALUES (?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $photoId, $tagId);

        if (!$statement->execute()) {
            throw new Exception ($statement->error);
        }
    }

    public function readIsPhotoTagSetted($photoId, $tagId) {
        $query = "SELECT * FROM $this->tableName WHERE photo_id=? AND tag_id=?";

        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 'ii', $photoId, $tagId );
        $statement->execute ();

        $statement->store_result ();
        $num_of_rows = $statement->num_rows;

        if ($num_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function readAllTagsByPhotoId($photoId)
    {
        $query = "SELECT tag.name AS name FROM $this->tableName JOIN tag ON tag.id=photo_tag.tag_id AND photo_id=?";

        $statement = ConnectionHandler::getConnection ()->prepare($query);
        $statement->bind_param ( 'i', $photoId );
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