<?php

interface ImageStorage {
  public function read($id);
  public function readByUserId($userId);
  public function readAllLastNImg($nLastIage); /* Prend un entier et retourne les n derniere image enrigstrer sur la table */
  public function saveNew(Image $image, $imgId, $userId, $date);
}

 ?>
