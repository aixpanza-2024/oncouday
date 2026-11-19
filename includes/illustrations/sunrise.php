<div class="illus illus-sunrise" aria-hidden="true">
    <svg viewBox="0 0 600 600" preserveAspectRatio="xMidYMid meet">
        <defs>
            <linearGradient id="logoRay" x1="0" y1="1" x2="0" y2="0">
                <stop offset="0" stop-color="#ffa23f" stop-opacity=".55"/>
                <stop offset="1" stop-color="#ffa23f" stop-opacity="0"/>
            </linearGradient>
        </defs>
        <g class="sun-rays">
            <?php for ($i = 0; $i < 18; $i++): ?>
                <line x1="300" y1="70" x2="300" y2="20" transform="rotate(<?= $i * 20 ?> 300 300)"/>
            <?php endfor; ?>
        </g>
        <circle class="sun-halo" cx="300" cy="300" r="210"/>
        <circle class="sun-core" cx="300" cy="300" r="160"/>
        <g class="logo-rays">
            <?php for ($i = 0; $i < 24; $i++): $tip = $i % 2 ? 120 : 95; ?>
                <polygon points="294,175 306,175 300,<?= $tip ?>" fill="url(#logoRay)" transform="rotate(<?= $i * 15 ?> 300 300)"/>
            <?php endfor; ?>
        </g>
        <image class="sun-logo" href="<?= e(asset('img/logo-512.png')) ?>" x="180" y="180" width="240" height="240"/>
    </svg>
    <span class="floating-dot fd-1"></span>
    <span class="floating-dot fd-2"></span>
    <span class="floating-dot fd-3"></span>
</div>
