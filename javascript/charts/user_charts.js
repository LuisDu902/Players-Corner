async function showUserStats() {
  const userId = document.querySelector('#profile').getAttribute('data-id')
  const response = await fetch('../api/api_stats.php?' + encodeForAjax({userId : userId}))
  const tickets = await response.json()
  const ctx = document.querySelector('#user-tkt')
  const labels = tickets.map(day => day[0])
  const data = tickets.map(count => count[1])

  if (tickets.length === 0) {
    user_ticket_stats.innerHTML = ''

    const text = document.createElement('h3')
    text.textContent = 'No tickets yet'
    const img = document.createElement('img')
    img.classList.add('no-tickets', 'no-background')
    img.src = '../images/icons/warning.png'

    user_ticket_stats.appendChild(img)
    user_ticket_stats.appendChild(text)
    return
  }

  generateChart(ctx, labels, data, 'bar', 'rgba(68,196,217, 0.5)', 'rgba(68,196,217,1)', 1)
}

const user_ticket_stats = document.querySelector('#ticket-stats')
if (user_ticket_stats) {
  showUserStats()
}
