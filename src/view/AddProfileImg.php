<?php

class AddProfileImg {
  private $router;

  public function __construct($router) {
    $this->router = $router;
  }

  public function addProfileImage() {
    $form = '<div id="logsign-form-container">';
    $form .= '  <form id="logsign-form" enctype="multipart/form-data" action="' . $this->router->getAddedProfileImageURL() . '" method="POST">';
    $form .= '    <div class="logsign-input-field-wrapper">';
    $form .= '      <label for="image" class="logsign-input-text">Image</label>';
    $form .= '      <input type="file" name="image" class="logsign-input-field up" />';
    $form .= '    </div>';
    $form .= '    <div class="logsign-button">';
    $form .= '      <input type="submit" value="Add" />';
    $form .= '    </div>';
    $form .= '  </form>';
    $form .= '</div>';

    return $form;
  }
}

?>
