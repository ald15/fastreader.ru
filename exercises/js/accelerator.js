let str = '',
    timerId = '',
    speed = 0,
    i = 0,
    a = [],
    b = [],
    errorMsg = '',
    errorShow = true;
    defaultsaveButtonArea = '',
    defaultButton = '',
    saveButton = '',
    stopButton = '',
    showSave = true,
    font = '';


function start_engine () {
  // Если кнопка "Добавить" была показана, то удаляем ее
  if (!showSave) {
    delete_save();
  } else {
    // Т.к. кнопка "Добавить" не была показана, то сохряняем стандартную кнопку
    defaultsaveButtonArea = document.getElementById('saveButtonArea').outerHTML;
  }


  // Если сообщение об ошибке было показано, то удаляем его
  if (!errorShow) {
    errorMsg = '<p id="error_msg"></p>';
    document.getElementById('error_msg').outerHTML = errorMsg;
  }

  // Ищем слова
  find_Words();
  // Устанавливаем скорость чтения (т.е. интервал через который будут подсвечиваться слова)
  set_Speed();
  // Создаём стоп кнопку
  create_stop_button();
  // Запускаем бегущее слово
  run_Word();
  }


function find_Words () {
  // Считываем текст со страницы
   str = document.getElementsByClassName('text')[0].innerText;
   // Разбиваем текст на слова, сохраняем в массиве
   a = str.split(' ');
   // Делаем резервную копию массива слов в другой массив
   b = str.split(' ');
}


function run_Word() {
  i = 0,
  curentWord = '',
  modWord = '';

// Если допустимое значение скорости, то продолжаем
if (speed != -1) {
  // Создаём интервал
  timerId = setInterval(() =>
  {
    // Если не первое слово,  то удаляем выделение предыдущего слова
    if (i > 0){
      a[i-1] = b[i-1];
    }
    // Если последнее слово, то удаляем интервал
    if (i == a.length ) {stop_engine();}
    else{
    // Выбираем текущее слово
    curentWord = a[i];
    // "Выделяем" слово
    modWord = '<span id="amark">' + curentWord + '</span>';
    // Загружаем модифицированное слово
    a[i] = modWord;
    // Создаем текст из слов массива
    str = a.join(' ');
    // Выводим текст
    document.getElementsByClassName('text')[0].innerHTML = str;
    i+=1;
  }
}, speed);
} else {
  // Создаём сообщение об ошибке
  errorMsg = '<div class="alert alert-danger" role="alert" data-type="error" id="error_msg" data-text="Ошибка: недопустимое значение скорости чтения!">Ошибка: недопустимое значение скорости чтения!</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
  // Выводим сообщение об ошибке
  document.getElementById('error_msg').outerHTML = errorMsg;
  errorShow = false;
  return;
  }
}


function set_Speed () {
  // Считываем скорость чтения со страницы
  speed = Number(document.getElementById('speed').value);
  // Вычисляем врямя для интервала в мс, если скорость больше нуля
  if (speed > 0) {
    speed = Math.round((60 / speed) * 1000);
  } else {
    speed = -1;
  }
}


function show_save() {
  // Показываем кнопку "Добавить"
  saveButton = '<p><div id="saveButtonArea" ><p>Добавить эту попытку к статистике количества выполненных упражнений?</p><button type="submit" class="defaultButton" id="saveTry" name="save_try">Добавить</button></div></p>';
  document.getElementById('saveButtonArea').outerHTML = saveButton;
  showSave = false;

}


function delete_save() {
  console.log('Удалил!');
  showSave = true;
  document.getElementById('saveButtonArea').outerHTML = defaultsaveButtonArea;
}


function create_stop_button () {
  // Т.к. недопустимое значение скорости, то не создаем "Стоп" кнопку
  if (speed != -1) {
    // Делаем резервную копию старт кнопки
    defaultButton = document.getElementById('startButton').outerHTML;
    // Создаём стоп кнопку
    stopButton = '<button  class="defaultButton" id="stopButton" style="padding: 0 1em;" onclick="stop_engine()">Стоп</button>';
    // Выводим стоп кнопку
    document.getElementById('startButton').outerHTML = stopButton;
  }
}


function create_start_button () {
  // Выводим старт кнопку
  document.getElementById('stopButton').outerHTML = defaultButton;
}


function stop_engine () {
  // Удаляем интервал и убираем выделенное слово
  clearInterval(timerId); a[i-1] = b[i-1]; str = a.join(' '); document.getElementsByClassName('text')[0].innerHTML = str;
  // Если текст был полностью прочитан, то выводим кнопку "Добавить"
  if (i >= a.length) {
    show_save();
  }
  // Создаем старт кнопку
  create_start_button ();
}


function ch_font_size () {
  // Cчитываем размер шрифта
  font = Number(document.getElementById('font_size').value);
  // Защита от маленького размера шрифта
  if (font >= 16) {
    document.getElementsByClassName('text')[0].style = 'font-size: ' + font + 'px;';
  }
}
