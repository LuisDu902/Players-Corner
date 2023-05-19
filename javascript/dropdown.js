const dropdown = document.querySelector('.dropbtn')

dropdown.addEventListener('click', function () {
    const content = document.querySelector('.dropdown-content')
    content.classList.toggle('dropdown-selected')
})

const dropup = document.querySelector('.faq-btn')
const dropup_content = document.querySelector('.dropup-content')

dropup.addEventListener('click', function () {
    dropup_content.style.display = 'block'
})

document.addEventListener('click', function (event) {
    if (!dropup.contains(event.target) && !dropup_content.contains(event.target)) {
        dropup_content.style.display = 'none';
    }
});