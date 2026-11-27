<?php
require __DIR__ . '/../app/games.php';
require __DIR__ . '/../app/database.php';

$recent = [];
$actief = false;
try {
    $db = database();
    $recent = $db->query('SELECT id, title, platform, status, rating FROM games ORDER BY id DESC LIMIT 4')->fetchAll();
    $query = $db->prepare('SELECT * FROM games WHERE status = ? ORDER BY id DESC LIMIT 1');
    $query->execute(['Speelt nu']);
    $actief = $query->fetch();
} catch (PDOException $fout) {
    error_log($fout->getMessage());
    http_response_code(503);
}
$pagina = 'Home';
require __DIR__ . '/../app/header.php';
?>
<main class="container">
    <div class="pagina-kop">
        <h1>Game-archief</h1>
        <a href="toevoegen.php" class="knop knop-primair">+ Nieuwe game</a>
    </div>
    <form class="zoekbalk" action="overzicht.php">
        <label>Zoeken<input name="zoek" type="search" placeholder="Naam of releasejaar" maxlength="100"></label>
        <button class="knop">Zoeken</button>
    </form>
    <?php if (http_response_code() === 503): ?>
        <p class="melding">Het gamearchief is tijdelijk niet beschikbaar.</p>
    <?php elseif ($actief): $game = $actief; ?>
        <section class="uitgelicht">
            <?php require __DIR__ . '/../app/thumbnail.php'; ?>
            <div class="uitgelicht-info">
                <p class="label">Verder spelen</p>
                <h2><?= escape($game['title']) ?></h2>
                <p><?= escape($game['platform']) ?> · <?= escape($game['genre']) ?> · <?= escape($game['release_year']) ?></p>
                <a class="knop" href="game.php?id=<?= (int) $game['id'] ?>">Openen</a>
            </div>
        </section>
    <?php elseif (!$recent): ?>
        <p class="melding">Er zijn nog geen games toegevoegd.</p>
    <?php endif; ?>
    <a class="knop" href="overzicht.php">Naar overzicht</a>
    <?php if ($recent): ?>
    <section class="recent">
        <h2>Recent</h2>
        <ul class="recent-games">
            <?php foreach ($recent as $game): ?>
            <li><a href="game.php?id=<?= (int) $game['id'] ?>"><strong><?= escape($game['title']) ?></strong><small><?= escape($game['platform']) ?> · <?= escape($game['status']) ?></small></a></li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/../app/footer.php'; ?>
