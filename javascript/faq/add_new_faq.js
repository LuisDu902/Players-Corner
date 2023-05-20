const faqModal = document.querySelector("#faq-modal")

if (faqModal) {
  const addButton = document.querySelector("#add-faq")

  addButton.addEventListener('click', function () {
    faqModal.style.display = "block"
  })

  window.addEventListener('click', closeModal)
}
  