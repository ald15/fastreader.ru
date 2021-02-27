<!doctype html>

<html lang="ru">

  <head>

    <?php
      // Подключаем модуль настроек сайта
      require "./includes/config.php";
    ?>

    <title><?php echo $config['SITE_TITLE'] ?></title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $config['SITE_DESCRIPTION'] ?>">
    <meta name="keywords" content="<?php echo $config['SITE_KEYWORDS'] ?>">


    <link rel="icon" type="image/png" href="<?php echo $config['SITE_FAVICON'] ?>">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script type="text/javascript" src="js/main.js"></script>

  </head>

  <body>
    <div id="wrapper">

    <?php
      // Подключаем модуль меню
      require "./includes/menu.php";
      // Подключаем модуль авторизации
      require "./includes/login.php";
    ?>

    <div class="exercises" id="exercises">
      <div class="container">

        <h1 class="text-center">Восстановление пароля</h1>

        <div class="row">

          <p>В разработке</p>

        </div>

        </div>
      </div>
    </div>

    <?php
    // Подключаем модуль подвала сайта
    require "./includes/footer.php"
    ?>

    <script type="text/javascript" src="js/bootstrap.min.js"></script>

  </body>
</html>
