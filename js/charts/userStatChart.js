// График статистики количества выполнений упражнений

let
 		colorsuserStatChart =
			{
				red: 'rgb(255, 99, 132)',
				orange: 'rgb(255, 159, 64)',
				yellow: 'rgb(255, 205, 86)',
				green: 'rgb(75, 192, 192)',
				blue: 'rgb(54, 162, 235)',
				purple: 'rgb(153, 102, 255)',
				grey: 'rgb(201, 203, 207)'
			},
		// Считываем из поля названия упражнений
    exNames = document.getElementById('exNames').value.split(' '),
    // Считываем из поля статистику по упражнениям
		exStat = document.getElementById('exStat').value.split(' '),
    // Получаем область для графика
    userSpeedChart = document.getElementById("userSpeedChart").getContext('2d');
		// Удаляем пустой 0 элемент
		exStat.shift();
		// Если названия упражнений состоят из нескольких слов то убираем _
		for (let i = 0; i < exNames.length; i++) {
			exNames[i] = exNames[i].replace( /_/g, " ");
		}
		// Создаем Bar график
let		myBarChart = new Chart(userStatChart,
			{
				type: 'horizontalBar',
				data:
					{
						labels: exNames,
						datasets:
							[{
								data: exStat,
								backgroundColor:
									[
										colorsuserStatChart.red,
										colorsuserStatChart.orange,
										colorsuserStatChart.yellow,
										colorsuserStatChart.green,
										colorsuserStatChart.blue,
										colorsuserStatChart.purple,
										colorsuserStatChart.red
									],
								borderColor: colorsuserStatChart.red
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
