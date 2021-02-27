<div class="exercises" id="exercises">
  <div class="container">

    <h1 class="text-center">Упражнения</h1>

    <div class="row">
      <?php
      // Подключаемся к БД, чтобы запросить 6 самых популярных по просмотрам упражнений
      $exercisesOutput = mysqli_query($connection, "SELECT * FROM `exercises` ORDER BY `views` DESC LIMIT 6" );
      ?>

      <?php
        // Получаем данные об упражнениях, пока они существуют в нашем запросе
        while (($exercisesOutputResult = mysqli_fetch_assoc($exercisesOutput))) {
      ?>

      <div class="col-md-4 col-lg-4 col-sm-12">
        <div class="card">

          <div class="card-img">

            <a href="/exercise.php?id=<?php echo $exercisesOutputResult['id']; ?>" class="card-link">

              <img src="/img/exercises/<?php echo $exercisesOutputResult['image']; ?>" class="img-fluid">

            </a>

          </div>

          <div class="card-body">

            <a href="/exercise.php?id=<?php echo $exercisesOutputResult['id']; ?>" class="card-link">

              <h4 class="card-title"><?php echo $exercisesOutputResult['title']; ?></h4>

            </a>

            <p class="card-text"><?php echo $exercisesOutputResult['s_description'].'...'; ?></p>

          </div>

          <div class="card-footer">

            <a href="/exercise.php?id=<?php echo $exercisesOutputResult['id']; ?>" class="card-link">Подробнее</a>

          </div>

        </div>
      </div>

      <?php
        }
      ?>

    </div>

  </div>
</div>
