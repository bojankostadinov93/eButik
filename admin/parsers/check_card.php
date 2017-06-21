<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/eButik/core/init.php';
if (isset($_POST['name'])) {
    $name_c = $_POST['name'];
}
if (isset($_POST['number'])) {
    $number = $_POST['number'];
}
if (isset($_POST['cvc'])) {
    $cvc = $_POST['cvc'];
}
if (isset($_POST['exp_month'])) {
    $exp_month = $_POST['exp_month'];
}
if (isset($_POST['exp_year'])) {
    $exp_year = $_POST['exp_year'];
}
$errors=array();
$required1=array(
    'name'  => 'Full Name',
    'number'      =>'Number',
    'cvc'     =>'Cvc',
    'exp_month'       =>'Exp_month',
    'exp_year'       =>'Exp_year',
);
foreach($required1 as $f =>$d) {
    if (empty($_POST[$f]) || $_POST[$f] == '') {
        $errors[] = $d . ' е потребно.';
    }
}
if(!empty($errors)){
    echo display_errors($errors);
}else{
    echo'passed';
}
?>