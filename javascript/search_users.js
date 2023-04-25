
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
  const response = await fetch('../api/api_search_users.php?search=' + searchUser.value + '&role=' + userFilterSelect.value + '&order=' + userOrderSelect.value)
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
  img.src = '../images/users/default.png'
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

  buttons.appendChild(createUpgradeModal(user))
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
  wrap.classList.add('two-button-wrap')

  const form = document.createElement('form')
  form.method = 'post'
  form.action = '../pages/assign_departments.php'

  const userId = document.createElement('input');
  userId.type = 'hidden';
  userId.name = 'userId';
  userId.value = user.userId;

  const buttonWrap1 = document.createElement('div')
  buttonWrap1.classList.add('button-wrap')

  const assignButton = document.createElement('button')
  assignButton.classList.add('assign')
  assignButton.textContent = 'assign'
  assignButton.type = 'submit'

  buttonWrap1.appendChild(assignButton)
  form.appendChild(buttonWrap1)
  form.appendChild(userId)
  wrap.appendChild(form)
  buttons.appendChild(wrap)

  buttons.appendChild(createUpgradeModal(user))

  return buttons
}

function createAdminButtons(user) {

  const buttons = document.createElement('div')
  buttons.classList.add('card-buttons')

  const form = document.createElement('form')
  form.method = 'post'
  form.action = '../pages/assign_departments.php'

  const userId = document.createElement('input');
  userId.type = 'hidden';
  userId.name = 'userId';
  userId.value = user.userId;

  const buttonWrap = document.createElement('div')
  buttonWrap.classList.add('button-wrap')

  const assignButton = document.createElement('button')
  assignButton.classList.add('assign')
  assignButton.textContent = 'assign'
  assignButton.type = 'submit'

  buttonWrap.appendChild(assignButton)
  form.appendChild(buttonWrap)
  form.appendChild(userId)
  buttons.appendChild(form)

  return buttons
}

function createUpgradeModal(user) {
  const upgradeModal = document.createElement('div');
  upgradeModal.classList.add('modal');
  upgradeModal.classList.add('upgrade-modal');

  const modalContent = document.createElement('div');
  modalContent.classList.add('modal-content');

  const modalTitle = document.createElement('span');
  modalTitle.classList.add('modal-title');
  modalTitle.textContent = user.name;

  
  const img = document.createElement('img');
  img.src = '../images/users/user' + user.userId + '.png'
  img.onerror = () => { img.src = '../images/users/default.png' }
  img.classList.add(user.type + '-card-border')

  const form = document.createElement('form');
  form.method = 'POST';
  form.action = '../actions/action_upgrade_user.php';

  const promoteDiv = document.createElement('div');
  promoteDiv.id = 'promote';

  const promoteSpan = document.createElement('span');
  promoteSpan.textContent = 'Upgrade to';

  const select = document.createElement('select');
  select.name = 'role';
  select.classList.add = 'filter-select';

  if (user.type === 'client') {
    const agentOption = document.createElement('option');
    agentOption.value = 'agent';
    agentOption.textContent = 'Agent';
    select.appendChild(agentOption);
  }

  const adminOption = document.createElement('option');
  adminOption.value = 'admin';
  adminOption.textContent = 'Admin';
  select.appendChild(adminOption);

  const buttonWrapDiv = document.createElement('div');
  buttonWrapDiv.classList.add('button-wrap');

  const upgradeButton = document.createElement('button');
  upgradeButton.type = 'submit';
  upgradeButton.name = 'upgrade_user';
  upgradeButton.classList.add('confirm-upgrade');
  upgradeButton.textContent = 'upgrade';

  const userIdInput = document.createElement('input');
  userIdInput.type = 'hidden';
  userIdInput.name = 'userId';
  userIdInput.value = user.userId;

  promoteDiv.appendChild(promoteSpan);
  promoteDiv.appendChild(select);

  buttonWrapDiv.appendChild(upgradeButton);

  form.appendChild(promoteDiv);
  form.appendChild(buttonWrapDiv);
  form.appendChild(userIdInput);

  modalContent.appendChild(modalTitle);
  modalContent.appendChild(img);
  modalContent.appendChild(form);

  upgradeModal.appendChild(modalContent);

  return upgradeModal;
}

/*
const navbar = document.querySelectorAll('.nav_links li')

for (const item of navbar) {
  item.addEventListener('click', function(e) {
    item.classList.toggle('active')
    console.log('done')
  })
}*/
