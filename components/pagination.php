<ul class="pagination-list">
    <?php if (count($pages) > 1 && $current_page > 1):?>
        <li class="pagination-item pagination-item-prev">
            <a href="/all-lots.php?page=<?=$current_page - 1?>&category_id=<?=$category_id?>">Назад</a>
        </li>
    <?php endif;?>
        <?php foreach ($pages as $page): ?>
            <li class="pagination-item <?=$page == $current_page ? 'pagination-item-active' : ''?>">
                <a href=/all-lots.php?page=<?=$page?>&category_id=<?=$category_id?>>
                    <?=$page?>
                </a>
            </li>
        <?php endforeach;?>

    <?php if ($current_page != max($pages)):?>
        <li class="pagination-item pagination-item-next">
            <a href="/all-lots.php?page=<?=$current_page + 1?>&category_id=<?=$category_id?>">Вперед</a>
        </li>
    <?php endif;?>
    </ul>
