<?php
// TAB PROSES BISNIS - CONTENT WRAPPER
?>

<div class="pk-proses-bisnis">
    <div id="pkProsesBisnisTableWrapper">
        <?= view('penetapan_konteks/tabs/proses_bisnis/_table_section', [
            'data' => $selectedProsesData ?? []
        ]) ?>
    </div>
</div>