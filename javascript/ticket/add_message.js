

async function addMessage() {
  const messageInput = document.querySelector("#message-input")
  const ticketId = document.querySelector('#ticket-page').getAttribute('data-id')
  
  const response = await fetch('../../api/api_ticket.php', {
    method: 'PATCH',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: encodeForAjax({ id: ticketId, text: messageInput.value}),
  })
  const message = await response.json()
  const messageContainer = document.querySelector('#ticket-messages')
  messageContainer.appendChild(createMessage(message))

  messageContainer.scrollTop = messageContainer.scrollHeight
  window.scrollTo(0, document.body.scrollHeight)
  messageInput.value = ''
}

function createMessage(message) {

  const creatorId = document.querySelector('#ticket-page').getAttribute('data-creator')
  const comment = document.createElement('li')
  
  if (creatorId == message.user.userId)
    comment.classList.add('creator-msg', 'ticket-msg')
  else
    comment.classList.add('replier-msg', 'ticket-msg')
  
  const img = document.createElement('img')
  img.classList.add('circle-border')

  if (message.user.hasPhoto) {
    img.src = `../images/users/user${message.user.userId}.png`
  } else {
    img.src = '../images/users/default.png'
  }
 
  const sender = document.createElement('span')
  sender.textContent = message.user.name

  const content = document.createElement('section')
  content.classList.add('message-content', 'round-border')

  const text = document.createElement('p')
  text.textContent = message.text

  const date = document.createElement('p')
  date.classList.add('message-date')
  date.textContent = message.date
  
  content.appendChild(text)
  content.appendChild(date)

  comment.appendChild(img)
  comment.appendChild(sender)
  comment.appendChild(content)

  return comment
}

const respond = document.querySelector('#respond')

if (respond){
  const sendButton = document.querySelector("#send-button")
  sendButton.addEventListener('click', addMessage)
}