<?php
require __DIR__ . '/../app/games.php';
require __DIR__ . '/../app/database.php';

$filters = [];
foreach (['zoek', 'platform', 'genre', 'status', 'van', 'tot', 'sortering'] as $veld) {
    $filters[$veld] = tekst($_GET, $veld);
}

$keuzes = ['platform' => PLATFORMS, 'genre' => GENRES, 'status' => STATUSSEN];
foreach ($keuzes as $veld => $opties) {
    if (!in_array($filters[$veld], $opties, true)) {
        $filters[$veld] = '';
    }
}
foreach (['van', 'tot'] as $veld) {
    if (!in_array($filters[$veld], ['1', '2', '3', '4', '5'], true)) {
        $filters[$veld] = '';
    }
}

$games = [];
$databaseFout = false;
$scoreFout = $filters['van'] !== '' && $filters['tot'] !== '' && (int) $filters['van'] > (int) $filters['tot'];
if (!$scoreFout) {
    try {
        $games = filterGames(database(), $filters);
    } catch (PDOException $fout) {
        error_log($fout->getMessage());
        http_response_code(503);
        $databaseFout = true;
    }
}
$gefilterd = (bool) array_filter(array_diff_key($filters, ['sortering' => true]));
$pagina = 'Gameoverzicht';
require __DIR__ . '/../app/header.php';
?>
<main class="container">
    <div class="pagina-kop">
        <h1>Gameoverzicht</h1>
        <a href="toevoegen.php" class="knop knop-primair">+ Nieuwe game</a>
    </div>
    <form class="filter-paneel" method="get" action="overzicht.php">
        <div class="zoekbalk">
            <label>Zoeken<input type="search" name="zoek" maxlength="100" placeholder="Naam of releasejaar" value="<?= escape($filters['zoek']) ?>"></label>
            <label>Sortering
                <select name="sortering">
                    <?php foreach (['' => 'Naam A–Z', 'naam-za' => 'Naam Z–A', 'jaar-af' => 'Nieuwste eerst', 'jaar-op' => 'Oudste eerst', 'rating-af' => 'Hoogste score', 'rating-op' => 'Laagste score'] as $waarde => $label): ?>
                    <option value="<?= escape($waarde) ?>" <?= $filters['sortering'] === $waarde ? 'selected' : '' ?>><?= escape($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <div class="filters">

            <?php foreach ($keuzes as $veld => $opties): ?>
            <label><?= escape(ucfirst($veld)) ?>
                <select name="<?= escape($veld) ?>">
                    <option value="">Alle</option>
                    <?php foreach ($opties as $optie): ?>
                    <option <?= $filters[$veld] === $optie ? 'selected' : '' ?>><?= escape($optie) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php endforeach; ?>
            <?php foreach (['van' => 'Score vanaf', 'tot' => 'Score tot en met'] as $veld => $label): ?>
            <label><?= escape($label) ?>
                <select name="<?= escape($veld) ?>" <?= $scoreFout ? 'aria-invalid="true" aria-describedby="score-fout"' : '' ?>>
                    <option value="">Alle</option>
                    <?php for ($score = 1; $score <= 5; $score++): ?>
                    <option <?= $filters[$veld] === (string) $score ? 'selected' : '' ?>><?= $score ?></option>
                    <?php endfor; ?>
                </select>
            </label>
            <?php endforeach; ?>
        </div>
        <div class="filter-acties">
            <button class="knop knop-primair">Toepassen</button>
            <a class="knop" href="overzicht.php">Wissen</a>
        </div>
    </form>
    <?php if ($databaseFout): ?>
        <p class="melding">Het gameoverzicht is tijdelijk niet beschikbaar.</p>
    <?php elseif ($scoreFout): ?>
        <p class="melding" id="score-fout" role="alert">De minimumscore mag niet hoger zijn dan de maximumscore.</p>
    <?php elseif (!$games): ?>
        <p class="melding"><?= $gefilterd ? 'Geen games gevonden met deze filters.' : 'Er zijn nog geen games toegevoegd.' ?></p>
    <?php else: ?>
        <p class="aantal"><?= count($games) ?> <?= count($games) === 1 ? 'game' : 'games' ?></p>
        <?php
        $groepen = [];
        foreach ($games as $game) {
            $groepen[$game['status']][] = $game;
        }
        ?>
        <div class="status-kolommen">
        <?php foreach (['Speelt nu', 'Uitgespeeld', 'Wishlist', 'In bezit'] as $status): ?>
            <?php if (empty($groepen[$status])) continue; ?>
            <section class="status-kolom" data-status="<?= escape($status) ?>">
            <h2><?= escape($status) ?> <span><?= count($groepen[$status]) ?></span></h2>
            <ul class="game-lijst">
            <?php foreach ($groepen[$status] as $game): ?>
            <li class="game-rij">
                <a class="game-identiteit" href="game.php?id=<?= (int) $game['id'] ?>">
                    <?php require __DIR__ . '/../app/thumbnail.php'; ?>
                    <span><strong><?= escape($game['title']) ?></strong><small><?= escape($game['platform']) ?> · <?= escape($game['release_year']) ?></small></span>
                    <span class="rating" aria-label="Beoordeling"><?= $game['rating'] === null ? '—' : escape($game['rating']) . '/5' ?></span>
                    <span class="game-pijl" aria-hidden="true">→</span>
                </a>
            </li>
            <?php endforeach; ?>
            </ul>
            </section>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/../app/footer.php'; ?>
