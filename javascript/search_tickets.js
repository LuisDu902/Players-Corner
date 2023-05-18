
const ticketFilterSelect = document.querySelector('#filter-ticket')
const ticketOrderSelect = document.querySelector('#order-ticket')
const searchTicket = document.querySelector('#search-ticket')
const tickets = document.querySelector('.tickets')
const departmentPage = document.querySelector('.department')
const pagination_element = document.querySelector('.pagination-bar');

if (tickets) {
  if (searchTicket) {
    searchTickets(searchTicket.value, ticketFilterSelect.value, ticketOrderSelect.value);
    searchTicket.addEventListener('input', function () {
      searchTickets(searchTicket.value, ticketFilterSelect.value, ticketOrderSelect.value);
    });
    ticketFilterSelect.addEventListener('change', function () {
      searchTickets(searchTicket.value, ticketFilterSelect.value, ticketOrderSelect.value);
    });
    ticketOrderSelect.addEventListener('change', function () {
      searchTickets(searchTicket.value, ticketFilterSelect.value, ticketOrderSelect.value);
    });
  }
  else if (departmentPage){
    const category = document.querySelector('#department-title')
    searchTickets(category.textContent, 'category', 'title');
  }
}

async function searchTickets(searchValue, filterValue, orderValue) {
  const response = await fetch('../api/api_search_tickets.php?' + encodeForAjax({ search: searchValue , filter: filterValue , order: orderValue }))
  const tickets = await response.json()
  current_page = 1
  displayTickets(tickets, current_page)
  setupPagination(tickets, pagination_element)
}

function displayTickets(tickets, page) {
  console.log(page)
  page--;
  let start = 5 * page;
  let end = start + 5;
  let paginatedItems = tickets.slice(start, end);
  console.log(paginatedItems)
  const section = document.querySelector('.tickets tbody')
  section.innerHTML = ''

  for (const ticket of paginatedItems) {
    const ticketCard = createTicketCard(ticket)
    section.appendChild(ticketCard)
  }
}

function setupPagination(items, wrapper) {
  wrapper.innerHTML = "";

  let page_count = Math.ceil(items.length / 5);
  for (let i = 1; i < page_count + 1; i++) {
    let btn = paginationButton(i, items);
    wrapper.appendChild(btn);
  }
}

function paginationButton(page, items) {
  let button = document.createElement('button');
  button.innerText = page;
  button.classList.add('no-background')
  if (current_page == page) button.classList.add('active');

  button.addEventListener('click', function () {
    current_page = page;
    displayTickets(items, page)

    let current_btn = document.querySelector('.pagination-bar button.active');
    current_btn.classList.remove('active');

    button.classList.add('active');
  });

  return button;
}

function createTicketCard(ticket) {

  const ticketRow = document.createElement('tr');
  ticketRow.classList.add('ticket', 'white-border', 'round-border', 'center');

  const creatorCell = document.createElement('td');
  const creatorImg = document.createElement('img');
  if (ticket.creator.hasPhoto) {
    creatorImg.src = '../images/users/user' + ticket.creator.userId + '.png'
  } else {
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