<?php

// Модуль подсчёта количества выполнений упражнений

  // Получаем массив текущих значений
  $exStat = explode(' ', $_SESSION['logged_user']['ex_stat']);
  // Добавляем к текущему упражнению еще одно выполнение
  (int) $exStat[(int) $exerciseId] += 1;
  // Собираем массив в строку
  $exStatResult = implode(' ', $exStat);
  // Вносим в БД информацию о статистике количества выполнений упражнений
  mysqli_query($connection, "UPDATE `users` SET `ex_stat` = '".$exStatResult."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");
  // Делаем записи в сессии о статистике количества выполнений упражнений
  $_SESSION['logged_user']['ex_stat'] = $exStatResult;

 ?>
