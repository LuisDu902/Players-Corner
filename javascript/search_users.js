
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
  const userCard = document.createElement('div');
  userCard.classList.add('user-card', 'vert-flex', 'round-border', 'white-border');

  userCard.appendChild(createCardType(user));
  userCard.appendChild(createImage(user));
  userCard.appendChild(createCardDetails(user));
  userCard.appendChild(createButtons(user));
  userCard.appendChild(createUserId(user));

  return userCard;
}

function createCardType(user) {
  const cardType = document.createElement('div');
  cardType.classList.add('card-type');

  const typeSpan = document.createElement('span');
  typeSpan.classList.add('type', `${user.type}-card-type`, 'bold', 'center');
  typeSpan.textContent = user.type;
  cardType.appendChild(typeSpan);

  const repSpan = document.createElement('span');
  repSpan.classList.add('rep', 'center', 'bold', 'circle-border');
  repSpan.textContent = user.reputation;
  cardType.appendChild(repSpan);

  return cardType;
}

function createImage(user) {
  const img = document.createElement('img');
  img.classList.add(`${user.type}-card-border`, 'card-img', 'circle-border');

  if (user.hasPhoto) {
    img.src = `../images/users/user${user.userId}.png`;
  } else {
    img.src = '../images/users/default.png';
  }

  img.alt = 'profile';

  return img;
}

function createCardDetails(user) {
  const cardDetails = document.createElement('div');
  cardDetails.classList.add('card-details', 'vert-flex', 'center');

  const cardName = document.createElement('span');
  cardName.classList.add('card-name');
  cardName.textContent = user.name;
  cardDetails.appendChild(cardName);

  const username = document.createElement('span');
  username.classList.add('span-username');
  username.textContent = user.username;
  cardDetails.appendChild(username);

  return cardDetails;
}

function createButtons(user) {
  const cardButtons = document.createElement('div');
  cardButtons.classList.add('card-buttons', 'center');

  if (user.type !== 'admin') {
    const upgradeButtonWrap = document.createElement('div');
    upgradeButtonWrap.classList.add('button-wrap', 'gradient', 'round-border');

    const upgradeButton = document.createElement('button');
    upgradeButton.id = 'upgrade';
    upgradeButton.textContent = 'upgrade';

    upgradeButtonWrap.appendChild(upgradeButton);
    cardButtons.appendChild(upgradeButtonWrap);
  }

  if (user.type !== 'client') {
    const assignDepButtonWrap = document.createElement('div');
    assignDepButtonWrap.classList.add('button-wrap', 'gradient', 'round-border');

    const assignDepButton = document.createElement('button');
    assignDepButton.id = 'assign-dep';
    assignDepButton.textContent = 'assign';

    assignDepButtonWrap.appendChild(assignDepButton);
    cardButtons.appendChild(assignDepButtonWrap);
  }

  return cardButtons;
}

function createUserId(user) {
  const userIdInput = document.createElement('input');
  userIdInput.type = 'hidden';
  userIdInput.value = user.userId;
  userIdInput.id = 'card-userId';

  return userIdInput;
}


function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}