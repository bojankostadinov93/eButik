<?php
$db= mysqli_connect ('127.0.0.1', 'root', '', 'butik');
if(mysqli_connect_errno()){
    echo 'Извинете, не е конектирано со датабазата:'.mysqli_connect_error();
    die();
}
require_once $_SERVER['DOCUMENT_ROOT'].'/eButik/config.php';
require_once BASEURL.'helpers/helpers.php';



?>