<?php
require_once '../core/init.php';

if(!is_logged_in()){
    header('Location login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

//заврсена нарачка
if(isset($_GET['complete']) && $_GET['complete']==1){
    $cart_id =sanitize((int)$_GET['cart_id']);
    $db->query("UPDATE cart SET shipped=1 WHERE id='{$cart_id}'");
    $_SESSION['success_flash']="Нарачката е завршена";
    header('Location: index.php');
}

$txn_id=sanitize((int)$_GET['txn_id']);
$txnQuery= $db->query("SELECT * FROM transactions WHERE id='$txn_id'");
$txn=mysqli_fetch_assoc($txnQuery);
$cart_id=$txn['cart_id'];
$cartQ=$db->query("SELECT * FROM cart WHERE  id='{$cart_id}'");
$cart=mysqli_fetch_assoc($cartQ);
$items=json_decode($cart['items'],true);
$idArray=array();
$products=array();
foreach ($items as $item){
    $idArray[]=$item['id'];
}
$ids=implode(',',$idArray);//znaci ke ti gi dade samo id na productite so ti sa
$productQ=$db->query("SELECT i.id as 'id',i.title as 'title',c.id as 'cid',c.category as 'child',p.category as 'parent'
FROM products i
LEFT JOIN categories c ON i.categories = c.id
LEFT JOIN categories p ON c.parent = p.id
WHERE i.id IN ({$ids})
");
while($p=mysqli_fetch_assoc($productQ)){
    foreach ($items as $item){
        if($item['id']==$p['id']){
            $x=$item;
            continue;
        }
    }
    $products[]=array_merge($x,$p);
}

?>
<h2 class="text-center">Продукти за достава</h2>
<table class="table table-condensed table-bordered table-striped">
    <thead>
            <th>Количина</th>
            <th>Наслов</th>
            <th>Категорија</th>
            <th>Големина</th>

    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?=$product['quantity'];?></td>
            <td><?=$product['title'];?></td>
            <td><?=$product['parent'].'~'.$product['child'];?></td>
            <td><?=$product['size'];?></td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="row">
    <div class="col-md-6">
    <h3 class="text-center">Детали за достава</h3>
        <table class="table table-bordered table-condensed table-striped">
            <tbody>
            <tr>
                <td>Цена</td>
                <td><?=money($txn['sub_total']);?></td>
            </tr>
            <tr>
                <td>Достава</td>
                <td><?=money($txn['tax']);?></td>
            </tr>
            <tr>
                <td>Вкупно</td>
                <td><?=money($txn['grand_total']);?></td>
            </tr>
            <tr>
                <td>Дата на порачка</td>
                <td><?=pretty_date($txn['txn_date']);?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h3 class="text-center">Адреса на достава</h3>
        <address>
            <?=$txn['full_name'];?><br>
            <?=$txn['street'];?><br>
            <?=(($txn['street2']!='')?$txn['street2'].'<br>':'');?><br>
            <?=$txn['city'].' '.$txn['state'].' '.$txn['zip_code'];?><br>
            <?=$txn['country'];?><br>




        </address>
        </table>

    </div>
</div>
<div class="pull-right">
    <a href="index.php" class="btn btn-large btn-default">Откажи се</a>
    <a href="orders.php?complete=1&cart_id=<?=$cart_id;?>" class="btn btn-primary btn-large">Завршете на нарачката</a>
</div>





<?php
include 'includes/footer.php';
?>
