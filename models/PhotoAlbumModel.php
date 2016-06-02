<?php
require_once ('libraries/Model.php');
class PhotoAlbumModel extends Model
{
    protected $tableName = 'photo_album';

    public function create($photoId, $albumId)
    {
        $query = "INSERT INTO $this->tableName (photo_id, album_id) VALUES (?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ii', $photoId, $albumId);

        if (!$statement->execute()) {
            throw new Exception ($statement->error);
        }
    }

    public function readAllAlbumsByPhotoId($photoId)
    {
        $query = "SELECT album.id AS id, album.name AS name FROM $this->tableName JOIN album ON album.id=photo_album.album_id AND photo_id=?";

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

    public function readAllPhotosByAlbumId($albumId)
    {
        $query = "SELECT * FROM $this->tableName JOIN photo ON photo.id=photo_album.photo_id AND album_id=?";

        $statement = ConnectionHandler::getConnection ()->prepare($query);
        $statement->bind_param ( 'i', $albumId );
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

    public function readIsAlbumIdSettedByPhotoId($albumId, $photoId) {
        $query = "SELECT * FROM $this->tableName WHERE album_id=? AND photo_id=?";

        $statement = ConnectionHandler::getConnection ()->prepare ( $query );
        $statement->bind_param ( 'ii', $albumId, $photoId );
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