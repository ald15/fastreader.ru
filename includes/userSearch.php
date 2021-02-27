<?php

// Модуль поиска пользователя

// Получаем данные
$data = $_POST;

// Проверка на нажатие кнопки поиск
if( isset($data['do_search']))
  {
    // Записываем введенный логин
    $userName = $data['searchUser_input'];
    // перенаправляем на страницу профиля искомого пользователя
    header('Location: uprofile.php?uname='.$userName);
  }

 ?>
