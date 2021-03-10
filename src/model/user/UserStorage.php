<?php

interface UserStorage {
  public function read($id);
  public function readByEmail($email);
  public function readAllName();
  public function saveNew(User $user, $id, $hpass);
}

 ?>
