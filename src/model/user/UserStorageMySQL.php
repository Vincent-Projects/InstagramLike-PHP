<?php

require_once('src/model/user/UserStorage.php');
require_once('src/model/user/User.php');


class UserStorageMySQL implements UserStorage {
  private $db;

  public function connectToDB() {
    $DSN = 'mysql:host=127.0.0.1;port=3306;dbname=SiteUni;charset=utf8';
    $USER = 'user-manager';
    $PASS = '1@2B3c4d';
    $this->db = new PDO($DSN, $USER, $PASS);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Pour afficher les erreurs (a enlever pour la prod)
  }

  public function read($id) {
    $this->connectToDB();

    $data = array(
      'id' => $id
    );

    $query = "SELECT id, username, email, public FROM users WHERE id=:id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $us = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    $user = new User($us['username'], $us['email'], $us['id'], $us['public']);
    return $user;
  }

  /**
    * Function that return User object by reading by email
    */
  public function readByEmail($email) {
    $this->connectToDB();

    $data = array(
      'email' => $email
    );

    $query = "SELECT id, username, email, hpass, public FROM users WHERE email=:email"; //SELECT username, email, hpass, public FROM users WHERE email=:email
    $statment = $this->db->prepare($query);
    $statment->execute($data);
    $result = $statment->fetch(PDO::FETCH_ASSOC);
    $statment->closeCursor();
    return $result ? $result : -1;
  }

  public function readAllName() {
    echo "Je lis tout les noms";
  }

  /**
    * Function that register new User
    */
  public function saveNew(User $user, $id, $hpass) {
    $username = $user->getUsername();
    $isPublic = $user->getIsPublic() ? 1 : 0;
    $email = $user->getEmail();

    $infos = array(
      'id' => $id,
      'username' => $username,
      'email' => $email,
      'hpass' => $hpass,
      'isPublic' => $isPublic
    );

    $this->connectToDB();

    $query = "INSERT INTO users(id, username, email, hpass, public) VALUES(:id, :username, :email, :hpass, :isPublic)";
    $statment = $this->db->prepare($query);
    $statment->execute($infos);
    $statment->closeCursor();
    return 0;
  }

  public function modifyIsPublic(User $user) {
    $this->connectToDB();

    $data = array(
      'id' => $user->getId(),
      'public' => $user->getIsPublic()
    );

    $query = "UPDATE users SET public=:public WHERE id=:id";
    $statement = $this->db->prepare($query);
    $statement->execute($data);
    $statement->closeCursor();
    return 0;
  }
}

 ?>
