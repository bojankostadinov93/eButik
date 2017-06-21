<?php
define('BASEURL',$_SERVER['DOCUMENT_ROOT'].'/eButik/');
define('CART_COOKIE', 'SBwi72UCklwiqzz2');//definira ga imeto na kolaceto
define('CART_COOKIE_EXPIRE',time()+(86400*30));//vreme mu zadava kolku da trae valjda 30 dena
define('TAXRATE',0,087);

define('CURRENCY', 'usd');
define('CHECKOUTMODE','TEST');


if(CHECKOUTMODE=='TEST'){
    define('STRIPE_PRIVATE','sk_test_3pWpDx6Kf6edWAnCBmyu5QDd');
    define('STRIPE_PUBLIC','pk_test_RmvC523dXhmp1QNXywTlERcf');
}

?>