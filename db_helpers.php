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
function get_data($con, $query) {
  $res = mysqli_query($con, $query);
  return mysqli_fetch_all($res, MYSQLI_ASSOC);
};
