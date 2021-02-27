let str = '',
    timerId = '',
    time = 0,
    timeOutputMinutes = 0,
    timeOutputSeconds = 0,
    words_amount = 1,
    speed = 0,
    i = 0,
    a = [],
    b = [],
    errorMsg = '',
    defaultBar = '',
    defaultButton = '',
    stopButton = '',
    errorShow = false,
    font = '';


function start_engine () {
  // Создаём стоп кнопку
  create_stop_button();
  // Запускаем таймер
  timer_start();
}


function timer_start () {
  time = 0;
  // Создаем интервал для подсчёта времени
  timerId = setInterval(() =>
    {
      time++;
      timeOutputMinutes = Math.trunc((time / 60));
      timeOutputSeconds = time - (timeOutputMinutes * 60);
      document.getElementById('time').value = timeOutputMinutes + ' : ' + timeOutputSeconds;
    }, 1000);
  }


function count_speed () {
  // Считываем кол-во слов в тексте (со страницы)
  words_amount = Number(document.getElementById('words_amount').innerHTML);
  speed = Math.floor((words_amount * 60) / time);
  if (speed == Infinity) {
    speed = 0;
  }
}


function create_stop_button () {
  // Удаляем текст старт кнопки
  document.getElementById('startButton').style = 'display: none;';
  // Создаём стоп кнопку
  stopButton = '<p id="stopButtonArea" onclick="stop_engine()"><button type="submit" class="defaultButton" id="saveSpeed" name="save_speed">Стоп</button></p>';
  // Выводим стоп кнопку
  document.getElementById('stopButtonArea').outerHTML = stopButton;
}


function stop_engine () {
  // Удаляем интервал и убираем выделенное слово
  clearInterval(timerId);
  // Вычисляем скорость чтения
  count_speed();
  document.getElementById('currentSpeed').value = speed;
}


function ch_font_size () {
  // Cчитываем размер шрифта
  font = Number(document.getElementById('font_size').value);
  // Защита от маленького размера шрифта
  if (font >= 16) {
    document.getElementsByClassName('text')[0].style = 'font-size: ' + font + 'px;';
  }
}
