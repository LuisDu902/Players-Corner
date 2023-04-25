
const ticketFilterSelect = document.querySelector('#filter-ticket')
const ticketOrderSelect = document.querySelector('#order-ticket')
const searchTicket = document.querySelector('#search-ticket')

if (searchTicket) {
  searchTicket.addEventListener('input', searchTickets)
}
if (ticketFilterSelect) {
  ticketFilterSelect.addEventListener('change', searchTickets)
}
if (ticketOrderSelect) {
  ticketOrderSelect.addEventListener('change', searchTickets)
}

async function searchTickets() {
  const response = await fetch('../api/api_search_tickets.php?search=' + searchTicket.value + '&filter=' + ticketFilterSelect.value + '&order=' + ticketOrderSelect.value)
  const tickets = await response.json()

  const section = document.querySelector('#tickets')
  section.innerHTML = '<h1>JSAJKLDAJSL</h1>'
}
