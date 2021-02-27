<!doctype html>

<html lang="ru">

  <head>

    <?php
      // Подключаем модуль настроек сайта
      require "./includes/config.php";
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
            if(isset($_SESSION['logged_user']))
              {
                // Получаем login профиля
                $uName = '"'.$_GET['uname'].'"';
                // Подключаемся к БД, чтобы запросить данные о пользователе с искомым login
                $userOutput = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = ". $uName);
                // Если пользователя с таким login не существует, то выводим ошибку
                if (mysqli_num_rows($userOutput) <= 0)
                  {
                    // Т.к. пользователя с таким login не существует, то выводим сообщение об ошибке
                    echo '<div class="alert alert-danger" role="alert"><h3 style="margin-top: 0.25em;">
                    Ошибка: пользователь с таким именем не существует!</h3><p style="font-size: 1.2em;">Пожалуйста, попробуйте ввести другое имя!
                    </p></div>';
          ?>

          <form action="" method="post">
            <label for="searchUser_input">Поиск пользователя:</label>
            <div class="search">
              <input type="text" class="form-control" id="searchUser_input" name="searchUser_input" placeholder="Логин">
              <button type="submit" class="defaultButton" name="do_search">Поиск</button>
            </div>
          </form>

          <?php
                } else
                  {
                    // Получаем данные о пользователе
                    $userOutputResult = mysqli_fetch_assoc($userOutput);
                    // Удаляем хэш пароля полььзователя
                    $userOutputResult['password'] = '';
            ?>

          <h1 class="text-center sectionHeader userLogin">Личный кабинет</h1>

          <div class="row">

            <div class="col-md-5 col-lg-4 col-sm-12">

              <div class="card col-lg-12 col-sm-12 profileInfoBlock">

                <div class="profileAvatar">
                  <img src="./img/avatars/<?php echo $userOutputResult['avatar']; ?>" class="card-img-top" alt="...">
                </div>

                <div class="card-body">

                  <h3 class="text-center card-title">Профиль</h3>

                  <div class="card-text">

                    <div class="progress">

                      <?php
                        // Получаем данные об уровне пользователя
                        $userLevelAmount = $userOutputResult['level'];
                        // Вычисляем опыт необходимый для перехода на следеющий уровень
                        $userXpLevel = round(pow((10 * $userLevelAmount) , 1.7));
                      ?>
                      <div class="profileUserExperienceProgress"><?php echo $userOutputResult['xp'].' / '.$userXpLevel.' xp'; ?></div>
                      <div class="progress-bar" role="progressbar" style="width: <?php echo round( ($userOutputResult['xp'] / $userXpLevel) * 100 ).'%;' ?>"aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>

                    </div>

                    <p>Логин: <?php echo $userOutputResult['login']; ?></p>

                    <?php
                      // Если просматриваемый пользователь разрешил просмотр своего email, то показываем
                      if ($userOutputResult['c_email'] == 1 ) {
                    ?>
                    <p>Email: <?php echo $userOutputResult['email']; ?></p>
                    <?php
                      } else
                        {
                          // Т.к. пользователь запретил просмотр своег email, то удаляем его и выводим надпись "Скрыто"
                          $userOutputResult['email'] = '';
                    ?>
                    <p>Email: Скрыто</p>
                    <?php } ?>

                    <p>
                      Звание:
                      <?php
                        // Выводим специальный стиль для админа
                        if ($userOutputResult['admin'] >= 1)
                          {
                            echo  '<span class="badge adminBadge userBadge">'.$userOutputResult['rank'].'</span>';
                          } else
                            {
                              echo  '<span class="badge badge-info userBadge">'.$userOutputResult['rank'].'</span>';
                            }
                      ?>

                    </p>

                    <p>Уровень: <?php echo $userOutputResult['level'].' lvl'; ?></p>
                    <p>Опыт: <?php echo $userOutputResult['xp'].' xp'; ?></p>
                    <hr>
                    <p style="text-align:center;">Скорость чтения</p>
                    <p>Лучшая: <?php echo $userOutputResult['best_speed'].' сл./мин.'; ?></p>
                    <p>Текущая: <?php echo $userOutputResult['last_speed'].' сл./мин.'; ?></p>
                    <hr>
                    <p>Дата регистрации: <?php echo $userOutputResult['reg_date']; ?></p>

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

                      <?php
                        // Если просматриваемый пользователь разрешил просмотр блока "О себе", то показываем
                        if ($userOutputResult['c_about_me'] == 1 )
                          {
                            echo $userOutputResult['about_me'];
                          } else
                            {
                              // Т.к. пользователь запретил просмотр блока "О себе", то удаляем его и выводим надпись "Скрыто"
                              $userOutputResult['about_me'] = '';
                              echo 'Скрыто';
                            }
                      ?>

                    </p>

                </div>
              </div>

                <?php
                  // Если просматриваемый пользователь разрешил просмотр своей статистики, то собираем данные
                  if ($userOutputResult['c_stat'] == 1)
                    {
                      // Подключаем модуль получения информации для построения графиков в профиле просматриваемого пользователя
                      require './includes/uProfileChartGetInformation.php';
                    }
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
                      <?php
                        // Если просматриваемый пользователь разрешил просмотр своей статистики, то показываем
                        if ($userOutputResult['c_stat'] == 1) {
                      ?>

                      <p>
                        На графике показано изменение скорости вашего чтения за последний месяц (в качестве дневного значения берётся средняя скорость чтения за день).
                        По горизонтали указана дата, по вертикали — скорость чтения (сл./мин.).
                      </p>

                        <input type="hidden" id="monthlySpeedValue" value="<?php echo $monthlySpeedValue; ?>">
                        <input type="hidden" id="monthlySpeedDate" value="<?php echo $monthlySpeedDate; ?>">

                        <canvas id="userSpeedChart" height="200"></canvas>
                        <script src="/js/charts/userSpeedChart.js"></script>

                      <?php
                        } else
                          {
                            // Т.к. пользователь запретил просмотр статистики, то выводим надпись "Скрыто"
                      ?>
                      <p>Скрыто</p>
                      <?php } ?>

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
                      <?php
                        // Если просматриваемый пользователь разрешил просмотр своей статистики, то показываем
                        if ($userOutputResult['c_stat'] == 1) {
                      ?>

                      <p>
                        На графике показано сколько раз Вы выполняли каждое упражнение за всё время, проведенное на сайте с момента регистрации.
                        По горизонтали указано количество выполненых упражнений, по вертикали — название упражнения.
                      </p>

                      <input type="hidden" id="exNames" value="<?php echo $exNames; ?>">
                      <input type="hidden" id="exStat" value="<?php echo $exStat; ?>">

                      <canvas id="userStatChart" height="200"></canvas>
                      <script src="/js/charts/userStatChart.js"></script>

                      <?php
                        } else
                          {
                            // Т.к. пользователь запретил просмотр статистики, то выводим надпись "Скрыто"
                      ?>

                      <p>Скрыто</p>

                      <?php } ?>

                    </div>
                  </div>
                </div>


              </div>

            </div>

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
      require "./includes/footer.php";
     ?>

     <script type="text/javascript" src="js/bootstrap.min.js"></script>

  </body>

</html>
