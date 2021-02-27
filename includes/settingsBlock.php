
  <h4>Настройки</h4>

  <div class="form-group">
    <label for="profile_login">Логин</label>
    <input type="login" class="form-control" id="profile_login" disabled value="<?php echo $_SESSION['logged_user']['login']; ?>">
  </div>
  <p>
    <?php
      // Вывод, если существует, информационного сообщения для пользователя
      echo @$infoMsgTextResultEmail;
    ?>
  </p>
  <form action=""  method="post">

    <div class="form-group">
      <label for="profile_email">Адрес электронной почты</label>
      <input type="email" class="form-control" id="profile_email" name="profile_email" value="<?php echo $_SESSION['logged_user']['email']; ?>">
    </div>

    <button type="submit" class="defaultButton profileSetButton" name="set_email">Изменить</button>

  </form>


  <hr>

  <p>
    <?php
      // Вывод, если существует, информационного сообщения для пользователя
      echo @$infoMsgTextResultAbotMe;
    ?>
  </p>
  <form action=""  method="post">

    <div class="form-group">
      <label for="profile_about_me">О себе</label>
      <span>(<?php echo $config['USER']['ABOUT_ME_LENGTH']; ?> символов)</span>
      <textarea class="form-control" id="profile_about_me" name="profile_about_me" rows="3"><?php echo $_SESSION['logged_user']['about_me']; ?></textarea>
    </div>

    <button type="submit" class="defaultButton profileSetButton" name="set_about_me">Изменить</button>

  </form>


  <hr>


  <p>
    <?php
      // Вывод, если существует, информационного сообщения для пользователя
      echo @$infoMsgTextResultPassword;
    ?>
  </p>
  <h4>Смена пароля</h4>

  <form action=""  method="post">

    <div class="form-group">
      <label for="profile_password">Новый пароль</label>
      <input type="password" class="form-control" id="profile_password" name="profile_password" autocomplete="off">
    </div>

    <div class="form-group">
      <label for="profile_password_repeat">Повтор пароля</label>
      <input type="password" class="form-control" id="profile_password_repeat" name="profile_password_repeat" autocomplete="off">
    </div>

    <div class="form-group">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="agreementCheckboxProfilePassword" name="agreementCheckboxProfilePassword" value="1">
        <label class="custom-control-label" for="agreementCheckboxProfilePassword">Подтверждаю смену пароля</label>
      </div>
    </div>

    <button type="submit" class="defaultButton profileSetButton" name="set_password">Изменить</button>

  </form>


  <hr>


  <p>
    <?php
      // Вывод, если существует, информационного сообщения для пользователя
      echo @$infoMsgTextResultPrivacy;
    ?>
  </p>
  <h4>Настройки конфиденциальности</h4>

  <form action=""  method="post">
    <div class="form-group">
      <div class="custom-control custom-checkbox">

        <?php
          // Если пункт уже был выбран, то отмечаем его
          if ($_SESSION['logged_user']['c_email'] == 1) {
        ?>

         <input type="checkbox" class="custom-control-input" id="agreementCheckboxProfileCEmail" checked name="agreementCheckboxProfileCEmail" value="1">

       <?php } else { ?>

        <input type="checkbox" class="custom-control-input" id="agreementCheckboxProfileCEmail" name="agreementCheckboxProfileCEmail" value="1">

      <?php } ?>

        <label class="custom-control-label" for="agreementCheckboxProfileCEmail">Разрешить показывать другим пользователям адрес электронной почты</label>

      </div>
    </div>

    <div class="form-group">
      <div class="custom-control custom-checkbox">

        <?php
          // Если пункт уже был выбран, то отмечаем его
          if ($_SESSION['logged_user']['c_about_me'] == 1) {
        ?>

         <input type="checkbox" class="custom-control-input" id="agreementCheckboxProfileCAboutMe" checked name="agreementCheckboxProfileCAboutMe" value="1">

        <?php } else { ?>

        <input type="checkbox" class="custom-control-input" id="agreementCheckboxProfileCAboutMe" name="agreementCheckboxProfileCAboutMe" value="1">

        <?php } ?>

        <label class="custom-control-label" for="agreementCheckboxProfileCAboutMe">Разрешить показывать другим пользователям информацию "О себе"</label>

      </div>
    </div>

    <div class="form-group">
      <div class="custom-control custom-checkbox">


        <?php
          // Если пункт уже был выбран, то отмечаем его
          if ($_SESSION['logged_user']['c_stat'] == 1) {
        ?>

         <input type="checkbox" class="custom-control-input" id="agreementCheckboxProfileCStat" checked name="agreementCheckboxProfileCStat" value="1">

       <?php } else { ?>

        <input type="checkbox" class="custom-control-input" id="agreementCheckboxProfileCStat" name="agreementCheckboxProfileCStat" value="1">

      <?php } ?>

        <label class="custom-control-label" for="agreementCheckboxProfileCStat">Разрешить показывать другим пользователям статистику профиля</label>

      </div>
    </div>

    <button type="submit" class="defaultButton profileSetButton" name="set_privacy">Изменить</button>

  </form>
