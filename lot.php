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
    $is_able_to_bet = empty(array_filter($lot['bets'], function ($bet) {
        return $bet['user_id'] === $_SESSION['user']['id'];
    }));
}

if (!$lot) {
    header('Location: 404.php');
    exit();
}

$lot['actual_cost'] = $lot['bets'] ? end($lot['bets'])['cost'] : $lot['initial_cost'];
$min_bet = $lot['actual_cost'] + $lot['bid_step'];
$lot_id = $_GET['id'];

$page_vars = array(
    'lot' => $lot,
    'categories' => $categories,
    'user' => $user,
    'min_bet' => $min_bet,
    'is_able_to_bet' => $is_able_to_bet
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bet = filter_input(INPUT_POST, 'bet', FILTER_SANITIZE_SPECIAL_CHARS);
    $errors = validate_fields(
        array('bet' => $bet),
        $validation_rules,
        array('bet' => array('min_bet' => $min_bet))
    );
    $errors = array_filter($errors);
    if (count($errors) > 0) {
        $page_vars['errors'] = $errors;
    } else {
        $date = date('Y-m-d H:i:s');
        $data = array(
            $date,
            $bet,
            $user['id'],
            $lot_id,
        );
        $sql = 'INSERT INTO bets (
                  creation_date, cost, user_id, lot_id)
                VALUES (?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($con, $sql, $data);
        mysqli_stmt_execute($stmt);
        $error = mysqli_error($con);
        if ($error) {
            echo 'Ошибка MYSQL:' . $error;
        } else {
            header('Location: lot.php?id=' . $lot_id);
            exit();
        }
    }
}
$page_content = include_template('lot.php', $page_vars);

$layout = array(
    'title' => 'Главная',
    'categories' => $categories,
    'content' => $page_content,
    'user' => $user
);

$page = include_template('layout.php', $layout);
?>

<?= $page ?>
