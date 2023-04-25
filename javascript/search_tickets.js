
const ticketFilterSelect = document.querySelector('.filter-criteria')
const ticketOrderSelect = document.querySelector('#order-select')
const searchTicket = document.querySelector('#search-ticket')

if (searchUser) {
  searchUser.addEventListener('input', searchUsers)
}
if (filterSelect) {
  filterSelect.addEventListener('change', searchUsers)
}
if (orderSelect) {
  orderSelect.addEventListener('change', searchUsers)
}

async function searchUsers() {
  const response = await fetch('../api/api_search_users.php?search=' + searchUser.value + '&role=' + filterSelect.value + '&order=' + orderSelect.value)
  const users = await response.json()

  const section = document.querySelector('#users')
  section.innerHTML = ''

  for (const user of users) {
    const userCard = createUserCard(user)
    section.appendChild(userCard)
  }
}