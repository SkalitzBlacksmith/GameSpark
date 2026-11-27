<?php
require __DIR__ . '/../app/games.php';

$velden = [
    'naam' => '', 'releasejaar' => '', 'platform' => '', 'genre' => '',
    'afbeelding_url' => '', 'status' => '', 'rating' => '', 'aangeraden_door' => '', 'notitie' => '',
];
$fouten = [];
$ingediend = $_SERVER['REQUEST_METHOD'] === 'POST';
if ($ingediend) {
    foreach ($velden as $veld => $_) {
        $velden[$veld] = tekst($_POST, $veld);
        if (isset($_POST[$veld]) && !is_string($_POST[$veld])) {
            $fouten[$veld] = 'Ongeldige invoer.';
        }
    }

    if ($velden['naam'] === '' || mb_strlen($velden['naam']) > 150) {
        $fouten['naam'] = 'Vul een naam van maximaal 150 tekens in.';
    }
    if (!preg_match('/^[1-9][0-9]{3}$/D', $velden['releasejaar'])) {
        $fouten['releasejaar'] = 'Vul een releasejaar van vier cijfers in.';
    }
    foreach (['platform' => PLATFORMS, 'status' => STATUSSEN, 'genre' => ['', ...GENRES]] as $veld => $opties) {
        if (!in_array($velden[$veld], $opties, true)) {
            $fouten[$veld] = 'Kies een geldige optie.';
        }
    }
    if ($velden['rating'] !== '' && !in_array($velden['rating'], ['1', '2', '3', '4', '5'], true)) {
        $fouten['rating'] = 'Kies een geheel getal van 1 tot en met 5.';
    }
    if ($velden['afbeelding_url'] !== '' && (strlen($velden['afbeelding_url']) > 2048 || afbeeldingUrl($velden['afbeelding_url']) === '')) {
        $fouten['afbeelding_url'] = 'Vul een geldige http- of https-link in.';
    }
    if (mb_strlen($velden['notitie']) > 280) {
        $fouten['notitie'] = 'Gebruik maximaal 280 tekens.';
    }
    if (mb_strlen($velden['aangeraden_door']) > 100) {
        $fouten['aangeraden_door'] = 'Gebruik maximaal 100 tekens.';
    }
    if ($fouten) {
        http_response_code(422);
    }
}

function invoer(string $veld, string $label, string $type, string $waarde, array $fouten, array $opties = []): void
{
    $fout = $fouten[$veld] ?? '';
    $verplicht = in_array($veld, ['naam', 'releasejaar', 'platform', 'status'], true);
    $koppeling = $fout ? ' aria-invalid="true" aria-describedby="' . escape($veld) . '-fout"' : '';
    $attributen = ' id="' . escape($veld) . '" name="' . escape($veld) . '"' . ($verplicht ? ' required' : '') . $koppeling;
    ?>
    <div class="veld">
        <label for="<?= escape($veld) ?>"><?= escape($label) ?><?= $verplicht ? ' *' : '' ?></label>
        <?php if ($type === 'select'): ?>
        <select<?= $attributen ?>>
            <option value="">Kies een optie</option>
            <?php foreach ($opties as $optie): ?>
            <option <?= $waarde === $optie ? 'selected' : '' ?>><?= escape($optie) ?></option>
            <?php endforeach; ?>
        </select>
        <?php elseif ($type === 'textarea'): ?>
        <textarea<?= $attributen ?> rows="3" maxlength="280"><?= escape($waarde) ?></textarea>
        <span class="teller" id="teller"><?= mb_strlen($waarde) ?>/280</span>
        <?php else: ?>
        <input<?= $attributen ?> type="<?= escape($type) ?>" value="<?= escape($waarde) ?>" <?= in_array($veld, ['releasejaar', 'rating'], true) ? 'inputmode="numeric"' : '' ?>>
        <?php endif; ?>
        <?php if ($fout): ?><p class="veld-fout" id="<?= escape($veld) ?>-fout"><?= escape($fout) ?></p><?php endif; ?>
    </div>
    <?php
}

$pagina = 'Nieuwe game toevoegen';
require __DIR__ . '/../app/header.php';
?>
<main class="container">
    <div class="pagina-kop"><h1>Nieuwe game toevoegen</h1></div>
    <form class="formulier" method="post" action="toevoegen.php" novalidate>
        <?php if ($ingediend): ?>
        <p class="melding" role="status"><?= $fouten ? 'Controleer de gemarkeerde velden.' : 'De invoer is geldig. Er is nog geen game opgeslagen.' ?></p>
        <?php endif; ?>
        <fieldset>
            <legend>Gegevens</legend>
            <div class="rij">
                <?php invoer('naam', 'Naam', 'text', $velden['naam'], $fouten); ?>
                <?php invoer('releasejaar', 'Releasejaar', 'text', $velden['releasejaar'], $fouten); ?>
            </div>
            <div class="rij">
                <?php invoer('platform', 'Platform', 'select', $velden['platform'], $fouten, PLATFORMS); ?>
                <?php invoer('genre', 'Genre', 'select', $velden['genre'], $fouten, GENRES); ?>
            </div>
            <?php invoer('afbeelding_url', 'Afbeelding-URL', 'url', $velden['afbeelding_url'], $fouten); ?>
        </fieldset>
        <fieldset>
            <legend>Voortgang</legend>
            <div class="rij">
                <?php invoer('status', 'Status', 'select', $velden['status'], $fouten, STATUSSEN); ?>
                <?php invoer('rating', 'Rating (1–5)', 'text', $velden['rating'], $fouten); ?>
            </div>
            <h3>Persoonlijk</h3>
            <?php invoer('aangeraden_door', 'Aangeraden door', 'text', $velden['aangeraden_door'], $fouten); ?>
            <?php invoer('notitie', 'Notitie', 'textarea', $velden['notitie'], $fouten); ?>
        </fieldset>
        <div class="formulier-knoppen">
            <a href="overzicht.php" class="knop">Annuleren</a>
            <button class="knop knop-primair">Invoer controleren</button>
        </div>
    </form>
</main>
<?php require __DIR__ . '/../app/footer.php'; ?>
