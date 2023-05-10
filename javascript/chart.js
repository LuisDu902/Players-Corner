async function getStatus() {
  const response = await fetch('../api/api_dept_status_stats.php?' + encodeForAjax({ department: category.textContent }))
  const statuses = await response.json()
  const ctx = document.querySelector('#dept-status')
  const labels = statuses.map(status => status[0])
  const data = statuses.map(status => status[1])

  if (statuses.length == 0){
    const article = document.querySelector('#dept-ticket-status')
    article.innerHTML = ''
    
    const title = document.createElement('h3')
    title.textContent = 'Tickets by status'
    
    const text = document.createElement('h4')
    text.textContent = 'No tickets yet'
    text.classList.add('center', 'warning', 'no-background')

    const img = document.createElement('img')
    img.classList.add('no-tickets', 'center', 'no-background')
    img.src = '../images/icons/warning.png'
    
    article.appendChild(title)
    article.appendChild(img)
    article.appendChild(text)
  }

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
  const response = await fetch('../api/api_dept_priority_stats.php?' + encodeForAjax({ department: category.textContent }))
  const priorities = await response.json()
  const ctx = document.querySelector('#dept-priority')
  const labels = priorities.map(priority => priority[0])
  const data = priorities.map(priority => priority[1])

  if (priorities.length == 0){
    const article = document.querySelector('#dept-ticket-priority')
    
    article.innerHTML = ''
    
    const title = document.createElement('h3')
    title.textContent = 'Tickets by priority'
    
    const text = document.createElement('h4')
    text.textContent = 'No tickets yet'
    text.classList.add('center', 'warning', 'no-background')

    const img = document.createElement('img')
    img.classList.add('no-tickets', 'center', 'no-background')
    img.src = '../images/icons/warning.png'
    
    article.appendChild(title)
    article.appendChild(img)
    article.appendChild(text)
   
  }
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
 
  if (tickets.length === 0) {
    user_ticket_stats.innerHTML = ''
    
    const text = document.createElement('h3')
    text.textContent = 'No tickets yet'
    const img = document.createElement('img')
    img.classList.add('no-tickets', 'no-background')
    img.src = '../images/icons/warning.png'
   
    user_ticket_stats.appendChild(img)
    user_ticket_stats.appendChild(text)
    return;
  }

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


const user_ticket_stats = document.querySelector('#ticket-stats');
if (user_ticket_stats){
  show_ticket_stats()
}