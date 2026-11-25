const menuKnop = document.getElementById('menu-knop');
const nav = document.getElementById('nav');

menuKnop.addEventListener('click', function () {
    nav.classList.toggle('open');
});

const notitie = document.getElementById('notitie');
const teller = document.getElementById('teller');

if (notitie) {
    notitie.addEventListener('input', function () {
        teller.textContent = notitie.value.length + '/280';
    });
}
