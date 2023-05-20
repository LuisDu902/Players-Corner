function selectDepartments() {
  const assign = document.querySelector(".assignable-departments")
  if (assign) {
    const images = document.querySelectorAll(".department-card img")
    for (const image of images) {
      image.addEventListener('click', function () { image.classList.toggle('selected') })
    }
  }
}

function assignToDepartments() {
  const assignButton = document.querySelector(".confirm-upgrade")
  if (assignButton) {
    assignButton.addEventListener('click', function () {
      const selectedDepartments = document.querySelectorAll(".department-card img.selected")
      const selectedDepartmentsArray = []
      for (const department of selectedDepartments) {
        const parent = department.parentElement
        const category = parent.querySelector('strong').textContent
        selectedDepartmentsArray.push(category)
      }
      const selectedDepartmentsInput = document.querySelector("#selected-departments")
      selectedDepartmentsInput.value = selectedDepartmentsArray.join(',')
      this.form.submit()
    })
  }
}

function showAssignModal() {
  const assignButtons = document.querySelectorAll("#assign-dep")
  if (assignButtons) {
    for (const assignButton of assignButtons) {
      assignButton.addEventListener('click', assignModal)
      window.addEventListener('click', closeModal)
    }
  }
}

async function assignModal() {
  const card = this.closest('.user-card')
  const response = await fetch('../api/api_search.php?' + encodeForAjax({ type: 'departments', userId: card.querySelector('#card-userId').value }))
  const departments = await response.json()

  const assignModal = document.querySelector(".modal")
  assignModal.classList.add('assign-modal')
  assignModal.innerHTML = ''

  const content = document.createElement('article')
  content.classList.add('modal-content', 'white-border', 'round-border', 'vert-flex', 'center')
  content.id = 'assign-modal-content'

  const assignableDepartments = document.createElement('section')
  assignableDepartments.classList.add('assignable-departments')

  if (departments.length == 0) {
    const title = document.createElement('h2')
    title.classList.add('modal-title')
    title.textContent = 'Already assigned to all departments !!!'
    content.appendChild(title)
  } else {
    for (const department of departments) {
      const dep = document.createElement('article')
      dep.classList.add('department-card')

      const img = document.createElement('img')
      if (department.hasPhoto) {
        const fileName = department.category.toLowerCase().replaceAll(' ', '_')
        img.src = '../images/departments/' + fileName + '.png'
      } else {
        img.src = '../images/departments/default.png'
      }
      img.classList.add('round-border', 'white-border')

      const category = document.createElement('strong')
      category.textContent = department.category

      dep.appendChild(img)
      dep.appendChild(category)

      assignableDepartments.appendChild(dep)
    }

    const form = document.createElement('form')
    form.method = 'POST'
    form.action = '../actions/user_actions/action_assign_to_departments.php'

    const buttonWrap = document.createElement('div')
    buttonWrap.classList.add('button-wrap', 'gradient', 'round-border')

    const button = document.createElement('button')
    button.type = 'submit'
    button.name = 'assign_user'
    button.textContent = 'assign'
    button.classList.add('confirm-upgrade')

    buttonWrap.appendChild(button)

    const userId = document.createElement('input')
    userId.type = 'hidden'
    userId.name = 'userId'
    userId.value = card.querySelector('#card-userId').value

    const selectedDepartments = document.createElement('input')
    selectedDepartments.type = 'hidden'
    selectedDepartments.name = 'selected_departments'
    selectedDepartments.id = 'selected-departments'

    const token = document.createElement('input')
    token.type = 'hidden'
    token.name = 'csrf'
    token.value = document.querySelector('body').getAttribute('data-csrf')

    form.appendChild(buttonWrap)
    form.appendChild(userId)
    form.appendChild(selectedDepartments)
    form.appendChild(token)

    content.appendChild(assignableDepartments)
    content.appendChild(form)
  }

  assignModal.appendChild(content)
  assignModal.style.display = "block"

  selectDepartments()
  assignToDepartments()
}

showAssignModal()