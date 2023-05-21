const dropdown = document.querySelector('.dropbtn')

if (dropdown) {
  dropdown.addEventListener('click', function () {
    const content = document.querySelector('.dropdown-content')
    content.classList.toggle('dropdown-selected')
  })
}

const dropup = document.querySelector('.faq-btn')
const dropup_content = document.querySelector('.dropup-content')

if (dropup) {
  showDropup(dropup, dropup_content)
}

function showDropup(button, content){
  button.addEventListener('click', function () {
    content.style.display = 'block'
  })

  document.addEventListener('click', function (event) {
    if (!button.contains(event.target) && !content.contains(event.target)) {
      content.style.display = 'none'
    }
  })
}