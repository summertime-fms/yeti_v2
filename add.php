<?php

require_once './helpers.php';
require_once './db_helpers.php';

$cats = get_categories();

$args = Array(
    'lot-name' => FILTER_SANITIZE_SPECIAL_CHARS,
    'category' => FILTER_SANITIZE_NUMBER_INT,
    'message' => FILTER_SANITIZE_SPECIAL_CHARS,
    'lot-rate' => FILTER_SANITIZE_NUMBER_INT,
    'lot-step' => FILTER_SANITIZE_NUMBER_INT,
    'lot-date' => FILTER_SANITIZE_SPECIAL_CHARS
);

function validate_fields(Array $fields, Array $rules): Array {
    $errors = Array();
    $required_fields = Array(
        'lot-name',
        'category',
        'message',
        'lot-rate',
        'lot-step',
        'lot-date',
    );

    foreach ($fields as $name => $val) {
        if (in_array($name, $required_fields) && strlen($val) == 0) {
            $errors[$name] = 'Пожалуйста, заполните это поле.';
        } else {
            if (isset($rules[$name])) {
                $fn = $rules[$name];
                $errors[$name] = $fn($val);
            }
        }
    }

    return $errors;
};

$page_data = Array(
    'categories' => $cats,
);

$input = filter_input_array(INPUT_POST, $args);

if ($input) {
    $lot_image = $_FILES['lot-img'];
    $input['img'] = $lot_image;
    $errors = validate_fields($input, $validation_rules);
    $errors = array_filter($errors);
    if (!empty($errors)) {
        $page_data['errors'] = $errors;
    } else {
        $file_url = save_file($input['img']);

        $data = Array(
            $input['lot-name'],
            1,
            date('Y-m-d H:m:s'),
            $input['category'],
            $input['message'],
            $file_url,
            $input['lot-rate'],
            $input['lot-step'],
            $input['lot-date']
        );
        $sql = 'INSERT INTO lots (
                  title,
                  user_id,
                  creation_date,
                  category_id,
                  description,
                  image_url,
                  initial_cost,
                  bid_step,
                  completion_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($GLOBALS['con'], $sql, $data);
        mysqli_stmt_execute($stmt);
        $id = mysqli_insert_id($GLOBALS['con']);
        header('Location: lot.php?id='.$id);
    }
}

$page_content = include_template('add-lot.php', $page_data);

$layout = Array(
    'title' => 'Добавление лота',
    'categories'=> $cats,
    'content'=>$page_content,
);

$page = include_template('layout.php', $layout);

echo $page;
