<?php
/**
 * Created by PhpStorm.
 * User: Bojan
 * Date: 5/11/2017
 * Time: 2:56 AM
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/eButik/core/init.php';



$product_id = isset($_POST['product_id'])? sanitize($_POST['product_id']):'';
$size = isset($_POST['size'])? sanitize($_POST['size']):'';
$avaliable = isset($_POST['available'])? sanitize($_POST['available']):'';
$quantity = isset($_POST['quantity'])? sanitize($_POST['quantity']):'';
$item=array();
$item[]=array(
    'id'        =>$product_id,
    'size'      =>$size,
    'quantity'  =>$quantity,
);

$domain=(($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);
$domain=false;

    $query=$db->query("SELECT * FROM products WHERE id='{$product_id}'");
    $product=mysqli_fetch_assoc($query);
    $_SESSION['success_flash']=$product['title'].' е додадена во вашата кошничка';

    //proverka dali  cart cookie postoe
if ($cart_id != '') {
        $cartQ=$db->query("SELECT * FROM cart WHERE id='$cart_id'");
        $cart=mysqli_fetch_assoc($cartQ);
        $previous_item=json_decode($cart['items'],true);
        $item_match=0;
        $new_items=array();
        foreach ($previous_item as $pitem){
            if($item[0]['id']==$pitem['id'] && $item[0]['size']==$pitem['size']){
                $pitem['quantity']=$pitem['quantity']+$item[0]['quantity'];
                if($pitem['quantity'] > $avaliable){
                    $pitem['quantity']=$avaliable;
                }
                $item_match=1;
            }
            $new_items[]=$pitem;
        }
        if($item_match !=1){
            $new_items=array_merge($item,$previous_item);//ovoa e za ti gi stae povekee proizvodi u kosnickata

        }

            $items_json=json_encode($new_items);
            $cart_expire=date("Y-m-d H:i:s",strtotime("+30 days"));
            $db->query("UPDATE cart SET  items='{$items_json}',expire_date='{$cart_expire}' WHERE id='$cart_id'");
            setcookie(CART_COOKIE,'',1,"/", "$domain",false);
        setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,"/", "$domain",false);

    }else{
        //dodavanje to databese  i set cookie
        $item_json=json_encode($item);
        $cart_expire= date("Y-m-d H:i:s",strtotime("+30 days"));
        $db->query("INSERT INTO cart (items,expire_date) VALUES('{$item_json}','{$cart_expire}')");
        $cart_id=$db->insert_id;
        setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/', "$domain",false );

    }

    ?>