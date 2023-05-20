async function updateReputation(ticketId, agentId, value) {
  const hasFeedback = document.querySelector('#last-message')
  if (!hasFeedback) {
    const response = await fetch('../../api/api_ticket.php', {
      method: 'PUT',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: encodeForAjax({ ticketId: ticketId, agentId: agentId, value: value }),
    })

    const message = await response.json()

    if (message.status != 'error') {
      const messages = document.querySelector('#ticket-messages')
      messages.appendChild(createBotResponse())
    }
  }
}

function createBotResponse() {
  const response = document.createElement('li')
  response.classList.add('bot-msg', 'ticket-msg')
  response.id = 'last-message'

  const img = document.createElement('img')
  img.src = "../images/icons/bot.png"
  img.classList.add('circle-border', 'bot-img')

  const bot = document.createElement('span')
  bot.textContent = 'Satisfaction survey'

  const content = document.createElement('section')
  content.classList.add('message-content', 'round-border')

  const text = document.createElement('p')
  text.textContent = "Thank you for sharing your valuable feedback! We appreciate your time and effort in rating the service provided by our agent. Your input helps us level up our customer experience. If you have any further comments or need assistance, please don't hesitate to let us know. Game on!"

  content.appendChild(text)

  response.appendChild(img)
  response.appendChild(bot)
  response.appendChild(content)

  return response
}

const feedback = document.querySelector('#feedback')

if (feedback) {
  const ticketId = document.querySelector('#ticket-page').getAttribute('data-id')
  const agentId = feedback.getAttribute('data-id')
  const buttons = document.querySelectorAll('#feedback button')

  for (const button of buttons) {
    const value = button.getAttribute('data-value')
    button.addEventListener('click', () => { updateReputation(ticketId, agentId, value) })
  }
}