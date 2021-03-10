<?php

/**
  * Interface that represent all function to implement
  * for interact with the comment data base
  *
  * @author Vincent Rouilhac, Simon Cardoso
  */
interface CommentStorage {
  public function readById($id);
  public function readByUserId($userId);
  public function readByImageId($imageId);
  public function saveNewComment(Comment $comment);
}





?>
