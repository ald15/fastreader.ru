<script type="text/javascript" src="./js/note.js"></script>
<link rel="stylesheet" type="text/css" href="./css/note.css">

<?php
  // Выше подключили js скрипт и css стили для всплывающих уведомлений


  // Модуль авторизации


  // Подключаем модуль выхода из аккаунта
  require "outlogin.php";

  // Получаем данные
  $data = $_POST;

  // Если пользователь не авторизован
  if(empty($_SESSION['logged_user'])) {

    // Выполняем, если в post запросе есть запрос на авторизацию
    if(isset($data['do_login']))
      {
        // Создаём массив для сохранения ошибок
        $errors = array();

        // Google reCaprtcha V3
        // Функция, делающая запрос на Google сервис
        function getCaptcha($SecretKey, $SK) {
            $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$SK."&response={$SecretKey}");
            $Return = json_decode($Response);
            return $Return;
        }

        // Делаем запрос к Google сервису
        $Return = getCaptcha($_POST['g-recaptcha-response-login'], $config['SECRET_KEY']);

        //Все успешно, если в результате запроса success == true и score > 0.5
        if($Return->success == true && $Return->score > 0.5)
          {
            $reCaprtchaResultLogin = true;
          } else
            {
              $reCaprtchaResultLogin = false;
            }


        // Временно запоминаем логин пользователя
        $login = $data['loginLogin'];

        // Временно запоминаем пароль пользователя
        $password = $data['passwordLogin'];

        // Подключаемся к БД, чтобы сделать проверку на существование логина
        $user = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$login'");
        // Получаем данные о существование логина в БД
        $user_result = mysqli_fetch_assoc($user);

        // Ошибки при пустых полях
        // Ошибка, если поле логина пусто
        if(trim($login) == '') {$errors[] = 'Ошибка: логин не был введен!';}
        // Ошибка, если поле логина пусто
        if($password == '') {$errors[] = 'Ошибка: пароль не был введен!';}

        // Другие ошибки
        // Ошибка, т.к. пользователь c таким логином не был найден в БД
        if(empty($user_result)){$errors[] = 'Ошибка: пользователь не найден!';}
        // Ошибка, т.к. пользователь ввел неверный пароль
        if(!password_verify($password, $user_result['password'])){$errors[] = 'Ошибка: введен невеный пароль!';}
        // Ошибка, если Google reCaprtcha V3 не пройдена
        if(!$reCaprtchaResultLogin) {$errors[] = 'Ошибка: Вы робот!';}



              // Защита от SQL-injections и ввода нестандартных данных: ОТСУТСТВУЕТ!!!!!!!!!!!!!!!!!!!



        // Авторизуем пользователя, если нет ошибок
        if(empty($errors))
          {
                // Создаем записи в сессии, что пользователь авторизовался
                $_SESSION['logged_user'] = $user_result;

                // Создаем записи в сессии, что пользователь авторизовался и вошел на сайт первый раз
                $_SESSION['logged_user']['first_visit'] = 0;
                // Создаем записи в сессии, что пользователь пока не просматривал упражнений
                for ($i=1; $i < $config['EXERCISES']['EXERCISES_AMOUNT'] + 1; $i++) {
                  $_SESSION['logged_user']['exercises_views'][$i] = 0;
                }
                // Обновляем страницу
                header('Location: /');
          } else
            {
              // Создаем текст сообщение об ошибке
              $infoMsgTextLogin = array_shift($errors);
              // Выводим сообщение об ошибке
              $infoMsgTextLoginResult = '<div class="alert alert-danger" role="alert" data-type="error" data-text="'.$infoMsgTextLogin.'">'.$infoMsgTextLogin.'</div>';
            }
      }

 ?>


       <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
           <div class="modal-content">
             <div class="modal-header">

               <h5 class="modal-title" id="staticBackdropLabel">Вход</h5>

               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
               </button>
             </div>

             <div class="modal-body">
               <p>
                 <?php
                    // Вывод, если существует, информационного сообщения для пользователя
                    echo @$infoMsgTextLoginResult;
                  ?>
              </p>
              <form action="/"  method="post">

                <div class="form-group">
                  <label for="login_login">Логин</label>
                  <input type="text" class="form-control" id="login_login" name="loginLogin" autocomplete="on" value="<?php echo @$data['login']; ?>">
                </div>

                <div class="form-group">
                  <label for="passwordLogin">Пароль</label>
                  <input type="password" id="passwordLogin" class="form-control" name="passwordLogin" autocomplete="on">
                </div>

                <div class="form-group">
                  <input type="hidden" id="g-recaptcha-response-login" name="g-recaptcha-response-login">
                </div>

                <p><a href="/passwordRecovery.php">Забыли пароль?</a></p>

              </div>

              <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary" id="login_btn" name="do_login">Войти</button>

            </form>
              </div>

           </div>
         </div>
       </div>

       <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $config['SITE_KEY']; ?>"></script>
       <script >
           grecaptcha.ready(function() {
               grecaptcha.execute('<?php echo $config['SITE_KEY']; ?>', {action: 'homepage'}).then(function(token) {
                 document.getElementById('g-recaptcha-response-login').value=token;
                 if (document.getElementById('g-recaptcha-response-registration')) {
                 document.getElementById('g-recaptcha-response-registration').value=token;
                }
               });
           });
       </script>

       <?php
        // Если ошибка авторизации то, подключаем сначала скрипты, чтобы вывести окно авторизаци снова
        if (isset($infoMsgTextLoginResult)) {
        ?>
          <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
          <script type="text/javascript" src="js/bootstrap.min.js"></script>
          <script>$('#staticBackdrop').modal('show');</script>
        <?php } ?>

     <?php } ?>
