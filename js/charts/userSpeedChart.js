// График скорости чтения пользователя

let
    // Цвета графика
    colorsUserSpeedChart = ['#ff6800'];
    // Считываем из поля скорости
    monthlySpeedValue = document.getElementById('monthlySpeedValue').value.split(' '),
    // Считываем из поля даты замеров скоростей
    monthlySpeedDate = document.getElementById('monthlySpeedDate').value.split(' '),
    // Получаем область для графика
    userSpeedChart = document.getElementById("userSpeedChart").getContext('2d'),
    // Создаем Line график
    myLineChart = new Chart(userSpeedChart,
      {
        type: 'line',
        data:
          {
            labels: monthlySpeedDate,
            datasets:
              [{
                data: monthlySpeedValue,
                borderColor: colorsUserSpeedChart[0],
                backgroundColor: 'transparent',
                pointBackgroundColor: colorsUserSpeedChart[0],
                borderWidth: 1
              }]
          },
        options:
          {
            legend:
              {
                display: false
              }
          }
      });
