
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
  userCard.appendChild(createButton(user))

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

function createButton(user) {
  const button = document.createElement('div')
  button.classList.add('card-button')

  const buttonWrap = document.createElement('div')
  buttonWrap.classList.add('button-wrap')

  const link = document.createElement('a')
  link.href = "../pages/register.php"

  const upgradeButton = document.createElement('button')
  upgradeButton.classList.add('details')
  upgradeButton.textContent = 'details'

  link.appendChild(upgradeButton)
  buttonWrap.appendChild(link)
  button.append(buttonWrap)
  return button
}

const fileInput = document.querySelector('#image');
const imagePreview = document.querySelector('#image-preview');

fileInput.addEventListener('change', function (event) {
  const file = event.target.files[0];
  const reader = new FileReader();
  reader.addEventListener('load', function () {
    imagePreview.src = reader.result;
  });
  reader.readAsDataURL(file);
});




var modal1 = document.getElementById("upgrade-modal");


if (modal1) {
  var btn1 = document.getElementById("details");
  var span1 = document.getElementsByClassName("close")[0];

  btn1.addEventListener('click', function () {
    modal1.style.display = "block";
  })


  span1.onclick = function () {
    modal1.style.display = "none";
  }

  window.onclick = function (event) {
    if (event.target == modal1) {
      modal1.style.display = "none";
    }
  }
}



var departmentModal = document.querySelector("#department-modal");

if (departmentModal) {
  var addButton = document.querySelector("#add-department");
  var closeButton = document.getElementsByClassName("close")[0];

  addButton.addEventListener('click', function () {
    departmentModal.style.display = "block";
  })

  closeButton.onclick = function () {
    departmentModal.style.display = "none";
  }

  window.onclick = function (event) {
    if (event.target == departmentModal) {
      departmentModal.style.display = "none";
    }
  }


}