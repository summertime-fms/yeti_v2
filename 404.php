<?php
/**
 * @var $categories array - Категории из БД
 */
require_once 'init.php';

$page_content = include_template('404.php', array(
    'categories' => $categories,
));

$layout = array(
    'title' => 'Ошибка 404',
    'content' => $page_content,
    'categories' => $categories
);

$page = include_template('layout.php', $layout);
echo $page;

