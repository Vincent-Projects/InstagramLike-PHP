<?php

require_once('src/model/profile/Profiles.php');

interface ProfileStorage {
  public function saveNew(Profiles $profile);
  public function retrieveProfileByUserId($userId);
  public function modifyProfile(Profiles $newProfile);
}


 ?>
