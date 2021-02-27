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
          // Если пользователь авторизован, то показывать ему все упражнения
          if(isset($_SESSION['logged_user'])) {
          ?>

          <h1 class="text-center">Упражнения</h1>

          <div class="row">

            <?php
              // Подключаемся к БД, чтобы запросить все упражнения, сортируя их по количеству просмотров
              $exercisesOutput = mysqli_query($connection, "SELECT * FROM `exercises` ORDER BY `views` DESC");
              // Получаем данные об упражнениях, пока они существуют в нашем запросе
              while (($exercisesOutputResult = mysqli_fetch_assoc($exercisesOutput))) {
             ?>

            <div class="col-md-4 col-lg-4 col-sm-12">
              <div class="card">

                <div class="card-img">

                  <a href="/exercise.php?id=<?php echo $exercisesOutputResult['id']; ?>" class="card-link">

                    <img src="/img/exercises/<?php echo $exercisesOutputResult['image']; ?>" class="img-fluid">

                  </a>

                </div>

                <div class="card-body">

                  <a href="/exercise.php?id=<?php echo $exercisesOutputResult['id']; ?>" class="card-link">

                    <h4 class="card-title"><?php echo $exercisesOutputResult['title']; ?></h4>

                  </a>

                  <p class="card-text"><?php echo $exercisesOutputResult['s_description'].'...'; ?></p>

                </div>

                <div class="card-footer">

                  <a href="/exercise.php?id=<?php echo $exercisesOutputResult['id']; ?>" class="card-link">Подробнее</a>

                </div>

              </div>
            </div>

            <?php
              }
             ?>

        </div>

        <?php
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
