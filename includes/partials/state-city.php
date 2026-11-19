<?php
$mode    ??= 'filter';
$prefix  ??= 'sc';
$wrap    ??= 'mb-3';
$state   ??= '';
$city    ??= '';
$isForm  = $mode === 'form';
$states  = content()->states();
$byState = [];
foreach (content()->cities() as $c) {
    $byState[$c['state']][] = ['slug' => $c['slug'], 'name' => $c['name']];
}
$cityPlaceholder = $isForm ? 'Select your city' : ($state !== '' ? 'All cities in ' . $state : 'All cities');
?>
<div class="<?= e($wrap) ?>">
    <label class="form-label" for="<?= e($prefix) ?>State">State</label>
    <select class="form-select js-state" id="<?= e($prefix) ?>State" name="state"<?= $isForm ? ' required' : '' ?>>
        <option value=""><?= $isForm ? 'Select your state' : 'All states' ?></option>
        <?php foreach ($states as $st): ?>
            <option value="<?= e($st) ?>"<?= $state === $st ? ' selected' : '' ?>><?= e($st) ?></option>
        <?php endforeach; ?>
    </select>
    <?php if ($isForm): ?><div class="invalid-feedback">Please select a state.</div><?php endif; ?>
</div>
<div class="<?= e($wrap) ?>">
    <label class="form-label" for="<?= e($prefix) ?>City">City</label>
    <select class="form-select js-city" id="<?= e($prefix) ?>City" name="city"<?= $isForm ? ' required' : '' ?>
            data-mode="<?= e($mode) ?>"
            data-cities="<?= e(json_encode($byState, JSON_UNESCAPED_UNICODE)) ?>">
        <option value=""><?= e($cityPlaceholder) ?></option>
        <?php foreach (content()->citiesInState($state) as $c): ?>
            <option value="<?= e($c['slug']) ?>"<?= $city === $c['slug'] ? ' selected' : '' ?>><?= e($c['name']) ?></option>
        <?php endforeach; ?>
    </select>
    <?php if ($isForm): ?><div class="invalid-feedback">Please select a city.</div><?php endif; ?>
</div>
