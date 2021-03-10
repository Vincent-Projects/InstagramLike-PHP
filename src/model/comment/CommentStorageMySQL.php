<?php

require_once('src/model/comment/CommentStorage.php');

/**
  * Class that implement CommentStorage to interact with comment database
  *
  * @author Vincent Rouilhac, Simon Cardoso
  */
class CommentStorageMySQL implements CommentStorage {
  private $db;

  /**
    * Connect to MySQL database using PDO object.
    */
  public function connectToDB() {
    $DSN = 'mysql:host=127.0.0.1;port=3306;dbname=SiteUni;charset=utf8';
    $USER = 'user-manager';
    $PASS = '1@2B3c4d';
    $this->db = new PDO($DSN, $USER, $PASS);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  /**
    * @return comment, The comment that own the id.
    */
  public function readById($id) {
    $this->connectToDB();

    $data = array(
      'id' => $id
    );

    $query = "SELECT * FROM comments WHERE id=:id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $comment = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $comment;
  }

  /**
    * @return commentList, The list of comments posted by the user that own the userId.
    */
  public function readByUserId($userId) {
    $this->connectToDB();

    $data = array(
      'user_id' => $userId
    );

    $query = "SELECT * FROM comments WHERE user_id=:user_id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $commentList = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $commentList;
  }

  /**
    * @return commentList, The list of comments posted on the image that own the imageId.
    */
  public function readByImageId($imageId) {
    $this->connectToDB();

    $data = array(
      'image_id' => $imageId
    );

    $query = "SELECT * FROM comments WHERE image_id=:image_id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $commentList = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $commentList;
  }

  /**
    * Save a new Comment into the comment database
    */
  public function saveNewComment(Comment $comment) {
    $this->connectToDB();

    $data = array(
      'id' => $comment->getId(),
      'user_id' => $comment->getUserId(),
      'image_id' => $comment->getImageId(),
      'text' => $comment->getText(),
      'date' => $comment->getDate()
    );

    $query = "INSERT INTO comments(id, user_id, image_id, text, date) VALUES(:id, :user_id, :image_id, :text, :date)";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $statement->closeCursor();
    return 0;
  }
}




?>
