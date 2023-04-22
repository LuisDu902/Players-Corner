
const select = document.getElementById('select');

select.onchange = filter;

async function filter() {
    const response = await fetch('../api/api_filter_users.php?role=' + this.value)
    const users = await response.json()

    const section = document.querySelector('#users')
    section.innerHTML = ''

    for (const user of users) {
        const userCard = document.createElement('div')
        userCard.classList.add('user-card')

        /* card-type*/
        const cardType = document.createElement('div')
        cardType.classList.add('card-type')

        const typeSpan = document.createElement('span')
        typeSpan.classList.add('type', user.type + '-card-type')
        typeSpan.textContent = user.type;
        cardType.appendChild(typeSpan)

        const repSpan = document.createElement('span')
        repSpan.classList.add('rep')
        repSpan.textContent = user.reputation
        cardType.appendChild(repSpan)

        userCard.appendChild(cardType)

        /* image */
        const img = document.createElement('img')
        img.src = '../images/profile/default.png'
        img.classList.add(user.type + '-card-border')
        userCard.appendChild(img)


        /* card-details */
        const cardDetails = document.createElement('div')
        cardDetails.classList.add('card-details')

        const cardName = document.createElement('span')
        cardName.classList.add('card-name')
        cardName.textContent = user.name
        cardDetails.appendChild(cardName)

        const username = document.createElement('span')
        username.textContent = user.username
        cardDetails.appendChild(username)

        userCard.appendChild(cardDetails)

        /* buttons */
        const buttons = document.createElement('div')
        buttons.classList.add('card-buttons')
        if (user.type === "client") {
            const buttonWrap = document.createElement('div')
            buttonWrap.classList.add('button-wrap')

            const link = document.createElement('a')
            link.href = "../pages/register.php"

            const upgradeButton = document.createElement('button')
            upgradeButton.classList.add('upgrade')
            upgradeButton.textContent = 'upgrade'

            link.appendChild(upgradeButton)

            buttonWrap.appendChild(link)

            buttons.appendChild(buttonWrap)
        }
        else if (user.type === "agent") {
            const buttonWrap = document.createElement('div')
            buttonWrap.classList.add('button-wrap')
            buttonWrap.classList.add('two-button-wrap')

            const link = document.createElement('a')
            link.href = "../pages/register.php"

            const upgradeButton = document.createElement('button')
            upgradeButton.classList.add('upgrade')
            upgradeButton.textContent = 'upgrade'

            link.appendChild(upgradeButton)

            buttonWrap.appendChild(link)

            buttons.appendChild(buttonWrap)

            const buttonWrap1 = document.createElement('div')
            buttonWrap1.classList.add('button-wrap')
            buttonWrap1.classList.add('two-button-wrap')

            const link1 = document.createElement('a')
            link1.href = "../pages/register.php"

            const upgradeButton1 = document.createElement('button')
            upgradeButton1.classList.add('assign')
            upgradeButton1.textContent = 'assign'

            link1.appendChild(upgradeButton1)

            buttonWrap1.appendChild(link1)

            buttons.appendChild(buttonWrap1)

        }
        else if (user.type === "admin") {
            const buttonWrap = document.createElement('div')
            buttonWrap.classList.add('button-wrap')

            const link = document.createElement('a')
            link.href = "../pages/register.php"

            const upgradeButton = document.createElement('button')
            upgradeButton.classList.add('assign')
            upgradeButton.textContent = 'assign'

            link.appendChild(upgradeButton)

            buttonWrap.appendChild(link)

            buttons.appendChild(buttonWrap)
        }

        userCard.append(buttons)

        section.appendChild(userCard)
    }
}



const searchUser = document.querySelector('#search-user')
if (searchUser) {
    searchUser.addEventListener('input', async function () {
        const response = await fetch('../api/api_users.php?search=' + this.value)
        const users = await response.json()

        const section = document.querySelector('#users')
        section.innerHTML = ''

        for (const user of users) {
            const userCard = document.createElement('div')
            userCard.classList.add('user-card')

            /* card-type*/
            const cardType = document.createElement('div')
            cardType.classList.add('card-type')

            const typeSpan = document.createElement('span')
            typeSpan.classList.add('type', user.type + '-card-type')
            typeSpan.textContent = user.type;
            cardType.appendChild(typeSpan)

            const repSpan = document.createElement('span')
            repSpan.classList.add('rep')
            repSpan.textContent = user.reputation
            cardType.appendChild(repSpan)

            userCard.appendChild(cardType)

            /* image */
            const img = document.createElement('img')
            img.src = '../images/profile/default.png'
            img.classList.add(user.type + '-card-border')
            userCard.appendChild(img)


            /* card-details */
            const cardDetails = document.createElement('div')
            cardDetails.classList.add('card-details')

            const cardName = document.createElement('span')
            cardName.classList.add('card-name')
            cardName.textContent = user.name
            cardDetails.appendChild(cardName)

            const username = document.createElement('span')
            username.textContent = user.username
            cardDetails.appendChild(username)

            userCard.appendChild(cardDetails)

            /* buttons */
            const buttons = document.createElement('div')
            buttons.classList.add('card-buttons')
            if (user.type === "client") {
                const buttonWrap = document.createElement('div')
                buttonWrap.classList.add('button-wrap')

                const link = document.createElement('a')
                link.href = "../pages/register.php"

                const upgradeButton = document.createElement('button')
                upgradeButton.classList.add('upgrade')
                upgradeButton.textContent = 'upgrade'

                link.appendChild(upgradeButton)

                buttonWrap.appendChild(link)

                buttons.appendChild(buttonWrap)
            }
            else if (user.type === "agent") {
                const buttonWrap = document.createElement('div')
                buttonWrap.classList.add('button-wrap')
                buttonWrap.classList.add('two-button-wrap')

                const link = document.createElement('a')
                link.href = "../pages/register.php"

                const upgradeButton = document.createElement('button')
                upgradeButton.classList.add('upgrade')
                upgradeButton.textContent = 'upgrade'

                link.appendChild(upgradeButton)

                buttonWrap.appendChild(link)

                buttons.appendChild(buttonWrap)

                const buttonWrap1 = document.createElement('div')
                buttonWrap1.classList.add('button-wrap')
                buttonWrap1.classList.add('two-button-wrap')

                const link1 = document.createElement('a')
                link1.href = "../pages/register.php"

                const upgradeButton1 = document.createElement('button')
                upgradeButton1.classList.add('assign')
                upgradeButton1.textContent = 'assign'

                link1.appendChild(upgradeButton1)

                buttonWrap1.appendChild(link1)

                buttons.appendChild(buttonWrap1)

            }
            else if (user.type === "admin") {
                const buttonWrap = document.createElement('div')
                buttonWrap.classList.add('button-wrap')

                const link = document.createElement('a')
                link.href = "../pages/register.php"

                const upgradeButton = document.createElement('button')
                upgradeButton.classList.add('assign')
                upgradeButton.textContent = 'assign'

                link.appendChild(upgradeButton)

                buttonWrap.appendChild(link)

                buttons.appendChild(buttonWrap)
            }

            userCard.append(buttons)

            section.appendChild(userCard)
        }
    })
}