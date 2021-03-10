<?php

class UserBuilder {
  private $data;
  private $errors;

  public function __construct($data) {
    if($data === null) {
      $data = array(
        'username' => "",
        'email' => "",
        'hpass' => "",
        'isPublic' => "",
        'id' => ""
      );
    }

    $this->data = $data;
    $this->errors = array();
  }

  public function getData() {
    return $this->data;
  }

  public function getErrors() {
    return $this->errors;
  }

  public function isValid() {
    $this->errors = array();

    if(!key_exists('username', $this->data) || $this->data["username"] === "") {
      $this->errors["userName"] = "You should enter a username";
    } else if(count($this->data["username"]) >= 15) {
      $this->errors["username"] = "Please enter username with less than 15 characters";
    } else if(!preg_match("/^[0-9a-zA-Z]", $this->data["username"])) {
      $this->errors["username"] = "Other characters than letters and number are not allowed";
    }

    return count($this->errors) === 0;
  }
}




?>
