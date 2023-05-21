async function answerWithFAQ(faqId) {
  const ticketId = document.querySelector('#ticket-page').getAttribute('data-id')

  const response = await fetch('../../api/api_ticket.php?' + encodeForAjax({ ticketId: ticketId, faqId: faqId }))
  const message = await response.json()
  const messageContainer = document.querySelector('#ticket-messages')
  messageContainer.appendChild(createMessage(message))

  messageContainer.scrollTop = messageContainer.scrollHeight
  dropup_content.style.display = 'none'

}

const faqItems = document.querySelectorAll('#faq-items li')

if (faqItems) {
  for (const faq of faqItems) {
    const faqId = faq.getAttribute('data-id')
    faq.addEventListener('click', () => { answerWithFAQ(faqId) })
  }
}



