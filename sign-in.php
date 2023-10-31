<?php

require_once './helpers.php';
require_once './db_helpers.php';

$cats = get_categories();

$page_data = Array();


$page = include_template('layout.php', $page_data);
echo $page;
