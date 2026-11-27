<?php
require __DIR__ . '/../app/games.php';
$pagina = 'Over ons';
require __DIR__ . '/../app/header.php';
?>
    <main class="container">
        <section class="intro">
            <h1>Over ons</h1>
            <p>GameSpark is een overzicht voor Liam de Waal. Hier houdt hij bij welke games hij al gespeeld en gereviewd heeft, welke nog op zijn wishlist staan en wie hem een game heeft aangeraden. Zo zien zijn collega's in één oogopslag waar hij mee bezig is.</p>
        </section>

        <section class="team">
            <h2>Het team</h2>
            <div class="team-lijst">
                <article class="team-kaart">
                    <div class="foto" aria-hidden="true">Z</div>
                    <div>
                        <h3>Zakaria</h3>
                        <p>Developer</p>
                    </div>
                </article>
                <article class="team-kaart">
                    <div class="foto" aria-hidden="true">M</div>
                    <div>
                        <h3>Mehmethan</h3>
                        <p>Developer</p>
                    </div>
                </article>
            </div>
        </section>

        <a href="index.php" class="knop">&larr; Terug</a>
    </main>

<?php require __DIR__ . '/../app/footer.php'; ?>
