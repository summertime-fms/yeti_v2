<?php
date_default_timezone_set('Europe/Moscow');
require_once './helpers.php';
require_once './db_helpers.php';

$is_auth = rand(0, 1);
$cats = get_categories();
$user_name = ''; // укажите здесь ваше имя

$page_content = include_template('main.php', Array(
    'categories' => $cats,
    'lots' => get_lots()
));

$layout = [
    'title' => 'Главная',
    'categories' => $cats,
    'content' => $page_content
];

$page = include_template('layout.php', $layout);
?>

<?=$page?>
