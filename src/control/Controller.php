<?php

require_once("src/model/user/User.php");
require_once("src/model/image/Image.php");
require_once("src/model/likes/Like.php");
require_once("src/model/profile/Profiles.php");
require_once("src/model/comment/Comment.php");


/**
  * This is the controller, each function do a specific action for the view with the data the view needed
  *
  * @author Vincent Rouilhac, Simon Cardoso
  */
class Controller {
  private $view;
  private $db;
  private $imgDB;
  private $likesDB;
  private $commentDB;
  private $profileDB;

  /**
    * The controller takes the main view and each storage type file
    */
  public function __construct($view,UserStorage $db,ImageStorage $imgDB,LikesStorage $likesDB, CommentStorage $commentDB, ProfileStorage $profileDB) {
    $this->view = $view;
    $this->db = $db;
    $this->imgDB = $imgDB;
    $this->likesDB = $likesDB;
    $this->commentDB = $commentDB;
    $this->profileDB = $profileDB;
  }

  /** ##############################################################################
    *                                USERS FUNCTIONS
    * ############################################################################## */

  /**
    * Take the user's info and create a new user before saving it to the database
    */
  public function createNewUser($newUserInfo) {
    $id = uniqid(rand());

    $username = $newUserInfo['username']
      ? htmlspecialchars($newUserInfo['username'])
      : null;

    $email = $newUserInfo['email']
      ? htmlspecialchars($newUserInfo['email'])
      : null;

    $password = $newUserInfo['pass']
      ? htmlspecialchars($newUserInfo['pass'])
      : null;

    $confirmPass = $newUserInfo['confirm']
      ? htmlspecialchars($newUserInfo['confirm'])
      : null;

    if($password === $confirmPass && $password !== "") {
      /*$hpass = password_hash($password, PASSWORD_BCRYPT);
      $user = new User($username, $email);
      $this->db->saveNew($user, $id, $hpass);*/

      $hpass = password_hash($password, PASSWORD_BCRYPT);

      $data = array(
        'username' => $username,
        'email' => $email,
        'hpass' => $password,
        'isPublic' => 1,
        'id' => $id
      );

      $userBuilder = new UserBuilder($data);

      if($userBuilder->isValid()) {
        $user = new User($username, $email, $id);
        $this->db->saveNew($user, $id, $hpass);
      } else {
        $_SESSION['signin_error'] = $userBuilder->getErrors();
        $_SESSION['signin_err_info'] = $userBuilder->getData();
      }
    }
  }

  /**
    * Authentificate the user if the email is in database and password matches the hash.
    * @return 0 if the Authentification went good -1 otherwise
    */
  public function authentificateUser($userInfo) {
    $email = $userInfo['email'];

    $userTab = $this->db->readByEmail($email);
    if($userTab != -1) {
      if(password_verify($userInfo['pass'], $userTab['hpass'])){
        $user = new User($userTab['username'], $userTab['email'], $userTab['id'], $userTab['public']);
        $_SESSION['user'] = $user;
      }
    } else {
      return -1;
    }
    return 0;
  }

  public function logout() {
    session_destroy();
  }

  public function retrieveUserImages($userId) {
  	$images = $this->imgDB->readByUserId($userId);
  	return $images;
  }

  public function changeStatus() {
    if(key_exists('user', $_SESSION)) {
      $user = $_SESSION['user'];
      $user->changeStatus();

      $this->db->modifyIsPublic($user);
    }
  }

  public function isProfilePublic($userId) {
    $user = $this->db->read($userId);
    $isPublic = $user->getIsPublic();
    return $isPublic;
  }

  /** ##############################################################################
    *                                IMAGES FUNCTIONS
    * ############################################################################## */
  public function addImage() {
    $link ="";
    $imgLink= "";
    $imgTitle ="";
    $id = uniqid(rand());
    if(key_exists('image', $_FILES)) {
      $name = $_FILES['image']['name'];
      $type = $_FILES['image']['type'];
    if($type !== 'image/png' && $type !== 'image/jpeg' && $type !== 'image/jpg' && $type !== 'image/JPG') {
        echo "Il y a une erreur de type !";
        return -1; /* Ajouter une erreur et un feed back */
      } else {
        $imgType = "";
        switch($type) {
          case 'image/png':
            $imgType = "png";
            break;
          case 'image/jpeg':
            $imgType = "jpeg";
            break;
          case 'image/jpg':
            $imgType = "jpg";
            break;
          case 'image/JPG':
            $imgType = "JPG";
            break;
        }
        $link = $_SERVER['DOCUMENT_ROOT'] . "/UniWeb/SiteFac/FinalSite/images/" . $id . "." . $imgType;
        $imgLink = "images/" . $id . "." . $imgType;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $link)) {
          echo "copy good";
        } else {
          echo "copy bad";
        }
      }
      $size = $_FILES['image']['size'];
      $alt = "";
      if(key_exists('alt', $_POST)) {
        $alt = $_POST['alt'];
      }

      if(key_exists('title', $_POST)) {
        $imgTitle = $_POST['title'];
      }

