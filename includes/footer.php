<footer>
  <div id="footer">
    <div class="container">
      <div class="row">

        <div class="col-md-10 col-lg-10 col-sm-12">

          <p>© <?php echo $config['SITE_DATE']; ?> <a class="defaultLink" href="/"><?php echo $config['SITE_NAME']; ?></a> За копирование информации пишу в прокуратуру</p>

          <p><?php echo '<a class="defaultLink" href="mailto:'.$config['SITE_EMAIL'].'">'.$config['SITE_EMAIL'].'</a>'; ?></p>

          <p><?php echo $config['SITE_CONTACTS']; ?></p>

        </div>

        <div class="col-md-2 col-lg-2 col-sm-12 desc">

          <p><?php echo $config['SITE_COUNTER']; ?></p>

        </div>

      </div>
    </div>
  </div>

  <?php
   // Подключаем сookie уведомления
   require "./includes/cookie_informer.php";
  ?>

</footer>
