function closeModal(event) {
  const modal = document.querySelector(".modal")
  if (event.target == modal) {
    modal.style.display = "none"
  }
}

const departmentModal = document.querySelector("#department-modal")

if (departmentModal) {
  const addButton = document.querySelector("#add-department")

  addButton.addEventListener('click', function () {
    departmentModal.style.display = "block"
  })

  window.addEventListener('click', closeModal)
}

