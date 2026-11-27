<?php
declare(strict_types=1);

const STATUSSEN = ['Wishlist', 'In bezit', 'Speelt nu', 'Uitgespeeld'];
const PLATFORMS = ['PC', 'PlayStation', 'Xbox', 'Switch', 'Overige'];
const GENRES = ['Action', 'Adventure', 'RPG', 'Strategy', 'Sport'];

function tekst(array $bron, string $naam): string
{
    return is_string($bron[$naam] ?? null) ? trim($bron[$naam]) : '';
}

function escape(string|int|null $waarde): string
{
    return htmlspecialchars((string) $waarde, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function afbeeldingUrl(string $url): string
{
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return '';
    }
    return in_array(strtolower(parse_url($url, PHP_URL_SCHEME) ?? ''), ['http', 'https'], true) ? $url : '';
}

function filterGames(PDO $db, array $filters): array
{
    $where = [];
    $waarden = [];
    foreach (['platform', 'genre', 'status'] as $veld) {
        if ($filters[$veld] !== '') {
            $where[] = "$veld = ?";
            $waarden[] = $filters[$veld];
        }
    }

    foreach (['van' => '>=', 'tot' => '<='] as $veld => $operator) {
        if ($filters[$veld] !== '') {
            $where[] = "rating $operator ?";
            $waarden[] = (int) $filters[$veld];
        }
    }

    $zoek = $filters['zoek'];
    if ($zoek !== '') {
        $where[] = '(title LIKE ? ESCAPE \'!\' OR release_year = ?)';
        $waarden[] = '%' . strtr($zoek, ['!' => '!!', '%' => '!%', '_' => '!_']) . '%';
        $waarden[] = preg_match('/^[0-9]{4}$/D', $zoek) ? (int) $zoek : 0;
    }

    $sortering = match ($filters['sortering']) {
        'naam-za' => 'title DESC',
        'jaar-op' => 'release_year ASC',
        'jaar-af' => 'release_year DESC',
        'rating-op' => 'rating IS NULL, rating ASC',
        'rating-af' => 'rating DESC',
        default => 'title ASC',
    };
    $sql = 'SELECT * FROM games' . ($where ? ' WHERE ' . implode(' AND ', $where) : '');
    $query = $db->prepare($sql . ' ORDER BY ' . $sortering . ', id ASC');
    foreach ($waarden as $index => $waarde) {
        $query->bindValue($index + 1, $waarde, is_int($waarde) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    $query->execute();
    return $query->fetchAll();
}
