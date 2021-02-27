<?php

// Модуль настроек профиля

  // Получаем данные
  $data = $_POST;

  // Выполняем, если в post запросе есть запрос на изменение email
  if(isset($data['set_email']))
    {
      // Создаём массив для сохранения ошибок
      $errors = array();



            // Защита от SQL-injections и ввода нестандартных данных: ОТСУТСТВУЕТ!!!!!!!!!!!!!!!!!!!



      //Созданине ошибок

      // Ошибка, если поле email пусто
      if($data['profile_email'] == '') {$errors[] = 'Ошибка: e-mail не был введен!';}
      // Ошибка, если новый email совпадает со старым
      if($data['profile_email'] == $_SESSION['logged_user']['email']) {$errors[] = 'Ошибка: новый e-mail совпадает со старым!';}

      // Устанавливаем пользователю новый email, если нет ошибок
      if(empty($errors))
        {
          // Сохраняем новый email
          $newEmail = $data['profile_email'];
          // Заносим измененный email в  БД
          mysqli_query($connection, "UPDATE `users` SET `email` = '".$newEmail."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");
          // Записываем в сессию, что у пользователя новый email
          $_SESSION['logged_user']['email'] = $newEmail;
          // Создаем текст сообщения об успешном изменении email
          $infoMsgText = 'Новый e-mail был успешно установлен!';
          // Выводим сообщения об успешном изменении email, а также всплывающее уведомление
          $infoMsgTextResult = '<div class="alert alert-success" role="alert" data-type="success" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
          $infoMsgTextResultEmail = $infoMsgTextResult;
        } else
          {
            // Создаем текст сообщение об ошибке
            $infoMsgText = array_shift($errors);
            // Выводим сообщение об ошибке, а также всплывающее уведомление
            $infoMsgTextResult = '<div class="alert alert-danger" role="alert" data-type="error" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
            $infoMsgTextResultEmail = $infoMsgTextResult;
          }

    }



    // Выполняем, если в post запросе есть запрос на изменение "О себе"
    if(isset($data['set_about_me']))
      {
        // Создаём массив для сохранения ошибок
        $errors = array();



              // Защита от SQL-injections и ввода нестандартных данных: ОТСУТСТВУЕТ!!!!!!!!!!!!!!!!!!!



        //Созданине ошибок

        // Ошибка, если поле "О себе" пусто
        if($data['profile_about_me'] == '') {$errors[] = 'Ошибка: текcт &quot;О себе&quot; не был введен!';}
        // Ошибка, если новый "О себе" совпадает со старым
        if($data['profile_about_me'] == $_SESSION['logged_user']['about_me']) {$errors[] = 'Ошибка: новый текcт &quot;О себе&quot; совпадает со старым!';}
        if (strlen($data['profile_about_me']) > $config['USER']['ABOUT_ME_LENGTH']) {$errors[] = 'Ошибка: текcт &quot;О себе&quot; больше '.$config['USER']['ABOUT_ME_LENGTH'].' символов !';}

        // Устанавливаем пользователю новый текст "О себе", если нет ошибок
        if(empty($errors))
          {
            // Сохраняем новый email
            $newAboutMe = $data['profile_about_me'];
            // Заносим измененный email в  БД
            mysqli_query($connection, "UPDATE `users` SET `about_me` = '".$newAboutMe."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");
            // Записываем в сессию, что у пользователя новый email
            $_SESSION['logged_user']['about_me'] = $newAboutMe;
            // Создаем текст сообщения об успешном изменении "О себе"
            $infoMsgText = 'Новый текст &quot;О себе&quot; был успешно установлен!';
            // Выводим сообщения об успешном изменении "О себе"
            $infoMsgTextResult = '<div class="alert alert-success" role="alert" data-type="success" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
            $infoMsgTextResultAbotMe = $infoMsgTextResult;
          } else
            {
              // Создаем текст сообщение об ошибке
              $infoMsgText = array_shift($errors);
              // Выводим сообщение об ошибке, а также всплывающее уведомление
              $infoMsgTextResult = '<div class="alert alert-danger" role="alert" data-type="error" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
              $infoMsgTextResultAbotMe = $infoMsgTextResult;
            }

      }



      // Выполняем, если в post запросе есть запрос на изменение пароля
      if(isset($data['set_password']))
        {
          // Создаём массив для сохранения ошибок
          $errors = array();



                // Защита от SQL-injections и ввода нестандартных данных: ОТСУТСТВУЕТ!!!!!!!!!!!!!!!!!!!



          //Созданине ошибок

          // Ошибка, если поле пароль пусто
          if($data['profile_password'] == '') {$errors[] = 'Ошибка: пароль не был введен!';}
          // Ошибка, если поле повторный пароль пусто
          if($data['profile_password_repeat'] == '') {$errors[] = 'Ошибка: пароль не был введен ещё раз!';}
          // Ошибка, если пароли не совпадают
          if($data['profile_password'] != $data['profile_password_repeat']) {$errors[] = 'Ошибка: пароли не совпадают!';}
          // Ошибка, если хэш нового пароля совпадает со старым
          if(password_verify($data['profile_password'], $_SESSION['logged_user']['password'])){$errors[] = 'Ошибка: этот пароль уже установлен!';}
          // Ошибка, если пользователь не отметил чекбокс
          if(empty($data['agreementCheckboxProfilePassword'])) {$errors[] = 'Ошибка: Вы не подтвердили смену пароля!';}

          // Устанавливаем пользователю новый текст "О себе", если нет ошибок
          if(empty($errors))
            {
              // Создаем хэш пароля пользователя с помощью BCRYPT, не работает в PHP ниже версии 5.5, поэтому следует подключить библиотеку password_compat
              $profilePasswordHash = password_hash($data['profile_password'], PASSWORD_DEFAULT);
              // Заносим измененный пароль в  БД
              mysqli_query($connection, "UPDATE `users` SET `password` = '".$profilePasswordHash."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");
              // Записываем в сессию, что у пользователя новый пароль
              $_SESSION['logged_user']['password'] = $profilePasswordHash;
              // Создаем текст сообщения об успешном изменение пароля
              $infoMsgText = 'Новый пароль был успешно установлен!';
              // Выводим сообщения об успешном изменении пароля, а также всплывающее уведомление
              $infoMsgTextResult = '<div class="alert alert-success" role="alert" data-type="success" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
              $infoMsgTextResultPassword = $infoMsgTextResult;
            } else
              {
                // Создаем текст сообщение об ошибке
                $infoMsgText = array_shift($errors);
                // Выводим сообщение об ошибке, а также всплывающее уведомление
                $infoMsgTextResult = '<div class="alert alert-danger" role="alert" data-type="error" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
                $infoMsgTextResultPassword = $infoMsgTextResult;
              }

        }



        // Выполняем, если в post запросе есть запрос на изменение пунктов конфиденциальности
        if(isset($data['set_privacy']))
          {
            // Собираем данные с чекбоксов
            if(empty($data['agreementCheckboxProfileCEmail'])) {$cEmail = 0;} else {$cEmail = 1;}
            if(empty($data['agreementCheckboxProfileCAboutMe'])) {$cAboutMe = 0;} else {$cAboutMe = 1;}
            if(empty($data['agreementCheckboxProfileCStat'])) {$cStat = 0;} else {$cStat = 1;}
            // Заносим измененный email в  БД
            mysqli_query($connection, "UPDATE `users` SET `c_email` = '".$cEmail."', `c_about_me` ='".$cAboutMe."', `c_stat` = '".$cStat."'  WHERE `login` = '".$_SESSION['logged_user']['login']."'");
            // Записываем в сессию, что у пользователя изменения в конфиденциальности
            $_SESSION['logged_user']['c_email'] = $cEmail;
            $_SESSION['logged_user']['c_about_me'] = $cAboutMe;
            $_SESSION['logged_user']['c_stat'] = $cStat;

            // Создаем текст сообщения об успешном изменении в конфиденциальности
            $infoMsgText = 'Настройки конфиденциальности были успешно установлены!';
            // Выводим сообщения об успешном изменении "О себе"
            $infoMsgTextResult = '<div class="alert alert-success" role="alert" data-type="success" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
            $infoMsgTextResultPrivacy = $infoMsgTextResult;
          }

?>
