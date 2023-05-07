async function getStatus() {
  const category = document.querySelector('#department-title').textContent
  const response = await fetch('../api/api_get_status.php?' + encodeForAjax({ department: category }))
  const statuses = await response.json()
  const ctx = document.querySelector('#dpt-status')
  const labels = statuses.map(status => status[0])
  const data = statuses.map(status => status[1])

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        data: data,
        backgroundColor: ['#D66AE6', '#FF5757', '#5271FF', '#FFBD59', '#7ED957'],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          ticks: {
            stepSize: 1
          }
        }
      },
      plugins: {
        legend: false 
      },
    }
  });

}

async function getPriority() {
  const category = document.querySelector('#department-title').textContent
  const response = await fetch('../api/api_get_priority.php?' + encodeForAjax({ department: category }))
  const priorities = await response.json()
  const ctx = document.querySelector('#dpt-priority')
  const labels = priorities.map(status => status[0])
  const data = priorities.map(status => status[1])

  new Chart(ctx, {
    type: 'bar',

    data: {
      labels: labels,
      datasets: [{
        
        data: data,
        backgroundColor: ['#FF5757', '#FF5757', '#FFBD59', '#7ED957'],
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          ticks: {
            stepSize: 1,
            fontColor: 'white'
          }
        }
      },
      plugins: {
        legend: false 
      },
    }
  });

}

getStatus()
getPriority()