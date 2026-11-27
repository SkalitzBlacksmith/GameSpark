<?php $afbeelding = afbeeldingUrl($game['image_url']); ?>
<span class="game-cover" aria-hidden="true">
    <span class="fallback">GS</span>
    <?php if ($afbeelding !== ''): ?>
    <img src="<?= escape($afbeelding) ?>" alt="" width="48" height="60" loading="lazy" decoding="async" referrerpolicy="no-referrer">
    <?php endif; ?>
</span>
