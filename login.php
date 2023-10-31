<?php

require_once 'init.php';
require_once 'validation.php';


$page_content = include_template('login.php', Array());

$layout = [
    'title' => 'Вход',
    'categories' => $categories,
    'content' => $page_content
];

$page = include_template('layout.php', $layout);
echo $page;
