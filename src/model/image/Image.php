<?php

class Image {
  private $link;
  private $likes;
  private $alt;
  private $commentList;
  private $nbrComment;
  private $title;

  public function __construct($link, $alt, $title, $likes=0, $comlist=null, $nbrComment=0) {
    $this->link = $link;
    $this->likes = $likes;
    $this->alt = $alt;
    $this->title = $title;
    $this->commentList = $comlist;
    $this->nbrComment = $nbrComment;
  }

  public function getLink() {
    return $this->link;
  }

  public function getLikes() {
    return $this->likes;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getAlt() {
    return $this->alt;
  }

  public function getCommentList() {
    return $this->commentList;
  }

  public function getNumberComment() {
    return $this->nbrComment;
  }
}

 ?>
