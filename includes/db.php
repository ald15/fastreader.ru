<?php


// Модуль подключения к БД


  // Подключаем модуль настроек сайта
  require "config.php";

  // Начинаем новую сессию
  session_start();

  // Подключаемся к БД
  $connection = mysqli_connect('127.0.0.1:3308', $config["db"]['username'], '', 'test_p');

  // Если не удалось подключиться, то выводим ошибку
  if ($connection == false)
  {
    // Выводим наше сообщение об ошибке
    echo "Не удалось подкючиться к БД!";

    // Выводим сообщение от MYSQL
    echo mysqli_connect_error();

    // Завершаем работу
    exit();
  }

?>
