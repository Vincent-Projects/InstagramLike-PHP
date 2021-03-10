<?php

set_include_path("src");

require_once("Router.php");
require_once("view/MainView.php");
require_once("control/Controller.php");
require_once('model/user/UserStorageMySQL.php');
require_once('model/image/ImageStorageMySQL.php');
require_once('model/likes/LikesStorageMySQL.php');
require_once('model/comment/CommentStorageMySQL.php');
require_once('model/profile/ProfileStorageMySQL.php');

$router = new Router();
$router->main(new UserStorageMySQL(), new ImageStorageMySQL(), new LikesStorageMySQL(), new CommentStorageMySQL(), new ProfileStorageMySQL());

 ?>
