<?php
require_once './helpers.php';
require_once './db_helpers.php';

$lot_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?? '';
$lot = null;
if (!$lot_id) {
    http_response_code(404);
    header('Location: 404.php');
    die;
} else {
    $lot = get_lot(intval($lot_id));
}

if (!$lot) {
    header('Location: 404.php');
    die;
}

$cats = get_categories();

$page_content = include_template('lot.php', Array(
    'lot' => $lot,
    'categories' => $cats,
));

// TODO:при отсутствии параметра id - перенаправлять на 404
// TODO:при несуществующем id - сообщать об отсутствии такого лота/истечении его срока

$layout = [
    'title' => 'Главная',
    'categories' => $cats,
    'content' => $page_content
];

$page = include_template('layout.php', $layout);
?>

<?=$page?>
