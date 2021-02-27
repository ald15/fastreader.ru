<?php




  // Выводим случайный текст
  $error_msg = false;
  $accelerator = mysqli_query($connection, "SELECT * FROM `accelerator`");
  $text_amount = mysqli_num_rows($accelerator);
  $text_id = rand(1, $text_amount);
  $text = mysqli_query($connection, "SELECT * FROM `accelerator` WHERE `id` = ".$text_id);
  $text_result = mysqli_fetch_assoc($text);


  // Поиск текста по ID
  $data = $_POST;
  // Проверка на нажатие кнопки поиск
  if( isset($data['do_search']))
    {
      $text_id = $data['s_text_id'];
      // Проверка на ввод несуществующего или пустого ID текста
      if (!empty($text_id) and ($text_id <= $text_amount)) {
        $text = mysqli_query($connection, "SELECT * FROM `accelerator` WHERE `id` = ".$text_id);
        $text_result = mysqli_fetch_assoc($text);
      }else {
        // Если текст не был найден, то выводим случайный текст
        $error_msg = true;
        $text_id = rand(1, $text_amount);
        $text = mysqli_query($connection, "SELECT * FROM `accelerator` WHERE `id` = ".$text_id);
        $text_result = mysqli_fetch_assoc($text);}

    }
    if (isset($data['rand_text'])) {
      $text_id = rand(1, $text_amount);
      $text = mysqli_query($connection, "SELECT * FROM `accelerator` WHERE `id` = ".$text_id);
      $text_result = mysqli_fetch_assoc($text);
    }



  if( isset($data['save_speed']))
    {
      // Создаём массив для сохранения ошибок
      $errors = array();

      // Защиты

      // Защита от накрутки
      if (((int) $data['currentSpeed'] > 1500) or ((int) $data['currentSpeed'] <= 0)) {$errors[] = 'Ошибка: Вы робот!';}

      // Сохраняем скорость в БД, если нет ошибок
      if (empty($errors))
        {

          // Вносим в БД информацию о текущей скорости чтения
          mysqli_query($connection, "UPDATE `users` SET `last_speed` = '".$data['currentSpeed']."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");
          // Делаем записи в сессии о текущей скорости скорости
          $_SESSION['logged_user']['last_speed'] = $data['currentSpeed'];

          // Модуль подсчёта количества выполнений упражнений
          require './includes/exStatCounter.php';
          // Модуль подсчёта опыта
          require './includes/xpCounter.php';


          // Модуль вычисления средней дневной скорости

          // Получаем текущаю дневную скорость
          $getDailySpeed = $_SESSION['logged_user']['daily_speed'];

          // Если дневная скорость не пустая, то записываем данные
          if ($getDailySpeed != '')
            {
              // Инициализируем переменные
              // k - index символа строки, на котором заканчивается число пыпыток
              $k = 0;
              // Число попыток чтения за день
              $dailySpeedTryAmount ='';
              // Сумма скоростей чтения за день
              $dailySpeedTrySum ='';
              // Дата
              $dailySpeedDate = '';


              // Считываем дату
              for ($i=0; $i <= strlen($getDailySpeed); $i++)
                {
                  // Если символ не пробел, то собираем число дальше
                  if ($getDailySpeed[$i] == ' ')
                    {
                      break;
                    } else
                      {
                        // Составляем дату
                        $dailySpeedDate = $dailySpeedDate.$getDailySpeed[$i];
                      }
                }


              // Если дата дневной скорости равна текущей дате, то продолжаем
              if ($dailySpeedDate == date('d').date('m').date('Y'))
                {
                  // Считываем количество попыток
                  for ($i=9; $i <= strlen($getDailySpeed); $i++)
                    {
                      // Если символ не пробел, то собираем число дальше
                      if ($getDailySpeed[$i] == ' ')
                        {
                          break;
                        } else
                          {
                            // Составляем количество попыток
                            $dailySpeedTryAmount = $dailySpeedTryAmount.$getDailySpeed[$i];
                            // Сохраняем индекс символа, на котором остановились
                            $k = $i;
                          }
                    }

                  // Считываем скорость
                  for ($j=$k + 2; $j <= strlen($getDailySpeed); $j++)
                    {
                      // Если символ не пробел, то собираем число дальше
                      if ($getDailySpeed[$j] == ' ')
                        {
                          break;
                        } else
                          {
                            // Составляем скорость
                            $dailySpeedTrySum = $dailySpeedTrySum.$getDailySpeed[$j];
                          }
                    }

                  // Прибавляем еще одну попытку
                  $dailySpeedTryAmount = (int) $dailySpeedTryAmount + 1;
                  // Добавляем к сумме скоростей текущую скорость
                  $dailySpeedTrySum = (int) $dailySpeedTrySum + (int) $data['currentSpeed'];

                } else
                  {
                    // Т.к. новая дата, то устанавливаем 1 попытку, а сумма = текущей скорости
                    $dailySpeedTryAmount = 1;
                    $dailySpeedTrySum = (int) $data['currentSpeed'];
                  }
            } else
              {
                // Т.к. дневная скорость пустая,  то устанавливаем 1 попытку, а сумма = текущей скорости
                $dailySpeedTryAmount = 1;
                $dailySpeedTrySum = (int) $data['currentSpeed'];
              }


              // Модуль сбора статистики скорости чтения

              // Получаем скорости чтения за последние 30 дней
              $monthlySpeedValue = $_SESSION['logged_user']['monthly_speed_value'];
              // Получаем даты замеров скоростей за последние 30 дней
              $monthlySpeedDate = $_SESSION['logged_user']['monthly_speed_date'];
              // Вычисляем длину строки скоростей чтения за последние 30 дней
              $mSVLen = strlen($monthlySpeedValue);
              // Вычисляем длину строки даты замеров скоростей за последние 30 дней
              $mSDLen = strlen($monthlySpeedDate);
              // Вычисляем среднюю дневную скорость чтения
              $averageDailySpeed = round($dailySpeedTrySum / $dailySpeedTryAmount);
              // Переводим среднюю дневную скорость в строку
              $averageDailySpeed = (string) $averageDailySpeed;
              // Вычисляем длину строки средней дневной скорости
              $aDSLen = strlen($averageDailySpeed);
              // Вычисялем текущую дату
              $currentDate = date('d').'.'.date('m');
              // Если присутствуют записи в скорости чтения и даты к ним за последние 30 дней, то продолжаем
              if (($mSVLen > 0) and ($mSDLen > 0))
                {
                  // Определяем количество дней в замерах
                  $dayAmount = $monthlySpeedValue[0].$monthlySpeedValue[1];
                  // Переводим полученные данные в число
                  $dayAmount = (int) $dayAmount;

                  // Если не 31 день, то делаем запись
                  if ($dayAmount < 30)
                    {
                      // Вычисляем последнюю дату
                      $lastDate = $monthlySpeedDate[$mSDLen - 6].$monthlySpeedDate[$mSDLen - 5].$monthlySpeedDate[$mSDLen - 4].$monthlySpeedDate[$mSDLen - 3].$monthlySpeedDate[$mSDLen - 2];
                      // Если последняя дата равна текущей, то продолжаем
                      if ($currentDate == $lastDate)
                        {
                          // Убираем последние пробелы в строке скоростей
                          $monthlySpeedValue = rtrim($monthlySpeedValue);
                          // Инициализируем текущую среднюю дневную скорость
                          $currentAverageDailySpeed = '';
                          // Вычисляем текущую среднюю скорость на эту дату, чтобы стереть ее
                          for ($i= $mSVLen - 2; $i > 0; $i--)
                            {
                              // Если символ не пробел, то собираем число дальше
                              if ($monthlySpeedValue[$i] == ' ')
                                {
                                  break;
                                } else
                                  {
                                    // Собираем число среднй скорости
                                    $currentAverageDailySpeed = $currentAverageDailySpeed.$monthlySpeedValue[$i];
                                    // Затеняем цифры получаемого числа пробелами
                                    $monthlySpeedValue[$i] = ' ';
                                    // Делаем пометку точки остановки, чтобы знать где закончилось число
                                    $k = $i;
                                  }
                            }
                          // Убираем последние пробелы в строке скоростей
                          $monthlySpeedValue = rtrim($monthlySpeedValue);
                          // Собираем строку средней дневной скорости за последние 30 дней, но уже с обновленными данными
                          $monthlySpeedValue = $monthlySpeedValue.' '.$averageDailySpeed.' ';
                        } else
                          {
                            // Т.к. дата уже новая, то делаем новую запись
                            // Добаляем 1 день замеров
                            $dayAmount += 1;
                            // Если число дней замеров меньше 10, то приписываем 0 вначале
                            if ($dayAmount < 10)
                              {
                                $monthlySpeedValue[0] = 0;
                                $monthlySpeedValue[1] = $dayAmount;
                              } else
                                {
                                  // Т.к. число больше 10, то просто поразрядно заменяем
                                  $dayAmount = (string) $dayAmount;
                                  $monthlySpeedValue[0] = $dayAmount[0];
                                  $monthlySpeedValue[1] = $dayAmount[1];
                                }
                            // Собираем строку средней дневной скорости за последние 30 дней, но уже с обновленными данными
                            $monthlySpeedValue = $monthlySpeedValue.$averageDailySpeed.' ';
                            // Собираем строку дат замеров скоростей за последние 30 дней, но уже с обновленными данными
                            $monthlySpeedDate = $monthlySpeedDate.$currentDate.' ';
                          }

                    } else
                      {
                        // Т.к. количество дней уже 30 то мы удаляем все записи и начинаем вести статистику снова
                        $monthlySpeedValue = '';
                        $monthlySpeedDate = '';
                        // Обозначаем что это первый день в статистике
                        $monthlySpeedValue = '01 ';
                        $monthlySpeedValue = $monthlySpeedValue.$averageDailySpeed.' ';
                        $monthlySpeedDate = $monthlySpeedDate.$currentDate.' ';
                      }
            } else
              {
                // Т.к. нет никаких записей о статистике, то начинаем вести статистику
                // Обозначаем что это первый день в статистике
                $monthlySpeedValue = '01 ';
                $monthlySpeedValue = $monthlySpeedValue.$averageDailySpeed.' ';
                $monthlySpeedDate = $monthlySpeedDate.$currentDate.' ';
              }

          // Делаем записи в сессии о новых данных дневной скорости
          $_SESSION['logged_user']['monthly_speed_value'] = $monthlySpeedValue;
          // Делаем записи в сессии о новых данных дневной скорости
          $_SESSION['logged_user']['monthly_speed_date'] = $monthlySpeedDate;
          // Вносим в БД информацию о данных дневной скорости
          mysqli_query($connection, "UPDATE `users` SET `monthly_speed_value` = '".$monthlySpeedValue."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");
          // Вносим в БД информацию о данных дневной скорости
          mysqli_query($connection, "UPDATE `users` SET `monthly_speed_date` = '".$monthlySpeedDate."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");



          // Сохраняем новые данные о дневной скорости
          $dailySpeed = date('d').date('m').date('Y').' '.$dailySpeedTryAmount.' '.$dailySpeedTrySum.' ';
          // Делаем записи в сессии о новых данных дневной скорости
          $_SESSION['logged_user']['daily_speed'] = $dailySpeed;
          // Вносим в БД информацию о данных дневной скорости
          mysqli_query($connection, "UPDATE `users` SET `daily_speed` = '".$dailySpeed."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");

          // Установка лучшей скорости чтения за всё время
          // Если прошлая лучшая скорость больше текущей скорости, то вносим данные о ней в БД
          if ($_SESSION['logged_user']['best_speed'] < (int) $data['currentSpeed'])
            {
              // Вносим в БД информацию о данных лучшей скорости
              mysqli_query($connection, "UPDATE `users` SET `best_speed` = '".$data['currentSpeed']."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");
              // Делаем записи в сессии о новой лучшей скорости
              $_SESSION['logged_user']['best_speed'] =  $data['currentSpeed'];
            }

          // Создаем текст сообщения об внесении результатов в БД
          $infoMsgText = 'Поздравляем, '.$_SESSION['logged_user']['login'].', скорость вашего чтения: '.$_SESSION['logged_user']['last_speed'].' сл./мин.';
          // Выводим сообщения об внесении результатов в БД, а также всплывающее уведомление
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
 <div id="info_bar">
   <?php require "./includes/viewsOutput.php" ?>
   <span id="text_id" class="badge badge-secondary">ID: <?php echo $text_id; ?></span>
   <?php
    if ($error_msg)
      {
        // Создаем текст сообщения об внесении результатов в БД
        $infoMsgText = 'Ошибка: текст не был найден!';
        // Выводим сообщения об внесении результатов в БД, а также всплывающее уведомление
        $infoMsgTextResult = '<div class="alert alert-danger" role="alert" data-type="error" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
      }
     ?>
 </div>

<p><?php echo @$infoMsgTextResult; ?></p>
 <form action="" method="post">
   <label for="search_input">Поиск:</label>
   <div class="search">
   <input type="number" class="form-control" id="search_input" placeholder="ID" name="s_text_id" min="1" value="">
   <button type="submit" class="defaultButton" name="do_search">Поиск</button>
   <button type="submit" class="defaultButton" name="rand_text">Случайный</button>
 </div>
 </form>

 <label for="font_size">Шрифт:</label>
 <div class="search">
    <input type="number" class="form-control" id="font_size" min="16" value="20">
   <button  class="defaultButton" onclick="ch_font_size()">Применить</button>
 </div>

<label for="time">Время чтения:</label>
<div class="search">
  <input type="text" class="form-control" id="time" disabled value="00 : 00">
 <button class="defaultButton" id="startButton" onclick="start_engine()">Начать</button>
</div>




<div id="text">
  <h4><?php echo $text_result['name']; ?></h4>
  <div id="areaWordsAmount">(слов: <span id="words_amount"> <?php echo $text_result['words_amount']; ?></span>)</div>
   <p class="text"><?php echo $text_result['text']; ?></p>
   <p>Источник: <a class="defaultLink" href="<?php  echo $text_result['resource_link'];?>"><?php  echo $text_result['resource_name'];?></a></p>
</div>


 <form action="" method="post">
 <p id="stopButtonArea"><button type="submit" class="defaultButton" style="display: none;" id="saveSpeed" name="save_speed"></button></p>

 <input type="hidden" id="currentSpeed" name="currentSpeed" value="">
</form>
