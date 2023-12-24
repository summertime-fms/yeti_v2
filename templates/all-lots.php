<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $cat): ?>
            <li class="nav__item <?=intval($_GET['category_id']) == $cat['id'] ? 'nav__item--current': ''?>">
                <a href="/all-lots.php?category_id=<?=$cat['id']?>"><?=$cat["name"]?></a>
            </li>
        <?php endforeach;?>
    </ul>
</nav>
<div class="container">
    <section class="lots">
        <h2>Все лоты в категории <span><?=$current_category?></span></h2>
        <ul class="lots__list">
            <?php foreach ($lots as $lot): ?>
                <?php $formatted_time = format_time($lot['completion_date']) ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?=htmlspecialchars($lot['image_url'])?>" width="350" height="260" alt="<?=htmlspecialchars($lot['title']) ?? ''?>">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?=htmlspecialchars($lot['category']) ?? ''?></span>
                        <h3 class="lot__title">
                            <a class="text-link" href="lot.php?id=<?=$lot['id']?>"><?=htmlspecialchars($lot['title']) ?? ''?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount"></span>
                                <span class="lot__cost"><?=htmlspecialchars(format_cost($lot['initial_cost']))?></span>
                            </div>
                            <div class="lot__timer timer">
                                <?=$formatted_time[0]?> : <?=$formatted_time[1]?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>

        </ul>
    </section>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
</div>
