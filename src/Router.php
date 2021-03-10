<?php

class Router {
  private $control;

  /**
    * Main function
    */
  public function main($db, $imgDB, $likesDB, $commentDB, $profileDB) {
    $view = new MainView($this);
    $control = new Controller($view, $db, $imgDB, $likesDB, $commentDB, $profileDB);

    session_start();

    $debug = key_exists('debug', $_GET)
      ? true
      : null;

    if(key_exists('signin_error', $_SESSION)) {
      $control->showSignInPage(true);
    }

    if($debug) {
      $control->showDebugPage();
    } else if(key_exists('action', $_GET)) {
      switch($_GET['action']) {
        case "loginPage":
          $control->showLoginPage();
          break;
        case "loginVerifyPage":
          $user = $control->authentificateUser($_POST);
          ($user == 0) ? header("Location: " . $this->getHomeURL(), true, 303) : ""; // Ajouter l'erreur de connexion
          break;
        case "signinPage":
          $control->showSignInPage();
          break;
        case "signinVerifyPage":
          $control->createNewUser($_POST);
          header("Location: " . $this->getLoginFormPageURL(), true, 303);
          break;
        case "logout":
          $control->logout();
          header("Location: " . $this->getHomeURL(), true, 303);
          break;
        case "addImage":
          $control->showAddImagePage();
          break;
        case "imageAdded":
          $control->addImage();
          header("Location: " . $this->getHomeURL(), true, 303);
          break;
        case "likefromhome":
          if(key_exists('imgId', $_GET)) {
          	$control->addLikeToPicture($_GET['imgId'], $_SESSION['user']);
          	header("Location: " . $this->getHomeURL(), true, 303);
          }
		      break;
		    case "imgdetail":
    		  if(key_exists('imgId', $_GET)) {
    			$image = $control->getImageByID($_GET['imgId']);
    			$control->showImageDetailPage($image);
    		  }
          break;
        case "deleteimg":
          if(key_exists('delete', $_SESSION)) {
            $control->deleteImg($_SESSION['delete']);
            header("Location: " . $this->getHomeURL(), true, 303);
          }
          break;
        case "changestatus":
          $control->changeStatus();
          header("Location: " . $this->getProfilePageURL($_SESSION['user']->getId()), true, 303);
          break;
        case "imgProfile":
          $control->showAddProfileImagePage();
          break;
        case "imgProfileAdded":
          $control->addProfileImage();
          header("Location: " . $this->getProfilePageURL($_SESSION['user']->getId()), true, 303);
        case "comsending":
          if(key_exists('imgId', $_GET)){
            $control->addCommentToImage($_POST, $_GET['imgId']);
            header("Location: " . $this->getImageDetailsURL($_GET['imgId']), true, 303);
          }
      }
    } else if(key_exists('profilePage', $_GET)) {
		  $images = $control->retrieveUserImages($_GET['id']);
      $isPublic = $control->isProfilePublic($_GET['id']);
	    $control->showUserProfilePage($images, $_GET['id'], $isPublic);
    } else {
		  $images = $control->loadHomeFeedImages($_SESSION['user']);
      if(key_exists('user', $_SESSION)) {
        $control->showHomePage($images, true);
      } else {
        $control->showHomePage($images, false);
      }
    }

    $view->render();
  }

  /**
    * URL computing
    */
  public function getHomeURL() {
    return "index.php";
  }

  public function getLoginFormPageURL() {
    return ".?action=loginPage";
  }

  public function getLoginVerificationPageURL() {
    return ".?action=loginVerifyPage";
  }

  public function getSignInFormPageURL() {
    return ".?action=signinPage";
  }

  public function getSignInVerificationPageURL() {
    return ".?action=signinVerifyPage";
  }

  public function getProfilePageURL($userId) {
    return ".?profilePage&id=" . $userId;
  }

  public function getLogoutPageURL() {
    return ".?action=logout";
  }

  public function getAddImageFormURL() {
    return ".?action=addImage";
  }

  public function getAddImagePageURL() {
    return ".?action=imageAdded";
  }

  public function getLikeFromHomeURL($imgId) {
    return ".?action=likefromhome&imgId=" . $imgId;
  }

  public function getImageDetailsURL($imgId) {
	   return ".?action=imgdetail&imgId=" . $imgId;
  }

  public function getDeleteImageURL($img) {
    $_SESSION['delete'] = $img;
    return ".?action=deleteimg";
  }
  public function getChangePublicStatusURL() {
    return ".?action=changestatus";
  }

  public function getAddProfileImageURL() {
    return ".?action=imgProfile";
  }

  public function getAddedProfileImageURL() {
    return ".?action=imgProfileAdded";
  }

  public function getCommentSendingURL($imgId) {
    return ".?action=comsending&imgId=" . $imgId;
  }

}

 ?>
