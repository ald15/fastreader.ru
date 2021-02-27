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



  // Проверка на нажатие кнопки поиск
  if( isset($data['save_try']))
    {
      // Модуль подсчёта количества выполнений упражнений
      require './includes/exStatCounter.php';
      // Модуль подсчёта опыта
      require './includes/xpCounter.php';
      // Создаем текст сообщения об внесении результатов в БД
      $infoMsgText = 'Выполнение упражнения было успешно внесено в статистику!';
      // Выводим сообщения об внесении результатов в БД, а также всплывающее уведомление
      $infoMsgTextResult = '<div class="alert alert-success" role="alert" data-type="success" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
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
        // Выводим сообщения об ошибке, а также всплывающее уведомление
        $infoMsgTextResult = '<div class="alert alert-danger" role="alert" data-type="error" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
      }
     ?>
 </div>

<p id="error_msg"><?php echo @$infoMsgTextResult; ?></p>
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

 <label for="speed">Скорость чтения (сл./мин.):</label>
 <div class="search">
   <?php
     if ((int) $_SESSION['logged_user']['last_speed'] != 0)
       {
         $currentSpeed = $_SESSION['logged_user']['last_speed'];
       } else
         {
           $currentSpeed = 250;
         }
   ?>
  <input type="number" class="form-control" id="speed" min="1" value="<?php echo $currentSpeed;?>">
  <button  class="defaultButton" id="startButton" onclick="start_engine()">Начать</button>
 </div>

 <div id="text">
   <h4><?php echo $text_result['name']; ?></h4>
   <div id="areaWordsAmount">(слов: <span id="words_amount"> <?php echo $text_result['words_amount']; ?></span>)</div>
    <p class="text"><?php echo $text_result['text']; ?></p>
    <p>Источник: <a class="defaultLink" href="<?php  echo $text_result['resource_link'];?>"><?php  echo $text_result['resource_name'];?></a></p>
 </div>

 <form action="" method="post">
 <p><div id="saveButtonArea"><button type="submit" class="defaultButton" style="display: none;" id="saveTry" name="save_try"></button></div></p>

 </form>
