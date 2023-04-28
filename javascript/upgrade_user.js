function showUpgradeModal() {
    const upgradeButtons = document.querySelectorAll(".upgrade");
    if (upgradeButtons) {
        for (const upgradeButton of upgradeButtons) {
            upgradeButton.addEventListener('click', upgradeModal)
            window.addEventListener('click', closeModal)
        }
    }
}

function upgradeModal() {

    const upgradeModal = document.querySelector(".modal");
    upgradeModal.classList.add('upgrade-modal')
    upgradeModal.innerHTML = ''

    const card = this.closest('.user-card')

    const content = document.createElement('div')
    content.classList.add('modal-content')

    const title = document.createElement('span')
    title.classList.add('modal-title')
    title.textContent = card.querySelector('.card-name').textContent;

    const img = document.createElement('img')
    img.src = card.querySelector('.card-img').src
    img.classList = card.querySelector('.card-img').classList

    const form = document.createElement('form')
    form.method = 'POST'
    form.action = '../actions/action_upgrade_user.php'

    const promote = document.createElement('div')
    promote.id = 'promote'

    const text = document.createElement('span')
    text.textContent = 'Upgrade to'

    const select = document.createElement('select')
    select.name = 'role'
    select.classList.add('filter-select')

    const role = card.querySelector('.type').textContent
    if (role == "client") {
        const agentOption = document.createElement('option')
        agentOption.value = 'agent'
        agentOption.textContent = 'agent'

        select.appendChild(agentOption)
    }

    const adminOption = document.createElement('option')
    adminOption.value = 'admin'
    adminOption.textContent = 'admin'

    select.appendChild(adminOption)

    promote.appendChild(text)
    promote.appendChild(select)

    const buttonWrap = document.createElement('div')
    buttonWrap.classList.add('button-wrap')

    const button = document.createElement('button')
    button.type = 'submit'
    button.name = 'upgrade_user'
    button.textContent = 'upgrade'
    button.classList.add('confirm-upgrade')

    buttonWrap.appendChild(button)

    const userId = document.createElement('input')
    userId.type = 'hidden'
    userId.name = 'userId'
    userId.value = card.querySelector('#card-userId').value

    form.appendChild(promote)
    form.appendChild(buttonWrap)
    form.appendChild(userId)

    content.appendChild(title)
    content.appendChild(img)
    content.appendChild(form)

    upgradeModal.appendChild(content)

    upgradeModal.style.display = "block"
}

showUpgradeModal()