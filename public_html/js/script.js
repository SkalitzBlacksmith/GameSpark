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

const steamZoek = document.getElementById('steam-zoek');

if (steamZoek) {
    const knop = document.getElementById('steam-zoeken');
    const resultaten = document.getElementById('steam-resultaten');
    const keuze = document.getElementById('steam-game');
    const melding = document.getElementById('steam-melding');

    async function zoekSteam() {
        const term = steamZoek.value.trim();
        resultaten.hidden = true;
        keuze.replaceChildren();
        if (term.length < 2) {
            melding.textContent = 'Typ minstens twee tekens.';
            return;
        }

        knop.disabled = true;
        melding.textContent = 'Zoeken…';
        try {
            const antwoord = await fetch('steam-zoeken.php?q=' + encodeURIComponent(term));
            if (!antwoord.ok) throw new Error();
            const games = await antwoord.json();
            if (games.length === 0) {
                melding.textContent = 'Geen resultaten op Steam.';
                return;
            }

            keuze.add(new Option('Kies een game', ''));
            for (const game of games) keuze.add(new Option(game.naam, game.afbeelding));
            resultaten.hidden = false;
            melding.textContent = '';
        } catch {
            melding.textContent = 'Steam is tijdelijk niet bereikbaar.';
        } finally {
            knop.disabled = false;
        }
    }

    knop.addEventListener('click', zoekSteam);
    steamZoek.addEventListener('keydown', event => {
        if (event.key !== 'Enter') return;
        event.preventDefault();
        if (!knop.disabled) zoekSteam();
    });
    keuze.addEventListener('change', () => {
        if (!keuze.value) return;
        document.getElementById('naam').value = keuze.selectedOptions[0].textContent;
        document.getElementById('afbeelding_url').value = keuze.value;
    });
}
