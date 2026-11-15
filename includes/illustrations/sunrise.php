<div class="illus illus-sunrise" aria-hidden="true">
    <svg viewBox="0 0 600 600" preserveAspectRatio="xMidYMid meet">
        <g class="sun-rays">
            <?php for ($i = 0; $i < 18; $i++): ?>
                <line x1="300" y1="70" x2="300" y2="20" transform="rotate(<?= $i * 20 ?> 300 300)"/>
            <?php endfor; ?>
        </g>
        <circle class="sun-halo" cx="300" cy="300" r="210"/>
        <circle class="sun-core" cx="300" cy="300" r="160"/>
    </svg>
    <span class="floating-dot fd-1"></span>
    <span class="floating-dot fd-2"></span>
    <span class="floating-dot fd-3"></span>
</div>
