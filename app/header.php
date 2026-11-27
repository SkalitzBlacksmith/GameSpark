<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameSpark · <?= escape($pagina) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Rajdhani:wght@600;700&amp;display=swap">
    <link rel="stylesheet" href="css/style.css?v=6">
    <script defer src="js/script.js?v=2"></script>
</head>
<body>
<header class="header">
    <a href="index.php" class="logo">Game<span>Spark</span></a>
    <button class="menu-knop" id="menu-knop" type="button" aria-label="Menu openen" aria-controls="nav" aria-expanded="false"><span></span><span></span><span></span></button>
    <nav class="nav" id="nav" aria-label="Hoofdnavigatie">
        <a href="index.php" <?= $pagina === 'Home' ? 'aria-current="page"' : '' ?>>Home</a>
        <a href="overzicht.php" <?= $pagina === 'Gameoverzicht' ? 'aria-current="page"' : '' ?>>Overzicht</a>
        <a href="over-ons.php" <?= $pagina === 'Over ons' ? 'aria-current="page"' : '' ?>>Over ons</a>
    </nav>
</header>
