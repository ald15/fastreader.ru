<?php
// Модуль счётчик просмотров для упражнений

  // Если в cookies отсутствует запись о просмотре упражнения
  if(empty($_COOKIE['exercises_last_visit'.$exerciseId])) {

      // Если пользователь ещё не смотрел это упражнение в текущей сессии
      if (($_SESSION['logged_user']['exercises_views'][$exerciseId] <= 1)) {
        // Записываем в сессию, что пользователь посмотрел это упражнение
        $_SESSION['logged_user']['exercises_views'][$exerciseId] += 1;
      }

      // Если пользователь посмотрел это упражнение
      if ($_SESSION['logged_user']['exercises_views'][$exerciseId] == 1) {
        // Создаем запись в cookies о том, что пользователь просмотрел это упражнение, сроком на 90 минут
        setcookie('exercises_last_visit'.$exerciseId, 1, time()+5400);
        // Вносим пользовательский просмотр в БД
        mysqli_query($connection, "UPDATE `exercises` SET `views` = `views` + 1 WHERE `id` = ".$exerciseId);
      }
    }
 ?>
