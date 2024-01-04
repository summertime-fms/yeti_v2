<?php
/**
 * @var $con mysqli - Ресурс соединения
 * @var $categories array - Категории из БД
 */

require_once 'init.php';
require_once 'validation.php';

$lot_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) ?? '';

$lot = null;
if (!$lot_id) {
    http_response_code(404);
    header('Location: 404.php');
    die;
} else {
    $lot = get_lot(intval($lot_id), $con);
}

if (!$lot) {
    header('Location: 404.php');
    exit();
}

$lot['actual_cost'] = $lot['bets'] ? end($lot['bets'])['cost'] : $lot['initial_cost'];
$min_bet = $lot['actual_cost'] + $lot['bid_step'];

$page_vars = Array(
    'lot' => $lot,
    'categories' => $categories,
    'user' => $user,
    'min_bet' => $min_bet
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bet = filter_input(INPUT_POST, 'bet',FILTER_SANITIZE_SPECIAL_CHARS);
    $errors = validate_fields(
        Array('bet' => $bet),
        $validation_rules,
        Array('bet' => Array('min_bet' => $min_bet))
    );
    $errors = array_filter($errors);
    if (count($errors) > 0) {
        $page_vars['errors'] = $errors;
    }
}


$page_content = include_template('lot.php', $page_vars);

$layout = Array(
    'title' => 'Главная',
    'categories' => $categories,
    'content' => $page_content,
    'user' => $user
);

$page = include_template('layout.php', $layout);
?>

<?=$page?>
