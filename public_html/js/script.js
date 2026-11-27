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

for (const afbeelding of document.querySelectorAll('.game-cover img')) {
    const toonAfbeelding = () => {
        if (afbeelding.naturalWidth > 0) afbeelding.classList.add('geladen');
    };
    afbeelding.addEventListener('load', toonAfbeelding, { once: true });
    const toonReserve = () => {
        if (!afbeelding.dataset.reserve) return;
        afbeelding.src = afbeelding.dataset.reserve;
        delete afbeelding.dataset.reserve;
    };
    afbeelding.addEventListener('error', toonReserve, { once: true });
    if (afbeelding.complete) {
        if (afbeelding.naturalWidth > 0) toonAfbeelding();
        else toonReserve();
    }
}

const steamGame = document.getElementById('steam-game');
if (steamGame) {
    steamGame.addEventListener('change', () => {
        const keuze = steamGame.selectedOptions[0];
        if (!keuze.value) return;
        document.getElementById('naam').value = keuze.textContent;
        document.getElementById('releasejaar').value = keuze.dataset.jaar;
        document.getElementById('genre').value = keuze.dataset.genre;
        document.getElementById('afbeelding_url').value = 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/' + keuze.value + '/library_600x900.jpg';
    });
}
