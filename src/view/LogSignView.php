<?php

class LogSignView {
  private $router;
  private $content;

  public function __construct($router) {
    $this->router = $router;
  }

  public function makeLoginForm() {
    $text = "";
    $this->content = '
      <div id="logsign-form-container">
        <form id="logsign-form" action="' . $this->router->getLoginVerificationPageURL() . '" method="POST">
          <div class="logsign-input-field-wrapper">
            <label for="email" class="logsign-input-text">Email</label>
            <input type="text" name="email" class="logsign-input-field" placeholder="exemple@email.com" value="' . $text . '"/>
          </div>

          <div class="logsign-input-field-wrapper">
            <label for="pass" class="logsign-input-text">Password</label>
            <input type="password" name="pass" class="logsign-input-field" />
          </div>

          <div class="logsign-button">
            <input type="submit" value="Log in" />
          </div>
        </fom>
      </div>
    ';
  }

  public function makeSignInForm($errors) {
    $username = !$errors ? "" : $errors['signin_err_info']['username'];
    
    $this->content = '
      <div id="logsign-form-container">
        <form id="logsign-form" action="' . $this->router->getSignInVerificationPageURL() . '" method="POST">
          <div class="logsign-input-field-wrapper">
            <label for="username" class="logsign-input-text">Username</label>
            <input type="text" name="username" class="logsign-input-field" placeholder="ex : username" value='. $username . '/>
          </div>

          <div class="logsign-input-field-wrapper">
            <label for="email" class="logsign-input-text">Email</label>
            <input type="text" name="email" class="logsign-input-field" placeholder="exemple@email.com" />
          </div>

          <div class="logsign-input-field-wrapper">
            <label for="pass" class="logsign-input-text">Password</label>
            <input type="password" name="pass" class="logsign-input-field" />
          </div>

          <div class="logsign-input-field-wrapper">
            <label for="confirm" class="logsign-input-text">Confirm password</label>
            <input type="password" name="confirm" class="logsign-input-field" />
          </div>

          <div class="logsign-button">
            <input type="submit" value="Sign in" />
          </div>
        </fom>
      </div>
    ';
  }

  public function getContent() {
    return $this->content;
  }
}




 ?>
