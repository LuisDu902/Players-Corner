
const respond = document.querySelector('#respond')

if (respond){
  const sendButton = document.querySelector("#send-button");
  sendButton.addEventListener('click', addMessage)

}

async function addMessage() {
  const messageInput = document.querySelector("#message-input");
  const ticketId = document.querySelector('#ticket-page').getAttribute('data-id')
  const token = document.querySelector('body').getAttribute('data-csrf')

  const response = await fetch('../api/api_message.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: encodeForAjax({ id: ticketId, csrf: token, text: messageInput.value}),
  });
  const message = await response.json()
  const messageContainer = document.querySelector('.messages-ticket')

  messageContainer.appendChild(createMessage(message))

  messageInput.value = ''
}

               
                   
                

function createMessage(message) {
  const comment = document.createElement('div')
  comment.classList.add('vert-flex' ,'round-border')

  const creatorId = document.querySelector('#ticket-page').getAttribute('data-creator')

  if (creatorId == message.user.userId)
    comment.classList.add('creator-msg')
  else
    comment.classList.add('replier-msg')
  
  const sender = document.createElement('h2')
  sender.classList.add('sender')
  sender.textContent = message.user.name

  const text = document.createElement('h3')
  text.classList.add('text')
  text.textContent = message.text

  const date = document.createElement('h4')
  date.classList.add('time')
  date.textContent = message.date

  comment.appendChild(sender)
  comment.appendChild(text)
  comment.appendChild(date)
  return comment
}