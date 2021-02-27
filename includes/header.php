<header class="header">
   <div class="overlay">
     <div class="container">
       <div class="description">

         <?php

          // Если пользователь авторизован
          if(isset($_SESSION['logged_user'])) {
            // Если пользователь авторизован и это его первое посещение после авторизации
            if($_SESSION['logged_user']['first_visit'] <= 1) {
              // Создаем текст сообщения об успешной авторизаци
              $infoMsgText = 'Вы успешно авторизовались!';
              // Выводим сообщения об успешной авторизации, а также всплывающее уведомление
              $infoMsgTextResult = '<div data-type="success" data-text="'.$infoMsgText.'"></div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
              // Создаем невидимый блок с текстом для всплывающего уведомления
              echo $infoMsgTextResult;
              // Делаем запись в сессию о том, что пользователь видел уведомление об авторизации
              $_SESSION['logged_user']['first_visit'] += 1;
            }
           ?>

           <h1>Здравствуйте, <?php echo $_SESSION['logged_user']['login']; ?>, добро пожаловать на <?php echo $config['SITE_NAME']; ?>!

          <?php
          } else
            {
           ?>

            <h1>Здравствуйте, добро пожаловать на <?php echo $config['SITE_NAME']; ?>!

          <?php } ?>

           <p>
             <?php echo $config['SITE_DESCRIPTION']; ?>
            </p>

            <a class="btn btn-outline-secondary" href="/#login">Начать</a>

          </h1>

        </div>
      </div>
    </div>
</header>
