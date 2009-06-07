<div id="h1">
    <h1><?= htmlspecialchars ($meta['h1']) ?></h1>
</div>

<div id="h2">
    <? if (! empty ($meta['h2-addon'])) : ?>
        <span><?= $meta['h2-addon']?></span>
    <? endif; ?>
    <h2><?= htmlspecialchars ($meta['h2']) ?></h2>
</div>