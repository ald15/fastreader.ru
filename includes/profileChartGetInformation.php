<?php

// Модуль получения информации для построения графиков в профиле пользователя

  // Если есть данные о скорости за 30 дней, то считываем их и выводим
  if (!empty($_SESSION['logged_user']['monthly_speed_value']) and !empty($_SESSION['logged_user']['monthly_speed_date']))
    {
      $monthlySpeedValue = $_SESSION['logged_user']['monthly_speed_value'];
      $monthlySpeedValue[0] = ' ';
      $monthlySpeedValue[1] = ' ';
      $monthlySpeedValue = trim($monthlySpeedValue);
      $monthlySpeedDate = trim($_SESSION['logged_user']['monthly_speed_date']);
    } else
      {
        // Т.к. данных нет, то выводим 0
        $monthlySpeedValue = 0;
        $monthlySpeedDate = 0;
      }

  // Считываем названия упражнений
  $exNames = $config['EXERCISES']['NAMES'];
  // Считываем количество выполненных упражнений
  $exStat = $_SESSION['logged_user']['ex_stat'];

 ?>
