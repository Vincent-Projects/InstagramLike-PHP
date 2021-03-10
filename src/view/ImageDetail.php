<?php

class ImageDetail {
  private $router;
  private $imgD;

  public function __construct($router) {
    $this->router = $router;
  }

  public function makeImageDetailPage($image, $comList=0) {
    $button = "";
    if(key_exists('user', $_SESSION)) {
      if($_SESSION['user']->getId() === $image['user_id']) {
        $button = '<input id="" type="button" value="Delete" onClick="location=\'' . $this->router->getDeleteImageURL($image) . '\'" />';
      }
    }
    $content = '<div>';

    $this->imgD = '<img src="' . $image['link'] . '" alt="' . $image['alt'] . '" />';

    $commentPart = '<div>';

    foreach($comList as $number => $com) {
      $commentPart .= '<div>';
      $commentPart .= ' <p>' . $com['uname'] .'</p>';
      $commentPart .= ' <p>' . $com['text'] . '</p>';
      $commentPart .= '</div>';
    }

    $commentPart .= '<form method="POST" action="' . $this->router->getCommentSendingURL($image['id']) . '">';
    $commentPart .= '   <input name="comment" type="text" placeholder="Your comment..."/>';
    $commentPart .= '   <input type="submit" value="send"/>';
    $commentPart .= '</form>';

    $commentPart .= '</div>';

    $content .= $button . $this->imgD . '' . $commentPart . '</div>';
    return $content;
  }
}


 ?>
