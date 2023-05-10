async function getStatus() {
  const response = await fetch('../api/api_get_status.php?' + encodeForAjax({ department: category.textContent }))
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
  const response = await fetch('../api/api_get_priority.php?' + encodeForAjax({ department: category.textContent }))
  const priorities = await response.json()
  const ctx = document.querySelector('#dpt-priority')
  const labels = priorities.map(priority => priority[0])
  const data = priorities.map(priority => priority[1])

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

const category = document.querySelector('#department-title')
if (category) {
  getStatus()
  getPriority()
}

async function show_ticket_stats() {
  const response = await fetch('../api/api_get_user_tickets_stats.php');
  const tickets = await response.json();
  const ctx = document.querySelector('#user-tkt');
  const labels = tickets.map(day => day[0]);
  const data = tickets.map(day => day[1]);
  
  new Chart(ctx, {
    data: {
      labels: labels,
      datasets: [{
        type: 'bar',
        data: data,
        backgroundColor: 'rgba(68,196,217, 0.5)',
        barPercentage: 0.7,
        borderColor: 'rgba(68,196,217,1)',
        borderWidth: 1
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


const profile = document.querySelector('#profile');
if (profile){
  show_ticket_stats()
}