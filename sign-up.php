<?php

require_once './helpers.php';
require_once './db_helpers.php';

$cats = get_categories();

$page_data = Array();

$args = Array(
    'email' => FILTER_SANITIZE_EMAIL,
    'password' => FILTER_DEFAULT,
    'name' => FILTER_SANITIZE_SPECIAL_CHARS,
    'message' => FILTER_SANITIZE_SPECIAL_CHARS
);

function validate_fields(array $fields, array $rules): array {
    $errors = Array();

    foreach ($fields as $name => $value) {
        if (isset($rules[$name])) {
            $fn = $rules[$name];
            $result = $fn($value);

            if (gettype($result) == 'string') {
                $errors[$name] = $result;
            }
        }

    }

    return $errors;
}

$errors = Array();

$input = filter_input_array(INPUT_POST, $args);
if ($input) {
    $errors = array_filter(validate_fields($input, $validation_rules));
    if (!empty($errors)) {
        $page_data['errors'] = $errors;
    }
}

$page_content = include_template('sign-up.php', $page_data);

$layout = Array(
    'title' => 'Регистрация',
    'content'=>$page_content,
    'categories' => $cats
);

$page = include_template('layout.php', $layout);

echo $page;
