<?php

/**
  * Class that represent a comment on a picture
  *
  * @author Vincent Rouilhac, Simon Cardoso
  */
class Comment {
  private $id;
  private $userId;
  private $imageId;
  private $text;
  private $date;

  public function __construct($id, $user_id, $image_id, $text, $date) {
    $this->id = $id;
    $this->userId = $user_id;
    $this->imageId = $image_id;
    $this->text = $text;
    $this->date = $date;
  }

  /**
    * @return id, The id of the comment.
    */
  public function getId() {
    return $this->id;
  }

  /**
    * @return userId, The id of the owner of comment.
    */
  public function getUserId() {
    return $this->userId;
  }

  /**
    * @return imageId, The id of the image into the comment has been posted.
    */
  public function getImageId() {
    return $this->imageId;
  }

  /**
    * @return text, The content of the comment.
    */
  public function getText() {
    return $this->text;
  }

  /**
    * @return date, The date when the comment has been posted.
    */
  public function getDate() {
    return $this->date;
  }
}


?>
