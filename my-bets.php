<?php
/**
 * @var $con mysqli - Ресурс соединения
 * @var $categories array - Категории из БД
 */

require_once 'init.php';

if (!isset($user)) {
    http_response_code(403);
    exit();
}

$query = 'SELECT
    l.id as lot_id,
    title,
    l.user_id as author,
    category_id,
    c.name as category,
    image_url,
    b.creation_date
FROM lots l
         JOIN categories c on l.category_id = c.id
         JOIN bets b on l.id = b.lot_id
WHERE l.id IN
      (SELECT lot_id FROM bets WHERE user_id = ' . $user['id'] . ')';

$result = mysqli_query($con, $query);
$user_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);

$page_vars = array(
    'categories' => $categories,
    'bets' => $user_bets
);
$page_content = include_template('my-bets.php', $page_vars);

$layout = array(
    'title' => 'Главная',
    'categories' => $categories,
    'content' => $page_content,
    'user' => $user
);

$page = include_template('layout.php', $layout);
?>

<?= $page ?>
