<?php


// Модуль регистрации



  // Получаем данные
  $data = $_POST;

  // Выполняем, если в post запросе есть запрос на регистрацию
  if(isset($data['do_signup']))
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
      $Return = getCaptcha($_POST['g-recaptcha-response-registration'], $config['SECRET_KEY']);

      //Все успешно, если в результате запроса success == true и score > 0.5
      if($Return->success == true && $Return->score > 0.5)
        {
          $reCaprtchaResultRegistration = true;
        } else
          {
            $reCaprtchaResultRegistration = false;
          }


      // Подключаемся к БД, чтобы сделать проверку на уже существующий логин
      $loginExistsCheck = mysqli_query($connection, "SELECT COUNT(login) FROM `users` WHERE login = '".$data['login']."'");
      // Получаем данные о существование такого же логина в БД
      $loginExistsCheckResult = mysqli_fetch_assoc($loginExistsCheck);

      // Подключаемся к БД, чтобы сделать проверку на уже существующий email
      $emailExistsCheck = mysqli_query($connection, "SELECT COUNT(email) FROM `users` WHERE email = '".$data['email']."'");
      // Получаем данные о существование такого же email в БД
      $emailExistsCheckResult = mysqli_fetch_assoc($emailExistsCheck);

      //Созданине ошибок

      // Ошибки при пустых полях
      // Ошибка, если поле логина пусто
      if(trim($data['login']) == '') {$errors[] = 'Ошибка: логин не был введен!';}
      // Ошибка, если поле email пусто
      if(trim($data['email']) == '') {$errors[] = 'Ошибка: e-mail не был введен!';}
      // Ошибка, если поле пароль пусто
      if($data['password'] == '') {$errors[] = 'Ошибка: пароль не был введен!';}
      // Ошибка, если поле повторный пароль пусто
      if($data['password_repeat'] == '') {$errors[] = 'Ошибка: пароль не был введен ещё раз!';}

      // Другие ошибки
      // Ошибка, если пароли не совпадают
      if($data['password'] != $data['password_repeat']) {$errors[] = 'Ошибка: пароли не совпадают!';}
      // Ошибка, если пользователь с таким логином уже существует
      if($loginExistsCheckResult['COUNT(login)']  > 0)
        {$errors[] = 'Ошибка: пользователь с таким логином уже существует!';}
      // Ошибка, если пользователь с таким email уже существует
      if($emailExistsCheckResult['COUNT(email)'] > 0)
        {$errors[] = 'Ошибка: пользователь с таким email уже существует!';}
      // Ошибка, если пользователь не отметил чекбокс
      if(empty($data['agreementCheckboxRegistration'])) {$errors[] = 'Ошибка: Вы не согласились с условиями сайта!';}
      // Ошибка, если Google reCaprtcha V3 не пройдена
      if(!$reCaprtchaResultRegistration) {$errors[] = 'Ошибка: Вы робот!';}



      // Защита от SQL-injections и ввода нестандартных данных: ОТСУТСТВУЕТ!!!!!!!!!!!!!!!!!!!



      // Регистрируем нового пользователя, если нет ошибок
      if(empty($errors))
        {
          // Создаем хэш пароля пользователя с помощью BCRYPT, не работает в PHP ниже версии 5.5, поэтому следует подключить библиотеку password_compat
          $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
          // Записываем текущую дату
          $currentDate = date('d.m.Y');
          // Инициализируем переменную
          $exStat = '';
          // Заполняем статистику количества выполненных упражнений 0
          for ($i=0; $i < $config['EXERCISES']['EXERCISES_AMOUNT'] + 1; $i++)
            {
              $exStat = $exStat.'0 ';
            }
          // Убираем лишний последний пробел
          $exStat = rtrim($exStat);
          // Вносим в БД информацию о новом пользователе
          mysqli_query($connection, "INSERT INTO `users` (`id`, `login`, `email`, `password`, `reg_date`, `ex_stat`) VALUES (NULL, '".$data['login']."', '".$data['email']."', '".$passwordHash."', '".$currentDate."', '".$exStat."')");



              // ПОЧТА Нужно выделить в отдельный файл и написать html шаблоны


              // $to = $data['email'];
              // $subject = 'Регистрация на FastReader.ru';
              // $message = 'Здравствуйте, спасибо за регистрацию на FastReader.ru!'."\r\n".'Ваш логин: '.$data['login']."\r\n".'Старайтесь и у вас всё получится!';
              // $headers = 'From: support@FastReader.ru' . "\r\n" .
              // 'Reply-To: support@FastReader.ru' . "\r\n";
              // mail($to, $subject, $message, $headers);

          // Создаем текст сообщения об успешной регистрации
          $infoMsgText = 'Вы успешно зарегистрированы!';
          // Выводим сообщения об успешной регистрации, а также всплывающее уведомление
          $infoMsgTextResult = '<div class="alert alert-success" role="alert" data-type="success" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
        } else
          {
            // Создаем текст сообщение об ошибке
            $infoMsgText = array_shift($errors);
            // Выводим сообщение об ошибке, а также всплывающее уведомление
            $infoMsgTextResult = '<div class="alert alert-danger" role="alert" data-type="error" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
          }
      }

?>


  <?php
    // Если нет записей в сессии о том, что пользователь авторизован, то показываем регистрацию
    if (!isset($_SESSION['logged_user'])) {
  ?>

        <div class="contact-form" id="registration">

        	<div class="container">

            <h1 class="text-center">Регистрация</h1>

            <p>
              <?php
                // Вывод, если существует, информационного сообщения для пользователя
                echo @$infoMsgTextResult;
              ?>
           </p>

            <form action="/#registration"  method="post">

              <div class="form-group">
                <label for="login">Логин</label>
                <input type="text" class="form-control" id="login" name="login" autocomplete="on">
              </div>

              <div class="form-group">
                <label for="email">Адрес электронной почты</label>
                <input type="email" class="form-control" id="email" name="email" autocomplete="on">
              </div>

              <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" class="form-control" aria-describedby="passwordHelpBlock" name="password" autocomplete="off">
                <small id="passwordHelpBlock" class="form-text text-muted">
                  Ваш пароль должен быть длиной 8-20 символов, содержать буквы и цифры, а также
                  не должен содержать пробелов, специальных символов или эмодзи.
                </small>
              </div>

              <div class="form-group">
                <label for="password_repeat">Повтор пароля</label>
                <input type="password" id="password_repeat" class="form-control" name="password_repeat" autocomplete="off">
              </div>

              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="agreementCheckboxRegistration" name="agreementCheckboxRegistration" value="1">
                <label class="custom-control-label" for="agreementCheckboxRegistration">Я согласен на обработку персональных данных, а также с условиями
                  <a class="defaultLink" href="/<?php echo $config['USER_AGREEMENT'] ?>">пользовательского соглашения</a> и
                  <a class="defaultLink" href="/<?php echo $config['PRIVACY_POLICY'] ?>">политикой конфиденциальности</a>
                </label>
              </div>

              <div class="form-group">
                <input type="hidden" id="g-recaptcha-response-registration" name="g-recaptcha-response-registration">
              </div>

              <button type="submit" class="btn btn-primary" name="do_signup">Зарегистрироваться</button>

          </form>

        </div>

      </div>

  <?php
    }
    // Если в сессии есть записи о том, что пользователь авторизован, то не показываем регистрацию
    ?>
