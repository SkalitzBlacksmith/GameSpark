<?php
require __DIR__ . '/../app/games.php';

header('Content-Type: application/json; charset=utf-8');
$term = tekst($_GET, 'q');
if (mb_strlen($term) < 2 || mb_strlen($term) > 80) {
    http_response_code(400);
    echo '[]';
    exit;
}

$url = 'https://store.steampowered.com/api/storesearch/?' . http_build_query([
    'term' => $term,
    'l' => 'english',
    'cc' => 'NL',
]);
$context = stream_context_create(['http' => ['timeout' => 4, 'follow_location' => 0]]);
$antwoord = @file_get_contents($url, false, $context, 0, 131072);
$data = $antwoord === false ? null : json_decode($antwoord, true);
if (!is_array($data) || !isset($data['items']) || !is_array($data['items'])) {
    http_response_code(502);
    echo '[]';
    exit;
}

$games = [];
foreach (array_slice($data['items'], 0, 8) as $item) {
    if (($item['type'] ?? '') !== 'app' || !is_string($item['name'] ?? null) || !is_string($item['tiny_image'] ?? null)) {
        continue;
    }
    $afbeelding = afbeeldingUrl($item['tiny_image']);
    if ($afbeelding !== '') {
        $games[] = ['naam' => $item['name'], 'afbeelding' => $afbeelding];
    }
}
echo json_encode($games, JSON_INVALID_UTF8_SUBSTITUTE);
