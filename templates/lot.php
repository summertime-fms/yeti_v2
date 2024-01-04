<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $cat): ?>

            <li class="nav__item">
                <a href="/all-lots.php?category_id=<?=$cat['id']?>"><?=$cat["name"]?></a>
            </li>
        <?php endforeach;?>
    </ul>
</nav>


<section class="lot-item container">
    <h2><?=$lot["title"]?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?=$lot["image_url"]?>" width="730" height="548" alt="<?=$lot["title"]?>">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot["category"]?></span></p>
            <p class="lot-item__description"><?=$lot["description"]?></p>
        </div>
        <div class="lot-item__right">
            <?php $formatted_time = format_time($lot['completion_date']);
            $extra_class = $formatted_time[0] < 1 ? 'timer--finishing' : '';
            ?>
            <?php if(isset($user)):?>
            <div class="lot-item__state">
                <div class="lot-item__timer timer <?=$extra_class?>">
                    <?= $formatted_time[0]?> : <?=$formatted_time[1]?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=$lot['actual_cost']?></span>
                    </div>

                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=$min_bet?> р</span>
                    </div>
                </div>
                <form class="lot-item__form" action="/lot.php?id=<?=$_GET['id']?>" method="post" autocomplete="off">
                    <?php
                        $invalid_class = isset($errors['bet']) ? 'form__item--invalid' : '';
                    ?>
                    <p class="lot-item__form-item form__item <?=$invalid_class?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" name="bet" placeholder="<?=$min_bet?>">
                        <?php if (isset($errors['bet'])): ?>
                            <span class="form__error"><?=$errors['bet']?></span>
                        <?php endif;?>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <?php endif;?>
            <div class="history">
                <h3>История ставок (<span>10</span>)</h3>
                <table class="history__list">
                    <tr class="history__item">
                        <td class="history__name">Иван</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">5 минут назад</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Константин</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">20 минут назад</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Евгений</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">Час назад</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Игорь</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 08:21</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Енакентий</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 13:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Семён</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 12:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Илья</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 10:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Енакентий</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 13:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Семён</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 12:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Илья</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 10:20</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>
