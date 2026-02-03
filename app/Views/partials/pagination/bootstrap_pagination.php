<?php
$links = $pager->links();
if (empty($links)) {
    return;
}
?>

<nav aria-label="Pagination">
    <ul class="pagination pagination-sm mb-0 justify-content-end">

        <?php foreach ($links as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>">
                    <?= esc($link['title']) ?>
                </a>
            </li>
        <?php endforeach ?>

    </ul>
</nav>