<?php

require_once('Like.php');


interface LikesStorage {
  public function read($id);
  public function readByImageId($imgId);
  public function readByUserId($userId);
  public function saveNewLike(Like $like);
  public function retrieveLikeFromImage(Like $like);
}

?>
