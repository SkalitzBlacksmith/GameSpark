const menuKnop = document.getElementById('menu-knop');
const nav = document.getElementById('nav');

menuKnop.addEventListener('click', function () {
    nav.classList.toggle('open');
});
