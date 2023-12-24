<?php

require_once 'init.php';

$args = array(
    'search' => FILTER_SANITIZE_SPECIAL_CHARS,
);


$page_data = array(
    'categories' => $categories
);

function search_lots($search, $con) {
    $now = date('Y-m-d H:m:s');

    echo $search;

    $sql = "SELECT l.id, l.category_id, l.description, l.title, l.image_url, l.initial_cost, c.id, l.completion_date
FROM lots l
JOIN categories c on l.category_id = c.id
WHERE MATCH(l.title,l.description) AGAINST('{$search}*' IN BOOLEAN MODE) AND l.completion_date > CURRENT_DATE;
";
    $res = mysqli_query($con, $sql);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $input = filter_input_array(INPUT_GET, $args);

    if ($input) {
        $page_data['search_value'] = $input['search'];
        $lots = search_lots($input['search'], $con);
//        echo var_dump($lots);
        if (!empty($lots)) {
            $page_data['lots'] = $lots;
        }
    } else {

    }
}

$page_content = include_template('search.php', $page_data);

$layout = [
    'title' => 'Вход',
    'categories' => $categories,
    'content' => $page_content
];

$page = include_template('layout.php', $layout);
echo $page;
