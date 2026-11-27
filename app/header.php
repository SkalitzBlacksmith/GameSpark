<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameSpark · <?= escape($pagina) ?></title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <script defer src="js/script.js?v=2"></script>
</head>
<body>
<header class="header">
    <a href="index.php" class="logo">Game<span>Spark</span></a>
    <button class="menu-knop" id="menu-knop" type="button" aria-label="Menu openen" aria-controls="nav" aria-expanded="false"><span></span><span></span><span></span></button>
    <nav class="nav" id="nav" aria-label="Hoofdnavigatie">
        <a href="overzicht.php" <?= $pagina === 'Gameoverzicht' ? 'aria-current="page"' : '' ?>>Overzicht</a>
        <a href="over-ons.php" <?= $pagina === 'Over ons' ? 'aria-current="page"' : '' ?>>Over ons</a>
    </nav>
</header>
