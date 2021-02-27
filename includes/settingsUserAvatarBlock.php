
  <h4>Настройки картинки профиля</h4>

    <div class="row">

      <div class="col-md-12 col-lg-12 col-sm-12">

        <p>
          <?php
            // Вывод, если существует, информационного сообщения для пользователя
            echo @$infoMsgTextResultAvatar;
          ?>
        </p>
        
        <p>
          Вы можете изменить свою картинку профиля: выберите картинку
           из предложенного списка, нажмите на неё, затем, чтобы применить
           изменения нажмите на кнопку "Изменить".
        </p>

        <div id="settingsUserAvatarChooseBlock">

          <script src="/js/settingsAvatar.js"></script>

          <?php
            // Выше подключаем скрипт для обработки выбора аватараки
            // Выводим все аватарки в количестве, указанном в config.php
            for ($i=1; $i <= $config['USER']['AVATARS_AMOUNT']; $i++) {
          ?>

            <img onclick="chooseAvatar(<?php echo $i; ?>)" src="/img/avatars/user_avatar_<?php echo $i.$config['USER']['AVATARS_FORMAT']; ?>" id="avatar_<?php echo $i; ?>" class="settingsUserAvatar">

          <?php
            }
          ?>

        </div>

      </div>

    </div>


    <form action=""  method="post">

      <input type="hidden" id="userAvatarId" name="userAvatarId" value="">

      <button type="submit" class="defaultButton profileSetButton" name="set_avatar">Изменить</button>

    </form>
