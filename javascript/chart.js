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
  });
}

function createWarning(id, title) {
  const article = document.querySelector(id);
  article.innerHTML = '';

  const titleElement = document.createElement('h3');
  titleElement.textContent = title;

  const textElement = document.createElement('h4');
  textElement.textContent = 'No tickets yet';
  textElement.classList.add('center', 'warning', 'no-background');

  const imgElement = document.createElement('img');
  imgElement.classList.add('no-tickets', 'center', 'no-background');
  imgElement.src = '../images/icons/warning.png';

  article.appendChild(titleElement);
  article.appendChild(imgElement);
  article.appendChild(textElement);
}

async function showDeptStatus() {
  const response = await fetch('../api/api_stats.php?' + encodeForAjax({ department: category.textContent,  field: 'status' }))
  const statuses = await response.json()
  const ctx = document.querySelector('#dept-status')
  const labels = statuses.map(status => status[0])
  const data = statuses.map(count => count[1])
  const colors = ["#D66AE6","#FF5757","#5271FF","#FFBD59","#7ED957","#F44336","#E91E63","#9C27B0","#673AB7","#3F51B5","#2196F3","#03A9F4","#00BCD4","#009688","#4CAF50","#8BC34A","#CDDC39","#FFEB3B","#FFC107","#FF9800","#FF5722"]

  if (statuses.length == 0) {
    createWarning('#dept-ticket-status', 'Tickets by status');
  } else {
    generateChart(ctx, labels, data, 'bar', colors, 'white', 0)
  }

}

async function showDeptPriority() {
  const response = await fetch('../api/api_stats.php?' + encodeForAjax({ department: category.textContent, field: 'priority' }))
  const priorities = await response.json()
  const ctx = document.querySelector('#dept-priority')
  const labels = priorities.map(priority => priority[0])
  const data = priorities.map(count => count[1])

  if (priorities.length == 0) {
    createWarning('#dept-ticket-priority', 'Tickets by priority');
  } else {
    generateChart(ctx, labels, data, 'bar', ['#D66AE6', '#FF5757', '#5271FF', '#FFBD59', '#7ED957'], 'white', 0)
  }
}

async function showUserStats() {
  const userId = document.querySelector('#profile').getAttribute('data-id')
  const response = await fetch('../api/api_stats.php?' + encodeForAjax({userId : userId}));
  const tickets = await response.json();
  const ctx = document.querySelector('#user-tkt');
  const labels = tickets.map(day => day[0]);
  const data = tickets.map(count => count[1]);

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

  generateChart(ctx, labels, data, 'bar', 'rgba(68,196,217, 0.5)', 'rgba(68,196,217,1)', 1);
}

async function showTicketCounts() {
  const response = await fetch('../api/api_stats.php?' + encodeForAjax({field: 'date'}));
  const tickets = await response.json();

  const ctx = document.querySelector('#ticket-counts');
  const labels = tickets.map(day => day[0]);
  const data = tickets.map(count => count[1]);

  generateChart(ctx, labels, data, 'line', 'rgba(68,196,217, 0.5)', 'rgba(68,196,217,1)', 3);
}

async function showTicketDept() {
  const response = await fetch('../api/api_stats.php?' + encodeForAjax({field: 'category'}));
  const tickets = await response.json();

  const ctx = document.querySelector('#all-tkt-dept');
  const labels = tickets.map(day => day[0]);
  const data = tickets.map(count => count[1]);
  const colors = ["#D66AE6","#FF5757","#5271FF","#FFBD59","#7ED957","#F44336","#E91E63","#9C27B0","#673AB7","#3F51B5","#2196F3","#03A9F4","#00BCD4","#009688","#4CAF50","#8BC34A","#CDDC39","#FFEB3B","#FFC107","#FF9800","#FF5722"]

  generateChart(ctx, labels, data, 'doughnut', colors, 'white', 0)
}

async function showTicketStatus() {
  const response = await fetch('../api/api_stats.php?' + encodeForAjax({field: 'status'}));
  const tickets = await response.json();

  const ctx = document.querySelector('#all-tkt-status');
  const labels = tickets.map(day => day[0]);
  const data = tickets.map(count => count[1]);

  const colors = ["#D66AE6","#FF5757","#5271FF","#FFBD59","#7ED957","#F44336","#E91E63","#9C27B0","#673AB7","#3F51B5","#2196F3","#03A9F4","#00BCD4","#009688","#4CAF50","#8BC34A","#CDDC39","#FFEB3B","#FFC107","#FF9800","#FF5722"]
  generateChart(ctx, labels, data, 'doughnut', colors, 'white', 0)
}

async function showTicketPriority() {
  const response = await fetch('../api/api_stats.php?' + encodeForAjax({field: 'priority'}));
  const tickets = await response.json();

  const ctx = document.querySelector('#all-tkt-priority');
  const labels = tickets.map(day => day[0]);
  const data = tickets.map(count => count[1]);

  generateChart(ctx, labels, data, 'doughnut', ['#D66AE6', '#FF5757', '#5271FF', '#FFBD59', '#7ED957'], 'white', 0)
}


const category = document.querySelector('#department-title')
if (category) {
  showDeptStatus()
  showDeptPriority()
}

const user_ticket_stats = document.querySelector('#ticket-stats');
if (user_ticket_stats) {
  showUserStats()
}

const reports = document.querySelector('#reports');
if (reports) {
  showTicketCounts()
  showTicketDept()
  showTicketStatus()
  showTicketPriority()
}