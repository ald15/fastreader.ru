<?php

// Модуль настройки картинки профиля пользователя

  // Получаем данные
  $data = $_POST;

  // Выполняем, если в post запросе есть запрос на регистрацию
  if(isset($data['set_avatar']))
    {
      // Создаём массив для сохранения ошибок
      $errors = array();

      //Созданине ошибок
      // Ошибка при отсутствие выбора
      if($data['userAvatarId'] == '') {$errors[] = 'Ошибка: картинка не была выбрана!';}
      // Ошибка при вводе пользователем недопустимого значения в скрытое поле
      if(((int) $data['userAvatarId'] <= 0) or ((int) $data['userAvatarId'] > $config['USER']['AVATARS_AMOUNT']) or ($data['userAvatarId'] == 'true') or ($data['userAvatarId'] == 'false')) {$errors[] = 'Ошибка: выбрана несуществующая картинка!';}

      // Устанавливаем пользователю новую аватарку, если нет ошибок
      if(empty($errors))
        {
          // ТУТ PNG
          // Создаём имя файла аватарки
          $avatarName = 'user_avatar_'.$data['userAvatarId'].$config['USER']['AVATARS_FORMAT'];
          // Заносим измененную аватарку в  БД
          mysqli_query($connection, "UPDATE `users` SET `avatar` = '".$avatarName."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");
          // Записываем в сессию, что у пользователя новая аватарка
          $_SESSION['logged_user']['avatar'] = $avatarName;
          // Создаем текст сообщения об успешном изменении аватарки
          $infoMsgText = 'Новая картинка профиля была успешно установлена!';
          // Выводим сообщения об успешном изменении аватарки, а также всплывающее уведомление
          $infoMsgTextResult = '<div class="alert alert-success" role="alert" data-type="success" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
          $infoMsgTextResultAvatar = $infoMsgTextResult;
        } else
          {
            // Создаем текст сообщение об ошибке
            $infoMsgText = array_shift($errors);
            // Выводим сообщение об ошибке, а также всплывающее уведомление
            $infoMsgTextResult = '<div class="alert alert-danger" role="alert" data-type="error" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
            $infoMsgTextResultAvatar = $infoMsgTextResult;
          }
    }

?>
