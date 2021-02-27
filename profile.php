<!doctype html>

<html lang="ru">

  <head>

    <?php
      // Подключаем модуль настроек сайта
      require "./includes/config.php";
      // Подключаем модуль настроек аватарки
      require "./includes/settingsUserAvatar.php";
      // Подключаем модуль настроек
      require "./includes/settings.php";
      // Модуль поиска пользователя
      require "./includes/userSearch.php";
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
    <script src="js/Chart.js"></script>

  </head>


  <body>
    <div id="wrapper">

      <?php
        // Подключаем модуль меню
        require "./includes/menu.php";
        // Подключаем модуль авторизации
        require "./includes/login.php";
      ?>


      <div class="defaultBlock">
        <div class="container">

          <?php
            // Если пользователь авторизован, то показывать ему профиль
            if(isset($_SESSION['logged_user'])) {
          ?>

          <h1 class="text-center sectionHeader userLogin">Личный кабинет</h1>

          <div class="row">

            <div class="col-md-5 col-lg-4 col-sm-12">

              <div class="card col-lg-12 col-sm-12 profileInfoBlock">

                <div class="profileAvatar">
                  <img src="./img/avatars/<?php echo $_SESSION['logged_user']['avatar']; ?>" class="card-img-top" alt="...">
                </div>

                <div class="card-body">

                  <h3 class="text-center card-title">Профиль</h3>

                  <div class="card-text">

                    <div class="progress">

                      <?php
                        // Получаем данные об уровне пользователя
                        $userLevelAmount = $_SESSION['logged_user']['level'];
                        // Вычисляем опыт необходимый для перехода на следеющий уровень
                        $userXpLevel = round(pow((10 * $userLevelAmount) , 1.7));
                        ?>
                      <div class="profileUserExperienceProgress"><?php echo $_SESSION['logged_user']['xp'].' / '.$userXpLevel.' xp'; ?></div>
                      <div class="progress-bar" role="progressbar" style="width: <?php echo round( ($_SESSION['logged_user']['xp'] / $userXpLevel) * 100 ).'%;' ?>"aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>

                    </div>

                    <p>Логин: <?php echo $_SESSION['logged_user']['login']; ?></p>
                    <p>Email: <?php echo $_SESSION['logged_user']['email']; ?></p>
                    <p>
                      Звание:
                      <?php
                      // Выводим специальный стиль для админа
                      if ($_SESSION['logged_user']['admin'] >= 1)
                        {
                          echo  '<span class="badge adminBadge userBadge">'.$_SESSION['logged_user']['rank'].'</span>';
                        } else
                          {
                            echo  '<span class="badge badge-info userBadge">'.$_SESSION['logged_user']['rank'].'</span>';
                          }
                      ?>

                    </p>

                    <p>Уровень: <?php echo $_SESSION['logged_user']['level'].' lvl'; ?></p>
                    <p>Опыт: <?php echo $_SESSION['logged_user']['xp'].' xp'; ?></p>
                    <hr>
                    <p style="text-align:center;">Скорость чтения</p>
                    <p>Лучшая: <?php echo $_SESSION['logged_user']['best_speed'].' сл./мин.'; ?></p>
                    <p>Текущая: <?php echo $_SESSION['logged_user']['last_speed'].' сл./мин.'; ?></p>
                    <hr>
                    <p>Дата регистрации: <?php echo $_SESSION['logged_user']['reg_date']; ?></p>

                  </div>

                </div>

              </div>

            </div>


            <div class="col-md-7 col-lg-8 col-sm-12 d-flex justify-content-center">
              <div class=" col-lg-12" style="padding: 0;">
                <div class="card profileUserAboutMe">
                  <div class="card-body">

                    <h3 class="text-center card-title">О себе</h3>

                    <hr>

                    <p class="card-text">

                      <?php echo $_SESSION['logged_user']['about_me']; ?>

                    </p>

                </div>
              </div>


                <?php
                  // Подключаем модуль получения информации для построения графиков в профиле пользователя
                  require './includes/profileChartGetInformation.php';
                ?>


              <div class="accordion" id="accordionProfileSettings">
                <div class="card">

                  <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                      <button class="btn btn-link defaultLink" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Статистика скорости чтения
                      </button>
                    </h5>
                  </div>

                  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionProfileSettings">
                    <div class="card-body">

                      <p>
                        На графике показано изменение скорости вашего чтения за последний месяц (в качестве дневного значения берётся средняя скорость чтения за день).
                        По горизонтали указана дата, по вертикали — скорость чтения (сл./мин.).
                      </p>

                        <input type="hidden" id="monthlySpeedValue" value="<?php echo $monthlySpeedValue; ?>">
                        <input type="hidden" id="monthlySpeedDate" value="<?php echo $monthlySpeedDate; ?>">

                        <canvas id="userSpeedChart" height="200"></canvas>
                        <script src="/js/charts/userSpeedChart.js"></script>

                    </div>
                  </div>
                </div>

                <div class="card">
                  <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed defaultLink" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Статистика по упражнениям
                      </button>
                    </h5>
                  </div>

                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionProfileSettings">
                    <div class="card-body">

                      <p>
                        На графике показано сколько раз Вы выполняли каждое упражнение за всё время, проведенное на сайте с момента регистрации.
                        По горизонтали указано количество выполненых упражнений, по вертикали — название упражнения.
                      </p>

                      <input type="hidden" id="exNames" value="<?php echo $exNames; ?>">
                      <input type="hidden" id="exStat" value="<?php echo $exStat; ?>">

                      <canvas id="userStatChart" height="200"></canvas>
                      <script src="/js/charts/userStatChart.js"></script>

                    </div>
                  </div>
                </div>

                <div class="card">
                  <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed defaultLink" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Дополнительное меню
                      </button>
                    </h5>
                  </div>

                  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionProfileSettings">
                    <div class="card-body">
                      <form action="" method="post">
                        <label for="searchUser_input">Поиск пользователя:</label>
                        <div class="search">
                        <input type="text" class="form-control" id="searchUser_input" name="searchUser_input" placeholder="Логин">
                        <button type="submit" class="defaultButton" name="do_search">Поиск</button>
                      </div>
                      </form>
                      <hr>
                      <p>Другие ссылки:</p>
                      <p><a class="defaultLink" href="/topuserh.php">Топ 100 пользователей по скорости чтения</a></p>
                      <p><a class="defaultLink" href="/<?php echo $config['USER_AGREEMENT'] ?>">Пользовательское соглашение</a></p>
                      <p><a class="defaultLink" href="/<?php echo $config['PRIVACY_POLICY'] ?>">Политика конфиденциальности</a></p>
                      <p><a class="defaultLink" href="#">ЧАВО (F.A.Q.)</a></p>

                    </div>
                  </div>
                </div>

                <div class="card">
                  <div class="card-header" id="headingFour">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed defaultLink" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Настройка картинки профиля
                      </button>
                    </h5>
                  </div>

                  <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionProfileSettings">
                    <div class="card-body">

                      <?php
                        // Подключаем блок настроек аватврки
                        require './includes/settingsUserAvatarBlock.php';
                      ?>

                    </div>
                  </div>
                </div>

                <div class="card">
                  <div class="card-header" id="headingFive">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed defaultLink" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        Настройки
                      </button>
                    </h5>
                  </div>

                  <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionProfileSettings">
                    <div class="card-body">

                      <?php
                        // Подключаем блок настроек профиля
                        require './includes/settingsBlock.php';
                        echo "    ";
                        echo date('h:i:s');
                        echo ' ';
                        echo date('dmY');
                        echo ' ';
                        echo ' '.date('d.m');
                      ?>

                    </div>
                  </div>
                </div>


              </div>

            </div>

        </div>



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
      require "./includes/footer.php";
     ?>

     <script type="text/javascript" src="js/bootstrap.min.js"></script>

  </body>

</html>
