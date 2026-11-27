<?php
declare(strict_types=1);

function database(): PDO
{
    $bestand = getenv('GAMESPARK_DB') ?: dirname(__DIR__, 2) . '/private/gamespark-games.sqlite';
    $db = new PDO('sqlite:' . $bestand, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $db->exec('PRAGMA busy_timeout = 3000');
    if (!$db->query("SELECT 1 FROM sqlite_master WHERE type = 'table' AND name = 'games'")->fetchColumn()) {
        $db->exec(file_get_contents(__DIR__ . '/schema.sql'));
    }
    return $db;
}
