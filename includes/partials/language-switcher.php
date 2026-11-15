<div class="lang-switch <?= e($class ?? '') ?>" role="group" aria-label="Choose language">
    <?php foreach ($languages as $code => $label): ?>
        <button type="button" class="lang-btn<?= $code === 'en' ? ' active' : '' ?>" data-lang="<?= e($code) ?>"
                lang="<?= e($code) ?>" aria-pressed="<?= $code === 'en' ? 'true' : 'false' ?>"><?= e($label) ?></button>
    <?php endforeach; ?>
</div>
