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
  if( isset($data['save_try']))
    {
      $time = $data['currentTime'];
      // Модуль подсчёта количества выполнений упражнений
      require './includes/exStatCounter.php';
      // Модуль подсчёта опыта
      require './includes/xpCounter.php';
      // Создаем текст сообщения об внесении результатов в БД
      $infoMsgText = 'Поздравляем, '.$_SESSION['logged_user']['login'].', Вы выполнили упражнение за '.$time.' мс.';
      // Выводим сообщения об внесении результатов в БД, а также всплывающее уведомление
      $infoMsgTextResult = '<div class="alert alert-success" role="alert" data-type="success" data-text="'.$infoMsgText.'">'.$infoMsgText.'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
    }


 ?>
 <div id="info_bar">
   <?php require "./includes/viewsOutput.php" ?>

 </div>

<p id="error_msg"><?php echo @$infoMsgTextResult; ?></p>

 <label for="table_size">Размер таблицы (AxA):</label>
 <div class="search">
    <input type="number" class="form-control" id="table_size" min="4" max="" value="4">
   <button  class="defaultButton" onclick="ch_table_size()">Применить</button>
 </div>


 <label for="time">Время выполнения (миллисекунд):</label>
 <div class="search">
   <input type="text" class="form-control" id="time" disabled value="0">
  <button class="defaultButton" id="startButton" onclick="start_engine()">Начать</button>
 </div>

 <div id="table">
   <div id="tableLine" class="tableRow" style="display: none;">
     <div class="findNum">
       Найдите: <span id="findNum"> X</span>
     </div>
   </div>
   <form action="" method="post" >
   <div id="tableBody">
     <button type="submit" id="saveTry" name="save_try" style="display: none;"></button>
   </div>
   <input type="hidden" id="currentTime" name="currentTime" value="">
   </form>
 </div>
