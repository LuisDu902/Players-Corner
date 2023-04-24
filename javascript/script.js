
const filterSelect = document.querySelector('#filter-select')
const orderSelect = document.querySelector('#order-select')
const searchUser = document.querySelector('#search-user')

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

function createUserCard(user) {
  const userCard = document.createElement('div')
  userCard.classList.add('user-card')

  userCard.appendChild(createCardType(user))
  userCard.appendChild(createImage(user))
  userCard.appendChild(createCardDetails(user))
  userCard.appendChild(createButtons(user))

  return userCard
}

function createCardType(user) {
  const cardType = document.createElement('div')
  cardType.classList.add('card-type')

  const typeSpan = document.createElement('span')
  typeSpan.classList.add('type', user.type + '-card-type')
  typeSpan.textContent = user.type
  cardType.appendChild(typeSpan)

  const repSpan = document.createElement('span')
  repSpan.classList.add('rep')
  repSpan.textContent = user.reputation
  cardType.appendChild(repSpan)

  return cardType
}

function createImage(user) {
  const img = document.createElement('img')
  img.src = '../images/users/user' + user.userId + '.png'
  img.onerror = () => { img.src = '../images/users/default.png' }
  img.classList.add(user.type + '-card-border')
  return img
}

function createCardDetails(user) {
  const cardDetails = document.createElement('div')
  cardDetails.classList.add('card-details')

  const cardName = document.createElement('span')
  cardName.classList.add('card-name')
  cardName.textContent = user.name
  cardDetails.appendChild(cardName)

  const username = document.createElement('span')
  username.textContent = user.username
  cardDetails.appendChild(username)

  return cardDetails
}

function createButtons(user) {
  if (user.type === "client") {
    return createClientButtons()
  }
  else if (user.type === "agent") {
    return createAgentButtons()
  }
  else if (user.type === "admin") {
    return createAdminButtons()
  }
}

function createClientButtons() {

  const buttons = document.createElement('div')
  buttons.classList.add('card-button')

  const buttonWrap = document.createElement('div')
  buttonWrap.classList.add('button-wrap')

  const upgradeButton = document.createElement('button')
  upgradeButton.classList.add('upgrade')
  upgradeButton.textContent = 'upgrade'

  buttonWrap.appendChild(upgradeButton)
  buttons.appendChild(buttonWrap)

  return buttons
}

function createAgentButtons() {

  const buttons = document.createElement('div')
  buttons.classList.add('card-button')

  const buttonWrap = document.createElement('div')
  buttonWrap.classList.add('button-wrap')
  buttonWrap.classList.add('two-button-wrap')

  const upgradeButton = document.createElement('button')
  upgradeButton.classList.add('upgrade')
  upgradeButton.textContent = 'upgrade'

  buttonWrap.appendChild(upgradeButton)
  buttons.appendChild(buttonWrap)

  const buttonWrap1 = document.createElement('div')
  buttonWrap1.classList.add('button-wrap')
  buttonWrap1.classList.add('two-button-wrap')

  const link = document.createElement('a')
  link.href = "../pages/assign_departments.php"

  const assignButton = document.createElement('button')
  assignButton.classList.add('assign')
  assignButton.textContent = 'assign'

  link.appendChild(assignButton)
  buttonWrap1.appendChild(link)
  buttons.appendChild(buttonWrap1)

  return buttons
}

function createAdminButtons() {

  const buttons = document.createElement('div')
  buttons.classList.add('card-button')

  const buttonWrap = document.createElement('div')
  buttonWrap.classList.add('button-wrap')

  const link = document.createElement('a')
  link.href = "../pages/assign_departments.php"

  const assignButton = document.createElement('button')
  assignButton.classList.add('assign')
  assignButton.textContent = 'assign'

  link.appendChild(assignButton)
  buttonWrap.appendChild(link)
  buttons.appendChild(buttonWrap)


  return buttons
}

function createModal(user) {
  const button = document.createElement('div')
  button.classList.add('card-button')

  const buttonWrap = document.createElement('div')
  buttonWrap.classList.add('button-wrap')


  const upgradeButton = document.createElement('button')
  upgradeButton.classList.add('upgrade')
  upgradeButton.textContent = 'upgrade'
  buttonWrap.appendChild(upgradeButton)
  button.append(buttonWrap)
  return button
}

