
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
    img.src = '../images/profiles/profile' + user.userId + '.png'
    img.onerror = () => { img.src = '../images/profiles/default.png' }
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


var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}