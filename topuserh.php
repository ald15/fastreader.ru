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
          // Если пользователь авторизован, то показывать ему профиль
          if(isset($_SESSION['logged_user'])) {
        ?>

        <h1 class="text-center sectionHeader userLogin" id="hTop">Топ 100 пользователей по скорости чтения</h1>

        <div class="alert alert-secondary" role="alert">

        <p>
          В таблице отображается топ 100 пользователей сайта по скорости чтения
           за всё время (сортировка производится по лучшей скорости чтения),
           столбец скорость показывает следующую информация: [лучшая скорость] / [текущая скорость] сл.мин.
        </p>

          </div>

        <div id="topDescriptionLine">

          <div class="topNum">#</div>
          <div class="topLogin">Логин</div>
          <div class="topRank">Звание</div>
          <div class="topLevel">Уровень</div>
          <div class="topSpeed">Скорость чтения</div>

        </div>

        <?php
          // Подключаемся к БД, чтобы запросить все упражнения, сортируя их по количеству просмотров
          $userOutput = mysqli_query($connection, "SELECT * FROM `users` ORDER BY `best_speed` DESC");
          // Получаем данные об упражнениях, пока они существуют в нашем запросе
          for ($i=1; $i < 101 ; $i++)
            {
              $userOutputResult = mysqli_fetch_assoc($userOutput);
              // Если больше пользователей нет в базе данных, то перестаем выводить
              if ($userOutputResult == false) {
                break;
            }
          if ($_SESSION['logged_user']['login'] == $userOutputResult['login']) {
         ?>

          <div class="topLine" style="background-color: #e04a00;">
          <?php } else { ?>
          <div class="topLine">
          <?php } ?>

            <div class="topNum">
              <?php
                if ($i == 1)
                  {
                    echo '<span class="topIcon" style="background-color:#eab300">1</span>';
                  } elseif ($i == 2)
                    {
                      echo '<span class="topIcon" style="background-color:#a9a9a9">2</span>';
                    } elseif ($i == 3)
                      {
                        echo '<span class="topIcon" style="background-color:#ab6a2d">3</span>';
                      } else
                        {
                          echo $i;
                        }
              ?>
            </div>

            <div class="topLogin">
              <?php echo '<a href="/uprofile.php?uname='.$userOutputResult['login'].'">'.$userOutputResult['login'].'</a>'; ?>
            </div>

            <div class="topRank">
              <?php
                // Выводим специальный стиль для админа
                if ($userOutputResult['admin'] >= 1)
                  {
                    echo  '<span class="badge adminBadge userBadge">'.$userOutputResult['rank'].'</span>';
                  } else
                    {
                      echo '<span class="badge badge-info userBadge">'.$userOutputResult['rank'].'</span>';
                    }
              ?>
            </div>

            <div class="topLevel">
              <?php echo $userOutputResult['level'] ?>
            </div>

            <div class="topSpeed">
                <?php echo $userOutputResult['best_speed'].' / '.$userOutputResult['last_speed']; ?>
            </div>

          </div>
          <?php
            }
          ?>

          <div id="lastTopLine"></div>

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
