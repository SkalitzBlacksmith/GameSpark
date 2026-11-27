<?php
$afbeelding = afbeeldingUrl($game['image_url']);
$banner = '';
if (!empty($breedBeeld) && preg_match('~^https://shared\.fastly\.steamstatic\.com/store_item_assets/steam/apps/(\d+)/library_600x900\.jpg$~D', $afbeelding, $match)) {
    $banner = 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/' . $match[1] . '/header.jpg';
}
?>
<span class="game-cover" aria-hidden="true">
    <span class="fallback">GS</span>
    <?php if ($afbeelding !== ''): ?>
    <img src="<?= escape($banner ?: $afbeelding) ?>"<?php if ($banner !== ''): ?> data-reserve="<?= escape($afbeelding) ?>"<?php endif; ?> alt="" width="48" height="60" loading="<?= empty($breedBeeld) ? 'lazy' : 'eager' ?>" decoding="async" referrerpolicy="no-referrer">
    <?php endif; ?>
</span>
