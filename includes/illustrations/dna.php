<div class="illus illus-dna" aria-hidden="true">
    <?php for ($i = 0; $i < 48; $i++): ?>
        <span class="dna-pair" style="--d: <?= number_format($i * -0.12, 2) ?>s">
            <i class="dna-a"></i><i class="dna-b"></i>
        </span>
    <?php endfor; ?>
</div>
