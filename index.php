<?php
date_default_timezone_set('Europe/Moscow');
require_once './helpers.php';
$is_auth = rand(0, 1);

$user_name = ''; // укажите здесь ваше имя
$categories = [
    'Доски и лыжи',
    'Крепления',
    'Ботинки',
    'Одежда',
    'Инструменты',
    'Разное'
];


$lots = [
    [
        'title' => '2014 Rossignol District Snowboard',
        'cat' => 'Доски и лыжи',
        'cost' => 121,
        'image_url' => 'img/lot-1.jpg',
        'deadline' => '2023-09-06'
    ],
    [
        'title' => 'DC Ply Mens 2016/2017 Snowboard',
        'cat' => 'Доски и лыжи',
        'cost' => 159999,
        'image_url' => 'img/lot-2.jpg',
        'deadline' => '2023-12-11'
    ],
    [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'cat' => 'Крепления',
        'cost' => 8000,
        'image_url' => 'img/lot-3.jpg',
        'deadline' => '2023-12-13'
    ],
    [
        'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'cat' => 'Ботинки',
        'cost' => 10999,
        'image_url' => 'img/lot-4.jpg',
        'deadline' => '2023-12-3'
    ],
    [
        'title' => 'Куртка для сноуборда DC Mutiny Charocal',
        'cat' => 'Одежда',
        'cost' => 7500,
        'image_url' => 'img/lot-5.jpg',
        'deadline' => '2023-12-15'
    ],
    [
        'title' => 'Маска Oakley Canopy',
        'cat' => 'Разное',
        'cost' => 5400,
        'image_url' => 'img/lot-6.jpg',
        'deadline' => '2023-12-1'
    ]
];

$page_content = include_template('main.php', [
    'categories' => $categories,
    'lots' => $lots
]);

$layout = [
        'title' => 'Главная',
        'content' => $page_content
];

$page = include_template('layout.php', $layout);
?>

<?php //=strtotime($lots[0]['deadline'])?>

<?=$page?>
