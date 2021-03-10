<?php

/**
  * This class represent a user with a username, an email and the hash
  * of his password, his profile status, the id and a tab that contain his pictures
  *
  * @author Vincent Rouilhac, Simon Cardoso
  */
class User {
  private $id;
  private $username;
  private $email;
  private $hpass;
  private $isPublic;
  private $images;
  private $imgProfileId;

  public function __construct($username, $email, $id, $hpass, $isPublic=true, $images=null, $imgProfId=null) {
    $this->id = $id;
    $this->username = $username;
    $this->email = $email;
    $this->hpass = $hpass;
  	$this->isPublic = $isPublic;
  	$this->images = $images ? $images : array();
    $this->imgProfileId = $imgProfId;
  }

  /**
    * Change the user's profile status public or not.
    */
  public function changeStatus() {
    $this->isPublic = !$this->isPublic;
  }

  /**
    * @return username
    */
  public function getUsername() {
    return $this->username;
  }

  /**
    * @return email
    */
  public function getEmail() {
    return $this->email;
  }

  /**
    * @return id
    */
  public function getId() {
    return $this->id;
  }

  /**
    * @return hpass, the hash of password
    */
  public function getHPass() {
    return $this->hpass;
  }

  /**
    * @return isPublic, if 1 then the profile is public 0 otherwise
    */
  public function getIsPublic() {
    return $this->isPublic ? 1 : 0;
  }

  /**
    * @return images
    */
  public function getImagesList() {
	 return $this->images;
  }

  /**
    * @return imgProfileId, the id of user's image profile
    */
  public function getImgProfileId() {
    return $this->imgProfileId;
  }
}

?>
