<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/eButik/core/init.php';
$name=sanitize($_POST['full_name']);
$email=sanitize($_POST['email']);
$street=sanitize($_POST['street']);
$street2=sanitize($_POST['street2']);
$city=sanitize($_POST['city']);
$state=sanitize($_POST['state']);
$zip_code=sanitize($_POST['zip_code']);
$country=sanitize($_POST['country']);
$errors=array();
$required=array(
    'full_name'  => 'Full Name',
    'email'      =>'Email',
    'street'     =>'Street',
    'city'       =>'City',
    'state'      =>'state',
    'zip_code'   =>'Zip code',
    'country'    =>'Country',
);
foreach($required as $f =>$d){
if(empty($_POST[$f]) || $_POST[$f]==''){
    $errors[]= $d.' е потребно.';
}
}
if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Ве молиме внесете валидна емаил адреса';
}
if(!empty($errors)){
    echo display_errors($errors);
}else{
    echo'passed';
}



?>