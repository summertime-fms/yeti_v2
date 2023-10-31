<?php

require_once 'init.php';
require_once 'validation.php';

$page_data = Array();

$args = Array(
    'email' => FILTER_DEFAULT,
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
    } else {
        $data = Array(
            date('Y-m-d H:m:s'),
            $input['email'],
            $input['name'],
            password_hash($input['password'], PASSWORD_DEFAULT),
            $input['message']
        );
        $sql = 'INSERT INTO users (
                   registration_date,
                   email,
                   name,
                   password,
                   contact_info)
                VALUES (?, ?, ?, ?, ?)';


        $stmt = db_get_prepare_stmt($GLOBALS['con'], $sql, $data);
        mysqli_stmt_execute($stmt);
        $error = mysqli_error($GLOBALS['con']);
        if ($error) {
            echo 'Ошибка MYSQL:' . $error;
        } else {
            header('Location: login.php');
            exit();
        }
    }
}

$page_content = include_template('sign-up.php', $page_data);

$layout = Array(
    'title' => 'Регистрация',
    'content' => $page_content,
    'categories' => $categories
);

$page = include_template('layout.php', $layout);

echo $page;
