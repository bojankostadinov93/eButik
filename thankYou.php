<?php
require_once 'core/init.php';





if (isset($_POST['name'])) {
    $name = $_POST['name'];
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

$cardQ=$db->query("SELECT * FROM cards");
$card=mysqli_fetch_assoc($cardQ);


if(empty($name)||empty($number)||empty($cvc)||empty($exp_month)||empty($exp_year)){
echo 'Потполнете ги сите полиња';
}

if($name==$card['full_name'] && $number==$card['card_number'] && $cvc==$card['cvc'] && $exp_month=$card['exp_month']&& $exp_year==$card['exp_year']){
    $full_name=sanitize($_POST['full_name']);
    $email=sanitize($_POST['email']);
    $street=sanitize($_POST['street']);
    $street2=sanitize($_POST['street2']);
    $city=sanitize($_POST['city']);
    $state=sanitize($_POST['state']);
    $zip_code=sanitize($_POST['zip_code']);
    $country=sanitize($_POST['country']);
    $tax=sanitize($_POST['tax']);
    $sub_total=sanitize($_POST['sub_total']);
    $grand_total=sanitize($_POST['grand_total']);
    $cart_id=sanitize($_POST['cart_id']);
    $description=sanitize($_POST['description']);
    $charge_amount=number_format($grand_total,2)*100;
    $metadata=array(
        "cart_id"  => $cart_id,
        "tax"  => $tax,
        "sub_total"  => $sub_total,

    ); $insert_transaction=$db->query("INSERT INTO transactions (charge_id,cart_id,full_name,email,street,street2,city,state,zip_code,country,sub_total,grand_total,tax,description)
              VALUES ( '','$cart_id','$full_name','$email','$street','$street2','$city','$state','$zip_code','$country','$sub_total','$grand_total','$tax','$description')");
    $update_cart=$db->query("UPDATE cart SET paid=1 WHERE id='{$cart_id}'");

    $domain=($_SERVER['HTTP_HOST'] !='localhost')?'.'.$_SERVER['HTTP_HOST']:false;
    $domain=false;
    setcookie(CART_COOKIE,'',1,"/",'localhost',false);
    include 'includes/head.php';
    include 'includes/navigation.php';
    include 'includes/headerpartial.php';
    ?>
    <h1 class="text-center text-success">Ви благодарам </h1>
    <p>Од вашата картичка е направена успешна трансакција од <?=money($grand_total);?>.</p>
    <p>Вашиот приемен број е:<strong><?=$cart_id;?></strong></p>
    <p>Нарачката ќе ви биде доставена на вашата адреса.</p>
    <address>
        <?=$full_name;?><br>
        <?=$street;?><br>
        <?=(($street2 !='')?$street2.'<br>':'')?>
        <?=$city.','.$state.' '.$zip_code;?><br>
        <?=$country;?><br>
    </address>

<?php
    }else{
        echo 'Внесете валидна картичка';
}


/*$full_name=sanitize($_POST['name']);
$number=$_POST['number'];
$cvc=$_POST['cvc'];
$exp_month=$_POST['exp_month'];
$exp_year=$_POST['exp_year'];

$cardQ=$db->query("SELECT * FROM cards");
$card=mysqli_fetch_assoc($cardQ);

if($full_name==$card['full_name'] && $number==$card['number'] && $cvc==$card['cvc'] && $exp_month=$card['exp_month']&& $exp_year==$card['exp_year']){
    echo 'Vasata karticka e validna';
}else{
    echo 'Ve molime vnesete validna karticka';
}



// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
*/
/*\Stripe\Stripe::setApiKey ('sk_test_3pWpDx6Kf6edWAnCBmyu5QDd');

// Token is created using Stripe.js or Checkout!
// Get the payment token submitted by the form:
$token = $_POST['stripeToken'];

$full_name=sanitize($_POST['full_name']);
$email=sanitize($_POST['email']);
$street=sanitize($_POST['street']);
$street2=sanitize($_POST['street2']);
$city=sanitize($_POST['city']);
$state=sanitize($_POST['state']);
$zip_code=sanitize($_POST['zip_code']);
$country=sanitize($_POST['country']);
$tax=sanitize($_POST['tax']);
$sub_total=sanitize($_POST['sub_total']);
$grand_total=sanitize($_POST['grand_total']);
$card_id=sanitize($_POST['card_id']);
$description=sanitize($_POST['description']);
$charge_amount=number_format($grand_total,2)*100;
$metadata=array(
    "card_id"  => $card_id,
    "tax"  => $tax,
    "sub_total"  => $sub_total,

);



// Charge the user's card:
$charge = \Stripe\Charge::create(array(
    "amount" => $charge_amount,
    "currency" => "usd",
    "description" => $description,
    "source" => $token,
    "receipt_email"=>$email,
    "metadata"=>$metadata

));
$db->query("UPDATE cart SET paid=1 WHERE id='{$card_id}'");
$db->query("INSERT INTO tansactions (charge_id,cart_id,full_name,email,street,street2,city,state,zip_code,country,sub_total,grand_total,tax,description,txn_type)
              VALUES ('$charge->id','$card_id','$full_name','$email','$street','$street2','$city','$state','$zip_code','$country','$sub_total','$grand_total','$tax','$description','$charge->object')_");
$domain=($_SERVER['HTTP_HOST'] !='localhost')?'.'.$_SERVER['HTTP_HOST']:false;
setcookie(CART_COOKIE,'',1,"/",$domain,false);
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';
?>
    <h1 class="text-center text-success">Ви благодарам </h1>
    <p>Од вашата картичка е направена успешна трансакција од <?=money($grand_total);?>.</p>
    <p>Вашиот приемен број е:<strong><?=$card_id;?></strong></p>
    <p>Нарачката ќе ви биде доставена на вашата адреса.</p>
    <address>
        <?=$full_name;?><br>
        <?=$street;?><br>
        <?=(($street2 !='')?$street2.'<br>':'')?>
        <?=$city.','.$state.' '.$zip_code;?><br>
        <?=$country;?><br>
    </address>




\Stripe\Stripe::setApiKey(STRIPE_PRIVATE);

$token=$_POST['stripeToken'];

$full_name=sanitize($_POST['full_name']);
$email=sanitize($_POST['email']);
$street=sanitize($_POST['street']);
$street2=sanitize($_POST['street2']);
$city=sanitize($_POST['city']);
$state=sanitize($_POST['state']);
$zip_code=sanitize($_POST['zip_code']);
$country=sanitize($_POST['country']);
$tax=sanitize($_POST['tax']);
$sub_total=sanitize($_POST['sub_total']);
$grand_total=sanitize($_POST['grand_total']);
$card_id=sanitize($_POST['card_id']);
$description=sanitize($_POST['description']);
$charge_amount=number_format($grand_total,2)*100;
$metadata=array(
    "card_id"  => $card_id,
    "tax"  => $tax,
    "sub_total"  => $sub_total,

);

try{
    $charge=\Stripe\Charge::create(array(
        "amount" =>$charge_amount,
        "currency"  =>CURRENCY,
        "source" =>$token,
        "description"=>$description,
        "receipt_email"=>$email,
        "metadata"=>$metadata
    ));
    $db->query("UPDATE cart SET paid=1 WHERE id='{$card_id}'");
    $db->query("INSERT INTO tansactions (charge_id,cart_id,full_name,email,street,street2,city,state,zip_code,country,sub_total,grand_total,tax,description,txn_type)
              VALUES ('$charge->id','$card_id','$full_name','$email','$street','$street2','$city','$state','$zip_code','$country','$sub_total','$grand_total','$tax','$description','$charge->object')_");
    $domain=($_SERVER['HTTP_HOST'] !='localhost')?'.'.$_SERVER['HTTP_HOST']:false;
    setcookie(CART_COOKIE,'',1,"/",$domain,false);
    include 'includes/head.php';
    include 'includes/navigation.php';
    include 'includes/headerpartial.php';
?>
<h1 class="text-center text-success">Ви благодарам </h1>
    <p>Од вашата картичка е направена успешна трансакција од <?=money($grand_total);?>.</p>
    <p>Вашиот приемен број е:<strong><?=$card_id;?></strong></p>
    <p>Нарачката ќе ви биде доставена на вашата адреса.</p>
    <address>
            <?=$full_name;?><br>
            <?=$street;?><br>
            <?=(($street2 !='')?$street2.'<br>':'')?>
            <?=$city.','.$state.' '.$zip_code;?><br>
            <?=$country;?><br>
    </address>
<?php/*
    include 'includes/footer.php';
}catch (\Stripe\Error\Card $e){
    echo $e;
}*/