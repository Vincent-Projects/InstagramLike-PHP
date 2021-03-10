<?php

require_once('LikesStorage.php');


class LikesStorageMySQL implements LikesStorage {
  private $db;

  public function connectToDB() {
    $DSN = 'mysql:host=127.0.0.1;port=3306;dbname=SiteUni;charset=utf8';
    $USER = 'user-manager';
    $PASS = '1@2B3c4d';
    $this->db = new PDO($DSN, $USER, $PASS);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function read($id) {
    echo "bonjoue";
  }

  public function readByImageId($imgId) {
    $this->connectToDB();

    $data = array(
      'image_id' => $imgId
    );

    $query = "SELECT * FROM likes WHERE image_id=:image_id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
  }

  public function readByUserId($userId) {
    echo "bonjour";
  }

  public function saveNewLike(Like $like) {
    $id = $like->getId();
    $userId = $like->getUserId();
    $imageId = $like->getImageId();

    $this->connectToDB();

    $data = array(
      'id' => $id,
      'user_id' => $userId,
      'image_id' => $imageId
    );

    $query = "INSERT INTO likes(id, user_id, image_id) VALUES(:id, :user_id, :image_id)";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $statement->closeCursor();
    return 0;
  }

  public function retrieveLikeFromImage(Like $like) {
    $id = $like->getId();

    $this->connectToDB();

    $data = array(
      'id' => $id
    );

    $query = "DELETE FROM likes WHERE id=:id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $statement->closeCursor();
    return 0;
  }

  public function imageIsLiked($imgId, $userId) {
    $this->connectToDB();

    $data = array(
      'user_id' => $userId,
      'image_id' => $imgId
    );

    $query = "SELECT id FROM likes WHERE user_id=:user_id AND image_id=:image_id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $result;
  }

  public function removeByImageId($imgId) {
    $this->connectToDB();

    $data = array(
      'image_id' => $imgId
    );

    $query = "DELETE FROM likes WHERE image_id=:image_id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $statement->closeCursor();
    return 0;
  }
}

 ?>
