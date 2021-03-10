<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title> <?php echo $this->getTitle(); ?> </title>
    <link rel="stylesheet" type="text/css" href="index.css" />
    <link rel="stylesheet" type="text/css" href="styles/header.css" />
    <link rel="stylesheet" type="text/css" href="styles/home.css" />
    <link rel="stylesheet" type="text/css" href="styles/logsign.css" />
    <link rel="stylesheet" type="text/css" href="styles/profile.css" />
  </head>

  <body>
    <header>
      <?php echo $this->getHeader(); ?>
    </header>

    <div id="manager-container" class="straight body">
      <?php echo $this->getContent(); ?>
    </div>

    <div id="feed-container" class="straight">
    </div>

  	<?php echo $this->getImagesHomeContainer(); ?>
  </body>
</html>
