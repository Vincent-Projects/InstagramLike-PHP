<?php

class Home {
  private $router;
  private $content;

  public function __construct($router) {
    $this->router = $router;
  }

  public function makeHomePage($images, $isLogged) {
    $post = '<div id="feed-images-container">';
    $likeIcon = "";

    foreach ($images as $key => $image) {
      $imgSRC = $image['link'];
      $imgALT = $image['alt'];
      $ownerName = $image['owner'];
      $imgTitle = $image['title'];

      if($image['isLiked']) {
        $likeIcon = "drawable/icons/favorite/baseline_favorite_black_36dp.png";
      } else {
        $likeIcon = "drawable/icons/favorite/baseline_favorite_border_black_36dp.png";
      }

      $post .= '<div class="feed-post-container">';

      $post .= '  <div class="feed-post-head">';
      $post .= '    <a class="feed-post-head-owner-name" href="' . $this->router->getProfilePageURL($image['user_id']) . '">@' . $ownerName . '</a>';
      $post .= '    <p class="feed-post-head-title">' . $imgTitle . '</p>';
      $post .= '  </div>';

      if($isLogged) {
        $post .= '  <a class="feed-image-container" href="' . $this->router->getImageDetailsURL($image['id']) . '">';
        $post .= '    <img class="feed-image" src="' . $imgSRC . '" alt="' . $imgALT . '" />';
        $post .= '  </a>';

        $post .= '  <div class="feed-post-bar-container">';

        $post .= '    <div class="feed-post-like-container">';
        $post .= '      <a href="' . $this->router->getLikeFromHomeURL($image['id']) . '">';
        $post .= '        <img class="feed-post-like-img" src="' . $likeIcon . '" alt="Like icon" />';
        $post .= '      </a>';
        $post .= '      <p class="feed-bar-number">' . $image['likes']. '</p>';
        $post .= '    </div>';
      } else {
        $post .= '<div class="feed-image-container">';
        $post .= '<img class="feed-image" src="' . $imgSRC . '" alt="' . $imgALT . '" />';
        $post .= '</div>';

        $post .= '<div class="feed-bar-container">';

        $post .= '<div class="feed-bar-like-container">';
        $post .= '<div href="' . $this->router->getLikeFromHomeURL($image['id']) . '">';
        $post .= '<img class="feed-bar-icon" src="' . $likeIcon . '" alt="Like icon" />';
        $post .= '</div>';
        $post .= '<p class="feed-bar-number">' . $image['likes']. '</p>';
        $post .= '</div>';
      }

      $post .= '  <div class="feed-bar-comment-container">';
      $post .= '    <div>';
      $post .= '      <img class="feed-bar-icon" src="drawable/icons/chat/baseline_chat_black_36dp.png" alt="" />';
      $post .= '    </div>';
      $post .= '  </div>';

      $post .= '</div>';
      $post .= '</div>';
    }

    $this->content = $post;
  }

  public function getContent() {
    return $this->content;
  }
}


 ?>
