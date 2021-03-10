<?php

class Like {
  private $id;
  private $user_id;
  private $image_id;

  public function __construct($id, $userId, $imageId) {
    $this->id = $id;
    $this->user_id = $userId;
    $this->image_id = $imageId;
  }

  public function getId() {
    return $this->id;
  }

  public function getUserId() {
    return $this->user_id;
  }

  public function getImageId() {
    return $this->image_id;
  }
}

 ?>
