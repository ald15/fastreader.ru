<!doctype html>

<html lang="ru">

  <head>

    <?php
      // Подключаем модуль настроек сайта
      require "./includes/config.php";
    ?>

    <title><?php echo $config['SITE_TITLE']; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $config['SITE_DESCRIPTION']; ?>">
    <meta name="keywords" content="<?php echo $config['SITE_KEYWORDS']; ?>">


    <link rel="icon" type="image/x-icon" href="<?php echo $config['SITE_FAVICON']; ?>">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="css/main.css">

  </head>


  <body>

    <div id="wrapper">

    <?php
      // Подключаем модуль меню
      require "./includes/menu.php";
      // Подключаем модуль авторизации
      require "./includes/login.php";
      // Подключаем модуль шапка сайта
      require "./includes/header.php";
      // Подключаем модуль о сайте
      require "./includes/about.php";
      // Подключаем модуль упражнений
      require "./includes/exercises.php";
      // Подключаем модуль регистрации
      require "./includes/signup.php";
     ?>

   </div>

   <?php
      // Подключаем модуль подвала сайта
      require "./includes/footer.php";
    ?>

    <?php
      if (empty($infoMsgTextLoginResult)){
     ?>
      <script type="text/javascript" defer src="js/jquery-3.4.1.min.js"></script>
      <script type="text/javascript" defer src="js/bootstrap.min.js"></script>
   <?php } ?>

  </body>

</html>
