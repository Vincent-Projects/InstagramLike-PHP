<?php

/**
  * This class represent the profile page of a user. It can be represented as 3 states.
  * Logged and Owner : is the state where you are logged and you are seeing your profile page.
  * Logged : is the state where you are logged and seeing the other user's profile page.
  * Unlogged : is the state where you are seeing a user's page but if it is marked as non public you couldn't see the pictures.
  *
  * @author Vincent Rouihac, Simon Cardoso.
  */

class Profile {
  private $router;
  private $content;

  public function __construct($router) {
    $this->router = $router;
  }

  /**
    * Create the content of profile page considering you are logged, the profile page is public of you are visiting your own page.
    * $image : an array of images of the user's profile page.
    * $userId : The id of the user you are visiting the profile page.
    * $isPublic : if the profile page is public true of 1 and false or 0 otherwise
    */
  public function makeProfilePage($images, $userId, $isPublic, $profileLink) {
    $profileFeedBar = "";
    $profileImg = "";

    if(key_exists('user', $_SESSION) && $_SESSION['user']->getId() === $userId) { // Logged and Owner
      $user = $_SESSION['user'];
      $profileImg = '<img id="profile-image" class="try" src="' . $profileLink . '" alt="This is the user image" />';
      $profileImg .= '<input id="profile-image-modify" class="try" type="button" value="modifier" onClick="location=\'' . $this->router->getAddProfileImageURL() . '\'" />';

      $profileFeedBar .= '<div id="profile-feed-bar-container">';
      $profileFeedBar .= '  <input id="profile-feed-bar-add-input" type="button" value="Add" onClick="location=\'' . $this->router->getAddImageFormURL() . '\'">';
      $profileFeedBar .= '  <div id="profile-feed-bar-public-container">';
      $profileFeedBar .= '    <p id="profile-feed-bar-public-text">Public profile (' . ($isPublic ? "Oui" : "Non") . ')</p>';
      $profileFeedBar .= '    <input id="profile-feed-bar-public-input" type="button" value=' . ($user->getIsPublic() ? "No" : "Yes") . ' onClick="location=\'' . $this->router->getChangePublicStatusURL() . '\'">';
      $profileFeedBar .= '  </div>';
      $profileFeedBar .= '</div>';

      $profileFeed = '<div id="profile-feed-container">';

      foreach($images as $image => $value) {
        $profileFeed .= '<div class="profile-feed-image-container">';
        $profileFeed .= ' <a class="profile-feed-image-touchable" href="' . $this->router->getImageDetailsURL($value['id']) . '">';
        $profileFeed .= '   <img class="profile-feed-image" src="' . $value['link'] . '" alt="' . $value['alt'] . '" />';
        $profileFeed .= ' </a>';
        $profileFeed .= ' <div class="profile-feed-image-like-container">';
        $profileFeed .= '   <img class="profile-feed-image-like-icon" src="drawable/icons/favorite/baseline_favorite_white_36dp.png" alt="Like Icon">';
        $profileFeed .= '   <p class="profile-feed-image-like-text">' . $value['likes'] . '</p>';
        $profileFeed .= ' </div>';
        $profileFeed .= ' </div>';
      }

      $profileFeed .= '</div>';
    } else if (key_exists('user', $_SESSION)) { // Logged
      $profileImg = '<img src="' . $profileLink . '" alt="This is the user image" />';
      $profileFeed = '<div id="profile-feed-container">';

      foreach($images as $image => $value) {
        $profileFeed .= '<div class="profile-feed-image-container">';
        $profileFeed .= ' <a class="profile-feed-image-touchable" href="' . $this->router->getImageDetailsURL($value['id']) . '">';
        $profileFeed .= '   <img class="profile-feed-image" src="' . $value['link'] . '" alt="' . $value['alt'] . '" />';
        $profileFeed .= ' </a>';
        $profileFeed .= ' <div class="profile-feed-image-like-container">';
        $profileFeed .= '   <img class="profile-feed-image-like-icon" src="drawable/icons/favorite/baseline_favorite_white_36dp.png" alt="Like Icon">';
        $profileFeed .= '   <p class="profile-feed-image-like-text">' . $value['likes'] . '</p>';
        $profileFeed .= ' </div>';
        $profileFeed .= ' </div>';
      }

      $profileFeed .= '</div>';
    } else if($isPublic === 1) { // Unlogged and Public
      $profileImg = '<img src="' . $profileLink . '" alt="This is the user image" />';
      $profileFeed = '<div id="profile-feed-container">';

      foreach($images as $image => $value) {
        $profileFeed .= '<div class="profile-feed-image-container">';
        $profileFeed .= ' <div class="profile-feed-image-touchable">';
        $profileFeed .= '   <img class="profile-feed-image" src="' . $value['link'] . '" alt="' . $value['alt'] . '" />';
        $profileFeed .= ' </div>';
        $profileFeed .= ' <div class="profile-feed-image-like-container">';
        $profileFeed .= '   <img class="profile-feed-image-like-icon" src="drawable/icons/favorite/baseline_favorite_white_36dp.png" alt="Like Icon">';
        $profileFeed .= '   <p class="profile-feed-image-like-text">' . $value['likes'] . '</p>';
        $profileFeed .= ' </div>';
        $profileFeed .= ' </div>';
      }

      $profileFeed .= '</div>';
    } else { // Unlogged and non public
      $profileImg = '<img src="' . $profileLink . '" alt="This is the user image" />';
    }

    $this->content = $profileImg;
    $this->content .= $profileFeedBar;
    $this->content .= $profileFeed;
  }

  public function getContent() {
    return $this->content;
  }
}
 ?>
