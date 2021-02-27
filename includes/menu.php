<?php require "./includes/preloader.php"; ?>

<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">

  <a class="navbar-brand"  id="siteLogo" href="/">

    <img src="<?php echo $config['SITE_LOGO']; ?>" width="250vw" height="55vh" class="d-inline-block align-top" alt="Fast Reader"></a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">

      <a class="nav-item nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="/#about">О сайте</a>

      <?php
        // Если пользователь авторизован, то показывать ему пользовательское меню
        if(isset($_SESSION['logged_user'])) {
      ?>

        <a class="nav-item nav-link" href="/exercises.php">Упражнения</a>
        <a class="nav-item nav-link" id="profile" href="/profile.php">
        <img src="./img/avatars/<?php echo $_SESSION['logged_user']['avatar']; ?>" class="d-inline-block align-top" alt="Профиль"></a>

        <form action=""  method="post">
          <button type="submit" class="nav-item nav-link login" name="do_outlogin">Выйти</button>
        </form>

      <?php
        } else
          {
          // Если пользователь не авторизован, то показать ему гостевое меню
      ?>
        <a class="nav-item nav-link" href="/#exercises">Упражнения</a>
        <a class="nav-item nav-link" href="/#registration">Регистрация</a>
        <a class="nav-item nav-link login" href="#" data-toggle="modal" data-target="#staticBackdrop">Вход</a>

      <?php
        }


        // Дописать меню администратора!!!


      ?>

    </div>
  </div>

</nav>
