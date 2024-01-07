<?php
/**
 * @var $categories array Категории лотов
 * @var $com mysqli Ресурс соединения
 */

require_once 'init.php';
const PER_PAGE = 2;

function get_lots_count($con, $current_category)
{
    $date_now = date('Y-m-d H:m:s');
    $query = "SELECT COUNT(*) as total
                from lots l
                    JOIN categories c
                        ON l.category_id = c.id 
                WHERE c.id = {$current_category} AND l.completion_date > '{$date_now}'";
    $result = mysqli_query($con, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}


$current_page = $_GET['page'] ?? 1;
$offset = PER_PAGE * ($current_page - 1);

$current_category_id = intval($_GET['category_id']);
$now = date('Y-m-d H:m:s');
$query = "
    SELECT 
        l.id,
        name AS category,
        title,
        description,
        image_url,
        initial_cost,
        completion_date,
        creation_date
    FROM lots l
        JOIN categories c
            ON c.id = l.category_id 
    WHERE completion_date > '$now'
    AND l.category_id = {$current_category_id}
    ORDER BY creation_date DESC
        LIMIT " . PER_PAGE . " OFFSET " . $offset;

$lots = get_data($con, $query);
$total_count = get_lots_count($con, $current_category_id);
$pages_count = ceil($total_count / PER_PAGE);
$pages = range(1, $pages_count);

$page_content = include_template('all-lots.php', array(
    'categories' => $categories,
    'lots' => $lots,
    'current_category' => get_category_name($con, $current_category_id),
    'category_id' => $current_category_id,
    'pages' => $pages,
    'current_page' => $current_page
));

$layout = [
    'title' => 'Главная',
    'categories' => $categories,
    'content' => $page_content,
    'user' => $user,
];

$page = include_template('layout.php', $layout);
?>

<?= $page ?>
