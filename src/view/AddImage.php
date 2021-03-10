<?php

class AddImage {
  private $router;
  private $content;

  public function __construct($router) {
    $this->router = $router;
  }

  public function makeAddImagePage() {
    $addImageForm = '
      <div id="logsign-form-container">
        <form id="logsign-form" enctype="multipart/form-data" action="' . $this->router->getAddImagePageURL() . '" method="POST">
          <div class="logsign-input-field-wrapper">
            <label for="title" class="logsign-input-text">Title</label>
            <input type="text" name="title" class="logsign-input-field" placeholder="Title" />
          </div>

          <div class="logsign-input-field-wrapper">
            <label for="alt" class="logsign-input-text">Description</label>
            <input type="text" name="alt" class="logsign-input-field" placeholder="" />
          </div>

          <div class="logsign-input-field-wrapper">
            <label for="image" class="logsign-input-text">Image</label>
            <input type="file" name="image" class="logsign-input-field up" />
          </div>

          <div class="logsign-button">
            <input type="submit" value="Add" />
          </div>
        </fom>
      </div>
    ';

    $this->content = $addImageForm;
  }

  public function getContent() {
    return $this->content;
  }
}
