<?php


// Модуль настроек сайта


  // Подключение модуля подключения к БД
  require_once "db.php";

  // Подключение модуля BCRYPT для хэширования паролей нужно для PHP ниже 5.5
  require "libs/password.php";

  // Создаем массив настроек сайта
  $config = array(

    // База данных
    'db' => array(
      'server' => '127.0.0.1:3308',
      'username' => 'root',
      'password' => '',
      'base_name' => 'test_p'
    ),


    // Сайт
    'SITE_COLORS' => '',
    'SITE_TITLE' => 'Fast Reader | Скорочтение',
    'SITE_DESCRIPTION' => 'FastReader.ru обучающий сайт, позволяющий Вам тренировать навык скорочтения, при помощи широкого спектора методов и упражнений',
    'SITE_KEYWORDS' => 'Fast Reader, скорочтение, упражнения, методы, тренировка',
    'SITE_NAME' => 'Fast Reader',
    'SITE_URL' => 'https://fastreader.ru',
    'SITE_LOGO' => '/img/logo.png',
    'SITE_ABOUT_IMG' => '/img/about_img.png',
    'SITE_FAVICON' => '/img/favicon128.ico',
    'SITE_DATE' => '2020',
    'SITE_EMAIL' => 'support@fastreader.ru',
    'SITE_CONTACTS' => '',
    'SITE_COUNTER' => '',
    'USER_AGREEMENT' => 'user_agreement.php',
    'PRIVACY_POLICY' => 'privacy_policy.php',


    // Упражнения
    'EXERCISES' => array(
      'EXERCISES_AMOUNT' => 4,
      'NAMES' => 'Numbers Numbers1 Numbers2 Numbers3 Поиск_числа Таблица_Шульте Проверка_скорости_чтения Ускоритель_чтения',
    ),

    // Пользователь
    'USER' => array(
      'MAX_EXP' => 1000,
      'AVATARS_AMOUNT' => 17,
      'AVATARS_FORMAT' => '.png',
      'ABOUT_ME_LENGTH' => 255
    ),


    // Ключ сайта и секретный ключ для Google reCaprtcha V3
    'SITE_KEY' => '6LdWwOMUAAAAAJOwUDvgHWsV702AULb06_8MvX1u',
    'SECRET_KEY' => '6LdWwOMUAAAAAL4yw03KI5y_O2leFdblwgA7l-Wz'

  );

?>
