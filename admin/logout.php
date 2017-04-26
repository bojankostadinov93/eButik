<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/eButik/core/init.php';
unset($_SESSION['SBUser']);
header('Location:login.php');
?>