<?php
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
        'image_url' => 'img/lot-1.jpg'
    ],
    [
        'title' => 'DC Ply Mens 2016/2017 Snowboard',
        'cat' => 'Доски и лыжи',
        'cost' => 159999,
        'image_url' => 'img/lot-2.jpg'
    ],
    [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'cat' => 'Крепления',
        'cost' => 8000,
        'image_url' => 'img/lot-3.jpg'
    ],
    [
        'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'cat' => 'Ботинки',
        'cost' => 10999,
        'image_url' => 'img/lot-4.jpg'
    ],
    [
        'title' => 'Куртка для сноуборда DC Mutiny Charocal',
        'cat' => 'Одежда',
        'cost' => 7500,
        'image_url' => 'img/lot-5.jpg'
    ],
    [
        'title' => 'Маска Oakley Canopy',
        'cat' => 'Разное',
        'cost' => 5400,
        'image_url' => 'img/lot-6.jpg'
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

<?=$page?>
