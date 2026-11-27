<?php
require __DIR__ . '/../app/games.php';
require __DIR__ . '/../app/database.php';

$id = filter_var(tekst($_GET, 'id'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$game = false;
$melding = 'Deze game is niet gevonden.';
if ($id !== false) {
    try {
        $query = database()->prepare('SELECT * FROM games WHERE id = ?');
        $query->execute([$id]);
        $game = $query->fetch();
    } catch (PDOException $fout) {
        error_log($fout->getMessage());
        http_response_code(503);
        $melding = 'De game is tijdelijk niet beschikbaar.';
    }
}
if (!$game && http_response_code() !== 503) {
    http_response_code(404);
}
$pagina = $game ? $game['title'] : 'Game bekijken';
require __DIR__ . '/../app/header.php';
?>
<main class="container detail">
    <a class="terug" href="overzicht.php">← Overzicht</a>
    <?php if (!$game): ?>
    <h1><?= escape($melding) ?></h1>
    <?php else: ?>
    <div class="detail-kop">
        <?php require __DIR__ . '/../app/thumbnail.php'; ?>
        <div>
            <p class="label"><?= escape($game['status']) ?></p>
            <h1><?= escape($game['title']) ?></h1>
        </div>
    </div>
    <dl class="game-gegevens">
        <?php foreach (['platform' => 'Platform', 'genre' => 'Genre', 'release_year' => 'Releasejaar', 'status' => 'Status', 'rating' => 'Beoordeling', 'recommended_by' => 'Aangeraden door', 'note' => 'Notitie'] as $veld => $label): ?>
        <div><dt><?= escape($label) ?></dt><dd><?= ($game[$veld] ?? '') === '' ? '—' : escape($game[$veld]) . ($veld === 'rating' ? '/5' : '') ?></dd></div>
        <?php endforeach; ?>
    </dl>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/../app/footer.php'; ?>
