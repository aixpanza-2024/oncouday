<?php
declare(strict_types=1);

$page = array_merge([
    'title'       => '',
    'description' => 'OncoUday — India\'s gateway to cancer clinical trials and patient support. Register once and get WhatsApp alerts when a matching trial opens.',
    'active'      => '',
    'bodyClass'   => '',
], $page ?? []);

$fullTitle = $page['title'] !== ''
    ? $page['title'] . ' · OncoUday'
    : 'OncoUday — India\'s gateway to cancer clinical trials';
$languages = config('app.languages');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($fullTitle) ?></title>
    <meta name="description" content="<?= e($page['description']) ?>">
    <meta name="theme-color" content="#101f6b">
    <meta property="og:title" content="<?= e($fullTitle) ?>">
    <meta property="og:description" content="<?= e($page['description']) ?>">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/svg+xml" href="<?= e(asset('img/logo.svg')) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
</head>
<body class="<?= e(trim('page-' . $page['active'] . ' ' . $page['bodyClass'])) ?>">

<a class="skip-link" href="#main">Skip to main content</a>
<div class="scroll-progress" aria-hidden="true"><span></span></div>

<div class="topbar">
    <div class="container-xxl d-flex align-items-center justify-content-between gap-3">
        <p class="topbar-text mb-0"><span class="live-dot" aria-hidden="true"></span>Cancer clinical trials in India, refreshed every second</p>
        <?php partial('language-switcher', ['languages' => $languages, 'class' => 'd-none d-sm-flex']); ?>
    </div>
</div>

<header class="site-header" id="siteHeader">
    <nav class="navbar navbar-expand-xl" aria-label="Main navigation">
        <div class="container-xxl">
            <?php partial('brand'); ?>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-label="Open menu">
                <span class="toggler-bar"></span><span class="toggler-bar"></span><span class="toggler-bar"></span>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="mainNav" aria-labelledby="mainNavLabel">
                <div class="offcanvas-header">
                    <span id="mainNavLabel" class="visually-hidden">Menu</span>
                    <?php partial('brand'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close menu"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav main-nav mx-xl-auto">
                        <?php foreach (content()->navigation() as $i => $item): ?>
                            <?php $isActive = $page['active'] === $item['key']; ?>
                            <li class="nav-item" style="--i: <?= (int) $i ?>">
                                <a class="nav-link<?= $isActive ? ' active' : '' ?>" href="<?= e(url($item['href'])) ?>"<?= $isActive ? ' aria-current="page"' : '' ?>>
                                    <?= e($item['label']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="header-ctas">
                        <a class="btn btn-outline-navy<?= $page['active'] === 'doctor' ? ' active' : '' ?>" href="<?= e(url('doctor-registration.php')) ?>">I'm a doctor</a>
                        <a class="btn btn-magenta<?= $page['active'] === 'patient' ? ' active' : '' ?>" href="<?= e(url('patient-registration.php')) ?>">I'm a patient</a>
                    </div>
                    <?php partial('language-switcher', ['languages' => $languages, 'class' => 'd-flex d-sm-none mt-4']); ?>
                </div>
            </div>
        </div>
    </nav>
</header>

<main id="main" tabindex="-1">
