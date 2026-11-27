const menu = document.getElementById('menu-knop');
const nav = document.getElementById('nav');

if (menu && nav) {
    function zetMenu(open) {
        nav.classList.toggle('open', open);
        menu.setAttribute('aria-expanded', String(open));
        menu.setAttribute('aria-label', open ? 'Menu sluiten' : 'Menu openen');
    }

    menu.addEventListener('click', () => zetMenu(menu.getAttribute('aria-expanded') === 'false'));
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && menu.getAttribute('aria-expanded') === 'true') {
            zetMenu(false);
            menu.focus();
        }
    });
    matchMedia('(max-width: 700px)').addEventListener('change', () => zetMenu(false));
}

const notitie = document.getElementById('notitie');
const teller = document.getElementById('teller');
if (notitie && teller) {
    const tel = () => { teller.textContent = notitie.value.length + '/280'; };
    notitie.addEventListener('input', tel);
    tel();
}
