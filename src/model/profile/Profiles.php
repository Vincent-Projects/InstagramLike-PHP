<?php

class Profiles {
  private $id;
  private $link;
  private $userId;

  public function __construct($id, $link, $userId) {
    $this->id = $id;
    $this->link = $link;
    $this->userId = $userId;
  }

  public function getId() {
    return $this->id;
  }

  public function getLink() {
    return $this->link;
  }

  public function getUserId() {
    return $this->userId;
  }
}


?>
