const menu = document.querySelector(".nav-links");
const menuButton = document.querySelector('ion-icon[name="menu-outline"]');
const closeButton = document.querySelector('ion-icon[name="close-outline"]');

menuButton.addEventListener('click', () =>{
    menu.style.display = "flex";
    closeButton.style.display = "inline-block";
    menuButton.style.display = "none";
});

const closeNav = () =>{
    menu.style.display = "none";
    closeButton.style.display = "none";
    menuButton.style.display = "inline-block";
}

closeButton.addEventListener('click', closeNav);