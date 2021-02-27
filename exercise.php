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

        <?php
          // Если пользователь авторизован, то показывать ему упражнение
          if(isset($_SESSION['logged_user']))
            {
              // Получаем Id упражнения
              $exerciseId = $_GET['id'];

              // Подключаем модуль подсчитывания просмотров
              require "./includes/viewsCounter.php";

              // Подключаемся к БД, чтобы запросить все упражнения, сортируя их по количеству просмотров
              $exerciseOutput = mysqli_query($connection, "SELECT * FROM `exercises` WHERE `id` = ". (int) $exerciseId);
              // Если запрашиваемого упражнения не существует, то выводим ошибку
              if (mysqli_num_rows($exerciseOutput) <= 0)
              {
                // Т.к. упражнение не найдено, то выводим сообщение об ошибке
                echo '<div class="alert alert-danger" role="alert"><h3 style="margin-top: 0.25em;">
                Ошибка: запрашиваемое упражнение не было найдено!</h3><p style="font-size: 1.2em;">Пожалуйста, выберите существующее упражнение!
                </p></div>';

              } else
                {
                  // Получаем данные об упражнении
                  $exerciseOutputResult = mysqli_fetch_assoc($exerciseOutput);
        ?>

        <h1 class="text-center"><?php echo $exerciseOutputResult['title']; ?></h1>

        <div class="row">

          <div class="accordion" id="accordionExample">
            <div class="card">
              <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" id="headingOne">
                <h5 class="mb-0">

                  <button class="btn btn-link collapsed defaultLink" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Описание
                  </button>

                </h5>
              </div>

              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">

                  <?php
                    // Выводим описание упражнения из БД
                   echo '<p>'.$exerciseOutputResult['description'].'</p>';
                   ?>

                </div>

              </div>
            </div>
          </div>

          <div id="e_area">

            <?php
              // Подключаем php движок упражнения  и ниже подключаем js движок и стили, если ссылка на них есть в БД
              if (($exerciseOutputResult['php_engine'])) {
                require "./exercises/".$exerciseOutputResult['php_engine'];
            ?>

            <link rel="stylesheet" type="text/css" href="./exercises/css/<?php echo $exerciseOutputResult['style_file']; ?>">

            <script type="text/javascript" src="./exercises/js/<?php echo $exerciseOutputResult['js_engine']; ?>"></script>
          <?php
            }
          ?>
          </div>

        </div>

        <?php
            }
          } else
            {
              // Т.к. пользователь не авторизован, то выводим сообщение об ошибке
              echo '<div class="alert alert-danger" role="alert"><h3 style="margin-top: 0.25em;">
              Ошибка: не была произведена авторизация на сайте!</h3><p style="font-size: 1.2em;">Пожалуйста, войдите в свой аккаунт или зарегистрируйтесь!
              </p></div>';
            }
        ?>

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
