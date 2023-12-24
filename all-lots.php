<?php
/**
 * @var $categories array Категории лотов
 * @var $com mysqli Ресурс соединения
 */

require_once 'init.php';

$current_category_id = intval($_GET['category_id']);

$lots = get_lots_by_category($con, $current_category_id);

$page_content = include_template('all-lots.php', Array(
    'categories' => $categories,
    'lots' => $lots,
    'current_category' => get_category_name($con, $current_category_id)
));

$layout = [
    'title' => 'Главная',
    'categories' => $categories,
    'content' => $page_content,
    'user' => $user,
];

$page = include_template('layout.php', $layout);
?>

<?=$page?>
