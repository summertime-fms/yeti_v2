<?php
require 'ACCESSES.php';

extract($con_params);
$con = mysqli_connect($host, $user, $password, $db_name);
$GLOBALS['con'] = $con;

if (!$con) {
    $error = mysqli_connect_error();
    print_r('Ошибка MySQL:' . $error);
    die;
}

mysqli_set_charset($con, "utf8");

/**
 * Выполняет sql-запрос, возвращающий данные в виде ассоциативного массива
 *
 * @param $con mysqli Ресурс соединения
 * @param $query string SQL запроc
 *
 * @return Array Массив с данными
 */
function get_data($con, $query):Array {
  $res = mysqli_query($con, $query);
  return mysqli_fetch_all($res, MYSQLI_ASSOC);
};

/**
 * Возвращает категории лотов из БД
 * @return Array Массив с категориями
 */
function get_categories():Array {
    $query = 'SELECT * from categories';
    return get_data($GLOBALS['con'], $query);
};

/**
 * Возвращает все активные лоты из БД
 * @return Array Массив с лотами
 */
function get_lots():Array {
    $now = date('Y-m-d H:m:s');
    $query = "
        SELECT 
            l.id,
            name AS category,
            title,
            description,
            image_url,
            initial_cost,
            completion_date,
            creation_date
        FROM lots l
            JOIN categories c
                ON c.id = l.category_id 
        WHERE completion_date > '$now'
        ORDER BY creation_date DESC";
    return get_data($GLOBALS['con'], $query);
};


/**
 * Возвращает данные конкретного лота
 *
 * @param $id int айдишник лота
 *
 * @return Array Данные лота
 */
function get_lot(int $id):Array | null {
    $query = '
        SELECT
            l.id,
            title,
            name AS category,
            description,
            image_url,
            initial_cost,
            completion_date,
            creation_date
        FROM lots l
        JOIN categories c
                ON c.id = l.category_id 
                WHERE l.id = '.$id.'
    ';

    $res = mysqli_query($GLOBALS['con'], $query);
    return mysqli_fetch_assoc($res);

//    return get_data($GLOBALS['con'], $query);
};
