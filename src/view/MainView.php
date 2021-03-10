<?php
require_once('LogSignView.php');
require_once('ImageDetail.php');
require_once('AddImage.php');
require_once('Profile.php');
require_once('Home.php');
require_once('AddProfileImg.php');


class MainView {
  private $router;
  private $logsign;
  private $imageDetail;
  private $profile;
  private $home;
  private $content;
  private $addImage;
  private $addProfileImg;

  private $structure;
  private $debugContent;
  private $title;
  private $header;
  private $profileButton;
  private $logoutButton;
  private $addImageForm;
  private $imagesHomeContainer;

  public function __construct($router) {
    $this->router = $router;
    $this->logsign = new LogSignView($router);
    $this->profile = new Profile($router);
    $this->imageDetail = new ImageDetail($router);
    $this->home = new Home($router);
    $this->addImage = new AddImage($router);
    $this->addProfileImg = new AddProfileImg($router);
  }

/**
  * Page maker
  */
  public function makeDebugPage() {
    $this->structure = "debug";
    $this->title = "DEBUG PAGE";
    $this->debugContent = "
      <p>This is the debug page</p>
      <p>Title : $this->title</p>
    ";
  }

  public function makeHomePage($images, $isLogged) {
    $this->makeHeader();
    $this->structure = "main";
    $this->title = "SharePics";
    $this->home->makeHomePage($images, $isLogged);
    $this->content = $this->home->getContent();
  }

/**
  * Generate the Log in page
  */
  public function makeLoginForm() {
    $this->makeHeader();
    $this->structure = "main";
    $this->title = "SharePics";
    $this->logsign->makeLoginForm();
    $this->content = $this->logsign->getContent();
  }

/**
  * Generate the Sign in page
  */
  public function makeSignInForm($errors) {
    $this->makeHeader();
    $this->structure = "main";
    $this->title = "SharePics";
    $this->logsign->makeSignInForm($errors);
    $this->content = $this->logsign->getContent();
  }

  public function makeHeaderLogo() {
    return '<a id="header-logo-container" href="' . $this->router->getHomeURL() . '"><img id="header-logo-img" src="images/logo.png" alt="Logo du site"></a>';
  }

  public function makeAddProfileImagePage() {
    $this->makeHeader();
    $this->structure = "main";
    $this->title = "SharePics";
    $this->content = $this->addProfileImg->addProfileImage();
  }

  public function makeHeader() {
    if(key_exists('user', $_SESSION)) {
      $this->profileButton = '
        <a id="header-profile-button-container" href="' . $this->router->getProfilePageURL($_SESSION['user']->getId()) . '">
          <img id="header-profile-button-img" src="drawable/unknown_profile_image.png" alt="User profile image" />
        </a>
      ';
      $this->logoutButton = '
        <div id="header-logout-button-container">
          <a id="header-logout-button-content" href="' . $this->router->getLogoutPageURL() . '">
            Log out
          </a>
        </div>
      ';
      $searchBar = '<div id="header-search-bar-container"><input id="header-search-bar-input" type="text" placeholder="Rechercher" /></div>';

      $this->header = '
        ' . $this->makeHeaderLogo() . '<div id="header-nav-bar-container"> ' . $searchBar . '' . $this->profileButton . '' . $this->logoutButton . '</div>';
    } else {
      $this->header = '
        ' . $this->makeHeaderLogo() . '
        <ul id="header-unlogged-nav-container">
          <li class="header-unlogged-nav-item"><a href="' . $this->router->getLoginFormPageURL() . '" class="header-nav-content">Log in</a></li>
          <li class="header-unlogged-nav-item"><a href="' . $this->router->getSignInFormPageURL() . '" class="header-nav-content">Sign in</a></li>
        </ul>
      ';
    }
  }

  public function makeImageDetailPage($image, $comList) {
    $this->structure = "main";
    $this->makeHeader();
    $this->content = $this->imageDetail->makeImageDetailPage($image, $comList);
  }

  public function makeProfilePage($images, $userId, $isPublic, $profileLink) {
    $this->structure = "main";
    $this->makeHeader();
    $this->profile->makeProfilePage($images, $userId, $isPublic, $profileLink);
    $this->content = $this->profile->getContent();
  }

  public function makeAddImagePage() {
    $this->makeHeader();
    $this->structure = "main";
    $this->title = "SharePics";
    $this->addImage->makeAddImagePage();
    $this->content = $this->addImage->getContent();
  }

/**
* Accessors
*/
  public function getTitle() {
    return $this->title;
  }

  public function getContent() {
    return $this->content;
  }

  public function getDebugContent() {
    return $this->debugContent;
  }

  public function getHeader() {
    return $this->header;
  }

  public function getProfileImage() {
    return $this->profileImg;
  }

  public function getProfileFeedList() {
    return $this->profileFeed;
  }

  public function getProfilePageContent() {
    return $this->profileImg . $this->profileFeedBar . $this->profileFeed;
  }

  public function getAddImageForm() {
    return $this->addImageForm;
  }

  public function getImagesHomeContainer() {
    return $this->imagesHomeContainer;
  }

/**
  * Function that render all we need into the view
  */
  public function render() {
    switch($this->structure) {
      case "main":
        include("structures/mainStructure.php");
        break;
      case "debug":
        include("structures/debugStructure.php");
        break;
    }
  }
}


?>
