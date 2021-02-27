<?php

// Модуль получения информации для построения графиков в профиле просматриваемого пользователя

  // Если есть данные о скорости за 30 дней, то считываем их и выводим
  if (!empty($userOutputResult['monthly_speed_value']) and !empty($userOutputResult['monthly_speed_date']))
    {
      $monthlySpeedValue = $userOutputResult['monthly_speed_value'];
      $monthlySpeedValue[0] = ' ';
      $monthlySpeedValue[1] = ' ';
      $monthlySpeedValue = trim($monthlySpeedValue);
      $monthlySpeedDate = trim($userOutputResult['monthly_speed_date']);
    } else
      {
        // Т.к. данных нет, то выводим 0
        $monthlySpeedValue = 0;
        $monthlySpeedDate = 0;
      }

  // Считываем названия упражнений
  $exNames = $config['EXERCISES']['NAMES'];
  // Считываем количество выполненных упражнений
  $exStat = $userOutputResult['ex_stat'];

 ?>
