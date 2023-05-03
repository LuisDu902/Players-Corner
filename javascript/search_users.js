
const userFilterSelect = document.querySelector('#filter-user')
const userOrderSelect = document.querySelector('#order-user')
const searchUser = document.querySelector('#search-user')

if (searchUser) {
  searchUser.addEventListener('input', searchUsers)
}
if (userFilterSelect) {
  userFilterSelect.addEventListener('change', searchUsers)
}
if (userOrderSelect) {
  userOrderSelect.addEventListener('change', searchUsers)
}

async function searchUsers() {
  const response = await fetch('../api/api_search_users.php?' + encodeForAjax({search: searchUser.value}) + "&" + encodeForAjax({role: userFilterSelect.value}) + "&" + encodeForAjax({order: userOrderSelect.value}))
  const users = await response.json()

  const section = document.querySelector('#users')
  section.innerHTML = ''

  for (const user of users) {
    const userCard = createUserCard(user)
    section.appendChild(userCard)
  }

  showUpgradeModal()
  showAssignModal()
}

function createUserCard(user) {
  const userCard = document.createElement('div')
  userCard.classList.add('user-card')

  userCard.appendChild(createCardType(user))
  userCard.appendChild(createImage(user))
  userCard.appendChild(createCardDetails(user))
  userCard.appendChild(createButtons(user))
  userCard.appendChild(createUserId(user))
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
  img.classList.add(user.type + '-card-border')
  img.classList.add('card-img')

  if (user.hasPhoto) {
    img.src = '../images/users/user' + user.userId + '.png'
  } else{
    img.src = '../images/users/default.png'
  }
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
  username.classList.add('span-username')
  username.textContent = user.username
  cardDetails.appendChild(username)

  return cardDetails
}

function createButtons(user) {
  if (user.type === "client") {
    return createClientButtons(user)
  }
  else if (user.type === "agent") {
    return createAgentButtons(user)
  }
  else if (user.type === "admin") {
    return createAdminButtons(user)
  }

}


function createClientButtons(user) {

  const buttons = document.createElement('div')
  buttons.classList.add('card-buttons')

  const buttonWrap = document.createElement('div')
  buttonWrap.classList.add('button-wrap')

  const upgradeButton = document.createElement('button')
  upgradeButton.classList.add('upgrade')
  upgradeButton.textContent = 'upgrade'

  buttonWrap.appendChild(upgradeButton)
  buttons.appendChild(buttonWrap)

  return buttons
}

function createAgentButtons(user) {

  const buttons = document.createElement('div')
  buttons.classList.add('card-buttons')

  const buttonWrap = document.createElement('div')
  buttonWrap.classList.add('button-wrap')
  buttonWrap.classList.add('two-button-wrap')

  const upgradeButton = document.createElement('button')
  upgradeButton.classList.add('upgrade')
  upgradeButton.textContent = 'upgrade'

  buttonWrap.appendChild(upgradeButton)
  buttons.appendChild(buttonWrap)

  const wrap = document.createElement('div')
  wrap.classList.add('button-wrap')
  wrap.classList.add('two-button-wrap')

  const assignButton = document.createElement('button')
  assignButton.classList.add('assign-dep')
  assignButton.textContent = 'assign'

  wrap.appendChild(assignButton)
  buttons.appendChild(wrap)
  return buttons
}

function createAdminButtons(user) {

  const buttons = document.createElement('div')
  buttons.classList.add('card-buttons')

  const buttonWrap = document.createElement('div')
  buttonWrap.classList.add('button-wrap')

  const upgradeButton = document.createElement('button')
  upgradeButton.classList.add('assign-dep')
  upgradeButton.textContent = 'assign'

  buttonWrap.appendChild(upgradeButton)
  buttons.appendChild(buttonWrap)

  return buttons
}

function createUserId(user){
  const userId = document.createElement('input')
  userId.type = 'hidden'
  userId.value = user.userId
  userId.id = 'card-userId'
  return userId
}


const navbar = document.querySelectorAll('.nav_links li')

for (const item of navbar) {
  item.addEventListener('click', function() {
    item.classList.toggle('active')
  })
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}