      $image = new Image($imgLink, $alt, $imgTitle);
      $user = $_SESSION['user'];
      $userId = $user->getId();
      $date = date("Y-m-d-H-00-00");
      $this->imgDB->saveNew($image, $id, $userId, $date);
    }
    return $id;
  }

  public function loadHomeFeedImages($user=0) {
    $images = $this->imgDB->readAllLastNImg(10);
    $imagesTab = [];

    if($user == 0) {
      foreach ($images as $key => $image) {
        $isLiked = false;
        $image['isLiked'] = $isLiked;
        $owner = $this->db->read($image['user_id']);
        $image['owner'] = $owner->getUsername();
        $imagesTab[$key] = $image;
      }
    } else {
      $userId = $user->getId();

      foreach ($images as $key => $image) {
        $isLiked = $this->likesDB->imageIsLiked($image['id'], $userId) ? true : false; // Si l'utilisateur connecté l'a liker
        $image['isLiked'] = $isLiked;
        $owner = $this->db->read($image['user_id']);
        $image['owner'] = $owner->getUsername();
        $imagesTab[$key] = $image;
      }
    }

    return $imagesTab;
	}

	public function getImageByID($imgId) {
		$image = $this->imgDB->read($imgId);
		return $image;
	}

  public function deleteImg($img) {
    $imgId = $img['id'];

    $this->imgDB->removeById($imgId);
    $this->likesDB->removeByImageId($imgId);
    chmod($img['link'], 777);
    unlink($img['link']);
  }

  /** ##############################################################################
    *                                LIKES FUNCTIONS
    * ############################################################################## */
  public function addLikeToPicture($imgId, $user) {
    $userId = $user->getId();
    $id = uniqid(rand());
    $tabLikes = $this->likesDB->readByImageId($imgId); //D'abord on recupère les likes qui ont pour image_id celle sur laquel on vient de cliqué
    // Ensuite on va verifié si notre utilisateur à déjà liké la photo si ce n'est pas le cas il va la liké sinon il va la disliké
    $isAlreadyLiked = false;
    foreach ($tabLikes as $key => $values) {
      if($userId === $values['user_id']) {
        $isAlreadyLiked = true;
        $id = $values['id'];
      }
    }

    $like = new Like($id, $userId, $imgId);

    if(!$isAlreadyLiked) {
      $this->likesDB->saveNewLike($like);
      $this->imgDB->modifyImgLikesByImgAndUser($like, true);
    } else {
      $this->likesDB->retrieveLikeFromImage($like);
      $this->imgDB->modifyImgLikesByImgAndUser($like, false);
    }
  }

/** ##############################################################################
  *                                PROFILE FUNCTIONS
  * ############################################################################## */
  public function addProfileImage() {
    $link ="";
    $imgLink = "";
    $imgType ="";
    $id = uniqid(rand());
    if(key_exists('image', $_FILES)) {
      $name = $_FILES['image']['name'];
      $type = $_FILES['image']['type'];
    if($type !== 'image/png' && $type !== 'image/jpeg' && $type !== 'image/jpg' && $type !== 'image/JPG') {
        echo "Il y a une erreur de type !";
        return -1; /* Ajouter une erreur et un feed back */
      } else {
        switch($type) {
          case 'image/png':
            $imgType = "png";
            break;
          case 'image/jpeg':
            $imgType = "jpeg";
            break;
          case 'image/jpg':
            $imgType = "jpg";
            break;
          case 'image/JPG':
            $imgType = "JPG";
            break;
        }
        $link = $_SERVER['DOCUMENT_ROOT'] . "/UniWeb/SiteFac/FinalSite/profileImages/" . $id . "." . $imgType;
        $imgLink = "profileImages/" . $id . "." . $imgType;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $link)) {
          echo "copy good";
        } else {
          echo "copy bad";
        }
      }
      $size = $_FILES['image']['size'];
      $user = $_SESSION['user'];
      $userId = $user->getId();
      $prof = new Profiles($id, $imgLink, $userId);
      echo $imgLink;
      $this->profileDB->saveNew($prof);
    }
    return $id;
  }

  public function getProfileImageLink($userId) {
    $profile = $this->profileDB->retrieveProfileByUserId($userId);
    return $profile->getLink();
  }

  /** ##############################################################################
    *                                COMMENTS FUNCTIONS
    * ############################################################################## */
  public function addCommentToImage($values, $imgId) {
    $id = uniqid(rand());
    $user = (key_exists('user', $_SESSION)) ? $_SESSION['user'] : false;

    if($user != false) {
      echo "je suis la";
      $comment = new Comment($id, $user->getId(), $imgId, $values['comment'], date("Y-m-d-H-00-00"));
      $this->commentDB->saveNewComment($comment);
    }
  }

  /** ##############################################################################
    *                                VIEW MAKER FUNCTIONS
    * ############################################################################## */
  public function showDebugPage() {
    $this->view->makeDebugPage();
  }

  public function showHomePage($images, $isLogged) {
    $this->view->makeHomePage($images, $isLogged);
  }

  public function showLoginPage() {
    $this->view->makeLoginForm();
  }

  public function showSignInPage($errors=false) {
    $this->view->makeSignInForm($error);
  }

  public function showUserProfilePage($images, $userId, $isPublic) {
     $link = $this->getProfileImageLink($userId);
     $this->view->makeProfilePage($images, $userId, $isPublic, $link);
  }

  public function showAddImagePage() {
    $this->view->makeAddImagePage();
  }

  public function showImageDetailPage($image) {
    $comList = $this->commentDB->readByImageId($image['id']);
    $coms = [];

    foreach($comList as $index => $values) {
      $user = $this->db->read($values['user_id']);
      $username = $user->getUsername();
      $coms[$index] = array(
          'uname' => $username,
          'text' => $values['text']
      );
    }

	  $this->view->makeImageDetailPage($image, $coms);
  }

  public function showAddProfileImagePage() {
    $this->view->makeAddProfileImagePage();
  }
}

 ?>
