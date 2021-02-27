let tableSize = 3,
    colors = ['#d80e0e', '#1d9439', '#0974e6', '#f7ad06', '#6d6d6d', '#3dbbf7', '#8857ff', '#f16806', '#ffb1b1'],
    colorsName = ['Красный', 'Зелёный', 'Синий', 'Жёлтый', 'Серый', 'Голубой', 'Фиолетовый', 'Оранжевый', 'Розовый'],
    tableCell = '',
    infoMsgText = '',
    errorShow = true,
    numArray = [],
    randNum = 0,
    currentNum = 0,
    findNum = 0,
    style = '',
    time = -10,
    timerId = '',
    numAmount = tableSize*tableSize;



function start_engine() {
  hideStartButton();
  deleteTable();
  initNumArray();
  createNumArray();
  timer_start ();
  createStopButton();
  createTable(tableSize);
}




function createTable(n) {
  for (var i = 0; i < n; i++) {
    console.log("Сначало Это");
    document.getElementById('tableBody').innerHTML += '<div id="tableLine'+ i +'" class="tableRow"></div>';
    for (var j = 0; j < n; j++) {
      console.log("NTGTHM ");
      name = 'tableLine' + i;
      tableCell = '<div class="tableCell" id="tableCell'+ numArray[currentNum] +'" onclick="doChoice('+ numArray[currentNum] +')" style="background-color: '+ colors[numArray[currentNum]-1] +'"></div>';
      document.getElementById(name).innerHTML +=  tableCell;
      currentNum++;
    }

  }
  getRandomNum(1, numAmount);
   findNum = randNum;
  document.getElementById('findNum').innerHTML = colorsName[findNum-1];
  name = 'tableCell' + (findNum);
  document.getElementById(name).innerHTML = '<form style="width: 100%; height: 100%;" action="" method="post"><button type="submit" id="saveTry" name="save_try"></button></form>';
}


function deleteTable() {
  if (timerId) {
    clearInterval(timerId);
  }
  document.getElementById('tableBody').innerHTML = '';
  document.getElementById('time').value = '0';
  numArray = [];
  randNum = 0;
  currentNum = 0;
  findNum = 0;
  time = -10;
  style = '';
}


function getRandomNum(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  randNum = Math.floor(Math.random() * (max - min + 1)) + min;
}

function createNumArray() {
  for (var i = 1; i < numAmount + 1; i++) {
    getRandomNum(0, numAmount-1);
    checkCell();
    numArray[randNum] = i;
  }
}


function doChoice(fN) {
  if (fN == findNum) {
    if (style == 'error') {
      document.getElementById('findNum').style = '';
    }

    outputTime();
    return;
  } else {
    document.getElementById('findNum').style = 'color:red;';
    style = 'error';
  }
}


function checkCell() {
  if (numArray[randNum] != '') {
    getRandomNum(0, numAmount-1);
    checkCell();
  }
}


function ch_table_size() {
  tableSize = Number(document.getElementById('table_size').value);
  numAmount = tableSize*tableSize;
  if ((4 <= tableSize) && (tableSize <= 100)) {
    deleteTable();
    start_engine();
  } else {
      infoMsgText = 'Ошибка: недопустимое значение размера таблицы!';
      document.getElementById('error_msg').innerHTML = '<div class="alert alert-danger" role="alert" data-type="error" data-text="' + infoMsgText +'">' + infoMsgText +'</div><script>show_note(document.querySelectorAll("[data-type][data-text]"))</script>';
  }
}

function createStartButton() {
  deleteTable();
  document.getElementById('startButton').style = '';
  document.getElementById('tableLine').style = 'display:none;';
}

function hideStartButton() {
  document.getElementById('startButton').style = 'display:none;';
  document.getElementById('tableLine').style = '';

}

function createStopButton() {
  document.getElementById('startButton').outerHTML = '<button class="defaultButton" id="startButton" onclick="stop_engine()">Отмена</button>';
}

function stop_engine() {
    deleteTable();
    document.getElementById('startButton').outerHTML = '<button class="defaultButton" id="startButton" onclick="start_engine()">Начать</button>';
    createStartButton();
}


function timer_start () {
  time = -10;
  // Создаем интервал для подсчёта времени
  timerId = setInterval(() =>
    {
      time++;

      if (time > 0) {
      document.getElementById('time').value = time;
    }
    }, 1);
  }

function outputTime() {
  // Удаляем интервал и убираем выделенное слово
  clearInterval(timerId);
  document.getElementById('currentTime').value = time;
}

function initNumArray() {
  for (var i = 0; i < numAmount; i++) {
    numArray[i] = '';
  }
}
