
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

  const response = await fetch('../api/api_search_tickets.php?' + encodeForAjax({search: searchTicket.value}) + "&" + encodeForAjax({filter: ticketFilterSelect.value}) + "&" + encodeForAjax({order: ticketOrderSelect.value}))

  const tickets = await response.json()

  const section = document.querySelector('.tickets tbody')
  section.innerHTML = ''

  for (const ticket of tickets) {
    const ticketCard = createTicketCard(ticket)
    section.appendChild(ticketCard)
  }

}

function createTicketCard(ticket) {

  const ticketRow = document.createElement('tr');
  ticketRow.classList.add('ticket', 'white-border', 'round-border', 'center');

  const creatorCell = document.createElement('td');
  const creatorImg = document.createElement('img');
  if (ticket.creator.hasPhoto) {
    creatorImg.src = '../images/users/user' + ticket.creator.userId + '.png'
  } else{
    creatorImg.src = '../images/users/default.png'
  }
  creatorImg.classList.add(ticket.creator.type + '-card-border', 'circle-border');
  creatorCell.appendChild(creatorImg);
  ticketRow.appendChild(creatorCell);

  const titleCell = document.createElement('td');
  const titleLink = document.createElement('a');
  titleLink.href = '../pages/ticket.php?id=' + ticket.ticketId;
  titleLink.textContent = ticket.title;
  titleCell.appendChild(titleLink);
  ticketRow.appendChild(titleCell);

  const tagsCell = document.createElement('td');
  tagsCell.classList.add('vert-flex')
  for (const tag of ticket.tags) {
    const tagSpan = document.createElement('span');
    tagSpan.textContent = tag;
    tagsCell.appendChild(tagSpan);
  }
  ticketRow.appendChild(tagsCell);

  const categoryCell = document.createElement('td');
  categoryCell.textContent = ticket.category;
  ticketRow.appendChild(categoryCell);

  const statusCell = document.createElement('td');
  statusCell.textContent = ticket.status;
  statusCell.classList.add('round-border', 'status');
  statusCell.id = ticket.status + '-status';
  ticketRow.appendChild(statusCell);

  const priorityCell = document.createElement('td');
  priorityCell.textContent = ticket.priority;
  priorityCell.id = ticket.priority + '-priority';
  ticketRow.appendChild(priorityCell);

  const visibilityCell = document.createElement('td');
  visibilityCell.textContent = ticket.visibility;
  ticketRow.appendChild(visibilityCell);

  const dateCell = document.createElement('td');
  dateCell.textContent = ticket.date;
  ticketRow.appendChild(dateCell);

  return ticketRow
}
