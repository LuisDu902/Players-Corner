const dropdown = document.querySelector('.dropbtn')

dropdown.addEventListener('click', function () {
    const content = document.querySelector('.dropdown-content')
    content.classList.toggle('dropdown-selected')
})
