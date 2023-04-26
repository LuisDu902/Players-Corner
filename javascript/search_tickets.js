
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

  const section = document.querySelector('#ticket-cards')
  section.innerHTML = ''

  for (const ticket of tickets){
    const ticketCard = createTicketCard(ticket)
    section.appendChild(ticketCard)
  }

}

function createTicketCard(ticket){
  const link = document.createElement('a')
  link.href = "../pages/ticket.php?id=" + ticket.ticketId
  link.classList.add('ticket')

  const creator = document.createElement('img')
  creator.src = ticket
  creator.src = '../images/users/user' + ticket.creator.userId + '.png'
  creator.onerror = () => { creator.src = '../images/users/default.png' }
  creator.classList.add(ticket.creator.type + '-card-border')

  const title = document.createElement('span')
  title.textContent = ticket.title

  const tags = document.createElement('div')
  tags.classList.add('ticket-tags')
  for (const tag of ticket.tags){
    const hashtag = document.createElement('span')
    hashtag.textContent = '#' + tag
    tags.appendChild(hashtag)
  }

  const category = document.createElement('span')
  category.textContent = ticket.category

  const status = document.createElement('span')
  status.textContent = ticket.status
  status.classList.add('status')
  status.id = ticket.status + "-status"

  const priority = document.createElement('span')
  priority.textContent = ticket.priority
  priority.classList.add('priority')
  priority.id = ticket.priority + "-priority"

  const visibility = document.createElement('span')
  visibility.textContent = ticket.visibility

  const date = document.createElement('span')
  date.textContent = ticket.date

  link.appendChild(creator)
  link.appendChild(title)
  link.appendChild(tags)
  link.appendChild(category)
  link.appendChild(status)
  link.appendChild(priority)
  link.appendChild(visibility)
  link.appendChild(date)

  return link
}
