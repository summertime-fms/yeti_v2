<?php
require_once './helpers.php';
require_once './db_helpers.php';

$cats = get_categories();
$page_content = include_template('404.php', Array(
    'categories' => $cats,
));

$layout = Array(
    'title' => 'Ошибка 404',
    'content' => $page_content,
    'categories'=> $cats
);

$page = include_template('layout.php', $layout);
echo $page;

