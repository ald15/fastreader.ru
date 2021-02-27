<?php

// Модуль подсчёта опыта

// Получаем данные текущем количестве опыта пользователя
$userXpAmount = $_SESSION['logged_user']['xp'];
// Получаем данные текущем уровне пользователя
$userLevelAmount = $_SESSION['logged_user']['level'];
// Вычисляем относительного текущего уровня опыт, который нужно набрать для перехода на следующий уровень
$userXpLevel = round(pow((10 * $userLevelAmount) , 1.7));
// Вычисляем количество опыта на уровне, которое пользователь может получить за выполнение 1-го упражнения
$userXpExercise = round(5 * pow((10 * $userLevelAmount) , 0.4));
// Добавляем пользователю опыта
$userXpAmount += $userXpExercise;
// Если количество опыта у пользователя больше, чем количество требуемое для перехода на следующий уровень, то добавляем 1-н уровень
if ($userXpAmount >= $userXpLevel)
  {
    $userXpAmount -= $userXpLevel;
    $userLevelAmount += 1;
  }

// Если пользователь не принадлежит группе администрирования
if ($_SESSION['logged_user']['admin'] < 1)
  {
    // Получаем текущее звание пользователя
    $currentRank = $_SESSION['logged_user']['rank'];
    // Если уровень пользователя 1, то его звание "Новичок", аналогично для остальных
    if ($userLevelAmount == 1)
      {
        $newRank = 'Новичок';
        if ($currentRank != $newRank)
          {
            $_SESSION['logged_user']['rank'] = $newRank;
          }
      } elseif ($userLevelAmount == 2)
        {
          $newRank = 'Ученик';
          if ($currentRank != $newRank)
            {
              $_SESSION['logged_user']['rank'] = $newRank;
            }
        } elseif ($userLevelAmount == 4)
          {
            $newRank = 'Читатель';
            if ($currentRank != $newRank)
              {
                $_SESSION['logged_user']['rank'] = $newRank;
              }
          } elseif ($userLevelAmount == 7)
            {
              $newRank = 'Знаток';
              if ($currentRank != $newRank)
                {
                  $_SESSION['logged_user']['rank'] = $newRank;
                }
            } elseif ($userLevelAmount == 10)
              {
                $newRank = 'Книжный червь';
                if ($currentRank != $newRank)
                  {
                    $_SESSION['logged_user']['rank'] = $newRank;
                  }
              } elseif ($userLevelAmount == 15)
                {
                  $newRank = 'Профи';
                  if ($currentRank != $newRank)
                    {
                      $_SESSION['logged_user']['rank'] = $newRank;
                    }
                } elseif ($userLevelAmount == 18)
                  {
                    $newRank = 'Мастер';
                    if ($currentRank != $newRank)
                      {
                        $_SESSION['logged_user']['rank'] = $newRank;
                      }
                  } elseif ($userLevelAmount == 21)
                    {
                      $newRank = 'Гуру';
                      if ($currentRank != $newRank)
                        {
                          $_SESSION['logged_user']['rank'] = $newRank;
                        }
                    } elseif ($userLevelAmount == 25)
                      {
                        $newRank = 'Мыслитель';
                        if ($currentRank != $newRank)
                          {
                            $_SESSION['logged_user']['rank'] = $newRank;
                          }
                      } elseif ($userLevelAmount == 27)
                        {
                          $newRank = 'Мудрец';
                          if ($currentRank != $newRank)
                            {
                              $_SESSION['logged_user']['rank'] = $newRank;
                            }
                        } elseif ($userLevelAmount == 35)
                          {
                            $newRank = 'Просветленный';
                            if ($currentRank != $newRank)
                              {
                                $_SESSION['logged_user']['rank'] = $newRank;
                              }
                          } elseif ($userLevelAmount == 40)
                            {
                              $newRank = 'Гений';
                              if ($currentRank != $newRank)
                                {
                                  $_SESSION['logged_user']['rank'] = $newRank;
                                }
                            } elseif ($userLevelAmount == 45)
                              {
                                $newRank = 'Робот';
                                if ($currentRank != $newRank)
                                  {
                                    $_SESSION['logged_user']['rank'] = $newRank;
                                  }
                              } elseif ($userLevelAmount == 50)
                                {
                                  $newRank = 'Искусственный интеллект';
                                  if ($currentRank != $newRank)
                                    {
                                      $_SESSION['logged_user']['rank'] = $newRank;
                                    }
                                } elseif ($userLevelAmount == 65)
                                  {
                                    $newRank = 'Высший разум';
                                    if ($currentRank != $newRank)
                                      {
                                        $_SESSION['logged_user']['rank'] = $newRank;
                                      }
                                  }
    // Если звание было изменено, то заносим в БД новое звание
    if($currentRank != $_SESSION['logged_user']['rank'])
      {
        // Вносим в БД информацию о звании пользователя
        mysqli_query($connection, "UPDATE `users` SET `rank` = '".$newRank."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");
      }
  }

// Вносим в БД информацию об уровне пользователя
mysqli_query($connection, "UPDATE `users` SET `level` = '".$userLevelAmount."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");
// Вносим в БД информацию о количестве опыта пользователя
mysqli_query($connection, "UPDATE `users` SET `xp` = '".$userXpAmount."' WHERE `login` = '".$_SESSION['logged_user']['login']."'");
// Делаем записи в сессии об уровне пользователя
$_SESSION['logged_user']['level'] = $userLevelAmount;
// Делаем записи в сессии о количестве опыта пользователя
$_SESSION['logged_user']['xp'] = $userXpAmount;

?>
