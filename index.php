<?php
date_default_timezone_set('Europe/Moscow');
require_once './helpers.php';
require_once './db_helpers.php';

$is_auth = rand(0, 1);

$user_name = ''; // укажите здесь ваше имя
function get_categories():Array {
    $query = 'SELECT * from categories';
    return get_data($GLOBALS['con'], $query);
};

function get_lots():Array {
    $query = '
        SELECT 
            name AS category,
            title,
            description,
            image_url,
            initial_cost,
            completion_date
        FROM lots l 
            JOIN categories c 
                ON c.id = l.category_id';
    return get_data($GLOBALS['con'], $query);
};

$page_content = include_template('main.php', [
    'categories' => get_categories(),
    'lots' => get_lots()
]);

$layout = [
    'title' => 'Главная',
    'content' => $page_content
];

$page = include_template('layout.php', $layout);
?>

<?=$page?>
