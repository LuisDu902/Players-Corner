function generateChart(ctx, labels, data, chartType, backgroundColor, borderColor, borderWidth) {
  new Chart(ctx, {
    type: chartType,
    data: {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: backgroundColor,
        borderColor: borderColor,
        borderWidth: borderWidth,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          display: chartType !== 'doughnut',
          ticks: {
            stepSize: 1,
            fontColor: 'white'
          }
        }
      },
      plugins: {
        legend: false
      }
    }
  })
}

function createWarning(id, title) {
  const article = document.querySelector(id)
  article.innerHTML = ''

  const titleElement = document.createElement('h3')
  titleElement.textContent = title

  const textElement = document.createElement('h4')
  textElement.textContent = 'No tickets yet'
  textElement.classList.add('center', 'warning', 'no-background')

  const imgElement = document.createElement('img')
  imgElement.classList.add('no-tickets', 'center', 'no-background')
  imgElement.src = '../images/icons/warning.png'

  article.appendChild(titleElement)
  article.appendChild(imgElement)
  article.appendChild(textElement)
}

async function fetchDataAndGenerateChart(endpoint, categorySelector, chartSelector, colors, title) {
  const response = await fetch(endpoint)
  const data = await response.json()
  console.log(data)
  const ctx = document.querySelector(chartSelector)
  const labels = data.map(item => item[0])
  const countData = data.map(item => item[1])

  if (data.length == 0) {
    createWarning(categorySelector, title)
  } else {
    generateChart(ctx, labels, countData, 'bar', colors, 'white', 0)
  }
}