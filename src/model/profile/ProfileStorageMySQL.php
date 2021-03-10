<?php

require_once('src/model/profile/ProfileStorage.php');

class ProfileStorageMySQL implements ProfileStorage {
  private $db;

  public function connectToDB() {
    $DSN = 'mysql:host=127.0.0.1;port=3306;dbname=SiteUni;charset=utf8';
    $USER = 'user-manager';
    $PASS = '1@2B3c4d';
    $this->db = new PDO($DSN, $USER, $PASS);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function saveNew(Profiles $profile) {
    $id = $profile->getId();
    $link = $profile->getLink();
    $user_id = $profile->getUserId();

    $data = array(
      'id' => $id,
      'link' => $link,
      'user_id' => $user_id
    );

    $this->connectToDB();

    $query = "INSERT INTO profile(id, link, user_id) VALUES(:id, :link, :user_id)";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $statement->closeCursor();
    return 0;
  }

  public function retrieveProfileByUserId($userId) {
    $data = array(
      'user_id' => $userId
    );

    $this->connectToDB();

    $query = "SELECT * FROM profile WHERE user_id=:user_id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return new Profiles($result['id'], $result['link'], $result['user_id']);
  }

  public function modifyProfile(Profiles $newProfile) {
    echo "lol";
  }
}


 ?>
