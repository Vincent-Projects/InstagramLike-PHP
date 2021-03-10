<?php

require_once('src/model/image/ImageStorage.php');


class ImageStorageMySQL implements ImageStorage {
  private $db;

  public function connectToDB() {
    $DSN = 'mysql:host=127.0.0.1;port=3306;dbname=SiteUni;charset=utf8';
    $USER = 'user-manager';
    $PASS = '1@2B3c4d';
    $this->db = new PDO($DSN, $USER, $PASS);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function read($id) {
	$this->connectToDB();

	$data = array(
		'id' => $id,
	);

	$query = "SELECT * FROM images WHERE id=:id";
	$statement = $this->db->prepare($query);
	$statement->execute($data);
	$result = $statement->fetch(PDO::FETCH_ASSOC);
	$statement->closeCursor();
	return $result;
  }

  public function readByUserId($userId) {
    $this->connectToDB();

	$data = array(
		'user_id' => $userId
	);

	$query = "SELECT id, link, alt, likes, title FROM images WHERE user_id=:user_id";
	$statement = $this->db->prepare($query);
	$statement->execute($data);
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	$statement->closeCursor();
	return $result;
  }

  public function readAllLastNImg($nLastImage) {
	$this->connectToDB();

  $query = "SELECT * FROM images ORDER BY date DESC LIMIT 10";
	$statement = $this->db->prepare($query);
	$statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	$statement->closeCursor();
  return $result;
  }

  public function saveNew(Image $image, $imgId, $userId, $date) {
    $link = $image->getLink();
    $likes = $image->getLikes();
    $alt = $image->getAlt();
    $data = array(
      'id' => $imgId,
      'link' => $link,
      'alt' => $alt,
      'user_id' => $userId,
      'likes' => $likes,
	  'date' => $date,
    'title' => $image->getTitle()
    );

    $this->connectToDB();

    $query = "INSERT INTO images(id, link, title, alt, user_id, likes, date) VALUES(:id, :link, :title, :alt, :user_id, :likes, :date)";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $statement->closeCursor();
    return 0;
  }

  public function modifyImgLikesByImgAndUser(Like $like, $addBool) {
    $likeId = $like->getId();
    $userId = $like->getUserId();
    $imageId = $like->getImageId();

    $this->connectToDB();

    $data = array(
      'id' => $imageId
    );

    $query = "SELECT likes FROM images WHERE id=:id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    $nbrLike = $addBool ? $result['likes'] +1 : $result['likes'] -1;

    $data = array(
      'id' => $imageId,
      'likes' => $nbrLike
    );

    $query = "UPDATE images SET likes=:likes WHERE id=:id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $statement->closeCursor();
    return 0;
  }

  public function removeById($imgId) {
    $this->connectToDB();

    $data = array(
      'id' => $imgId
    );

    $query = "DELETE FROM images WHERE id=:id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $statement->closeCursor();
    return 0;
  }
}


 ?>
