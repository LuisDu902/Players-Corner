async function showTicketCounts() {
  const response = await fetch('../../api/api_stats.php?' + encodeForAjax({ field: 'date' }))
  const tickets = await response.json()

  const ctx = document.querySelector('#ticket-counts')
  const labels = tickets.map(day => day[0])
  const data = tickets.map(count => count[1])

  generateChart(ctx, labels, data, 'line', 'rgba(68,196,217, 0.5)', 'rgba(68,196,217,1)', 3)
}

async function showTicketDept() {
  const response = await fetch('../../api/api_stats.php?' + encodeForAjax({ field: 'category' }))
  const tickets = await response.json()

  const ctx = document.querySelector('#all-tkt-dept')
  const labels = tickets.map(day => day[0])
  const data = tickets.map(count => count[1])
  const colors = ["#D66AE6", "#FF5757", "#5271FF", "#FFBD59", "#7ED957", "#F44336", "#E91E63", "#9C27B0", "#673AB7", "#3F51B5", "#2196F3", "#03A9F4", "#00BCD4", "#009688", "#4CAF50", "#8BC34A", "#CDDC39", "#FFEB3B", "#FFC107", "#FF9800", "#FF5722"]

  generateChart(ctx, labels, data, 'doughnut', colors, 'white', 0)
}

async function showTicketStatus() {
  const response = await fetch('../../api/api_stats.php?' + encodeForAjax({ field: 'status' }))
  const tickets = await response.json()

  const ctx = document.querySelector('#all-tkt-status')
  const labels = tickets.map(day => day[0])
  const data = tickets.map(count => count[1])

  const colors = ["#D66AE6", "#FF5757", "#5271FF", "#FFBD59", "#7ED957"]
  generateChart(ctx, labels, data, 'doughnut', colors, 'white', 0)
}

async function showTicketPriority() {
  const response = await fetch('../../api/api_stats.php?' + encodeForAjax({ field: 'priority' }))
  const tickets = await response.json()

  const ctx = document.querySelector('#all-tkt-priority')
  const labels = tickets.map(day => day[0])
  const data = tickets.map(count => count[1])

  generateChart(ctx, labels, data, 'doughnut', ['#D66AE6', '#FF5757', '#5271FF', '#FFBD59', '#7ED957'], 'white', 0)
}


const reports = document.querySelector('#reports')
if (reports) {
  showTicketCounts()
  showTicketDept()
  showTicketStatus()
  showTicketPriority()
}