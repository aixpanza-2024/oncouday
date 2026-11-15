<div class="illus illus-radar" aria-hidden="true">
    <svg viewBox="0 0 240 240">
        <defs>
            <linearGradient id="sweepGrad" x1="0" y1="0" x2="1" y2="0">
                <stop offset="0" stop-color="#f7891c" stop-opacity="0"/>
                <stop offset="1" stop-color="#f7891c" stop-opacity=".45"/>
            </linearGradient>
        </defs>
        <circle class="radar-bg" cx="120" cy="120" r="112"/>
        <circle class="radar-ring" cx="120" cy="120" r="84"/>
        <circle class="radar-ring" cx="120" cy="120" r="56"/>
        <circle class="radar-ring" cx="120" cy="120" r="28"/>
        <line class="radar-ring" x1="8" y1="120" x2="232" y2="120"/>
        <line class="radar-ring" x1="120" y1="8" x2="120" y2="232"/>
        <g class="radar-sweep">
            <path d="M120 120 L232 120 A112 112 0 0 0 199 41 Z" fill="url(#sweepGrad)"/>
            <line x1="120" y1="120" x2="232" y2="120" class="radar-arm"/>
        </g>
        <circle class="blip b1" cx="70" cy="66" r="7"/>
        <circle class="blip b2" cx="96" cy="182" r="5"/>
        <circle class="blip b3" cx="170" cy="172" r="5"/>
        <circle class="blip b4" cx="182" cy="76" r="3"/>
        <circle class="radar-center" cx="120" cy="120" r="7"/>
    </svg>
</div>
