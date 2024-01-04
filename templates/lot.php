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
            <?php if(isset($user) && $user['id'] !== $lot['user_id']):?>
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
                        Мин. ставка <span><?=format_cost($min_bet)?></span>
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

            <?php
            $bets = $lot['bets'];
            if ($bets):?>

            <div class="history">
                <h3>История ставок (<span>10</span>)</h3>
                <table class="history__list">
                    <?php
                            foreach ($bets as $bet):
                    ?>

                    <tr class="history__item">
                        <td class="history__name"><?=$bet['user_name']?></td>
                        <td class="history__price"><?=format_cost($bet['cost'])?></td>
                        <td class="history__time"><?=get_passed_time($bet['creation_date'])?></td>
                    </tr>

                    <?php endforeach;?>
                </table>
            </div>
            <?php endif;?>
        </div>
    </div>
</section>
