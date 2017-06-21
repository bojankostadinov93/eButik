<?php

require_once '../core/init.php';
if(!is_logged_in()){
    header('Location:login.php');
}

include 'includes/head.php';
include 'includes/navigation.php';
echo $_SESSION['SBUser'];

?>

<?php
$txnQuery = "SELECT t.id,t.cart_id,t.full_name,t.description,t.txn_date,t.grand_total,c.items,c.paid,c.shipped
 FROM transactions t
 LEFT JOIN  cart c ON t.cart_id=c.id
 WHERE c.paid=1 AND c.shipped =0
 ORDER BY t.txn_date";
$txnResults=$db->query($txnQuery);
?>
<div class="col-md-12">
    <h3 class="text-center">Порачки за испорака</h3>
    <table class="table table-condensed table-bordered table-striped">
        <thead>
                <th></th> <th>Име</th> <th>Опис</th> <th>Вкупно</th> <th>Дата</th>

        </thead>
        <tbody>
        <?php while($order=mysqli_fetch_assoc($txnResults)): ?>
        <tr>
                <td><a href="orders.php?txn_id=<?=$order['id'];?>" class="btn btn-xs btn-info">Детали</a> </td>
                <td><?=$order['full_name']?></td>
                <td><?=$order['description']?></td>
                <td><?=money($order['grand_total'])?></td>
                <td><?=pretty_date($order['txn_date']);?></td>
        </tr>
        <?php endwhile;?>
        </tbody>
    </table>
</div>
<div class="row">
    <!--mesecna prodazba-->
    <?php
    $thisYear=date("Y");
    $lastYear=$thisYear-1;
    $thisYearQ=$db->query("SELECT grand_total, txn_date FROM transactions WHERE YEAR (txn_date)='$thisYear'");
    $lastYearQ=$db->query("SELECT grand_total, txn_date FROM transactions WHERE YEAR (txn_date)='$lastYear'");
    $current=array();
    $last=array();
    $currentTotal=0;
    $lastTotal=0;
    while ($x=mysqli_fetch_assoc($thisYearQ)){
        $month=date("m",strtotime($x['txn_date']));
        if(!array_key_exists($month,$current)){
            $current[(int)$month]=$x['grand_total'];
        }else{
            $current[(int)$month]+=$x['grand_total'];
        }
        $currentTotal += $x['grand_total'];
    }
    while ($y=mysqli_fetch_assoc($lastYearQ)){
        $month=date("m",strtotime($x['txn_date']));
        if(!array_key_exists($month,$current)){
            $last[(int)$month]=$y['grand_total'];
        }else{
            $last[(int)$month]+=$y['grand_total'];
        }
        $lastTotal += $y['grand_total'];
    }

    ?>
    <div class="col-md-4">
        <h3 class="text-center">Месечна продажба</h3><?=date("m-d-Y m:i:s");?>
        <table class="table table-bordered tab-condensed table-striped">
            <thead>
            <th></th>
            <th><?=$lastYear;?></th>
            <th><?=$thisYear;?></th>

            </thead>
            <tbody>
            <?php for ($i=1;$i<=12;$i++ ):
                $dt=DateTime::createFromFormat('!m',$i);
                ?>
                <tr<?=((date("m")==$i)?'class="info"':'');?>>
                    <td><?=$dt->format("F");?></td>
                    <td><?=((array_key_exists($i,$last))?money($last[$i]):money(0));?></td>
                    <td><?=((array_key_exists($i,$current))?money($current[$i]):money(0));?></td>
                </tr>
            <?php endfor;?>
            <tr>
                <td>Total</td>
                <td><?=money($lastTotal);?></td>
                <td><?=money($currentTotal);?></td>

            </tr>
            </tbody>
        </table>
    </div>
<!--Inventory -->
    <?php
    $iQuery=$db->query("SELECT * FROM products WHERE deleted=0");
    $lowItems=array();
    while ($product=mysqli_fetch_assoc($iQuery)){
        $item=array();
        $sizes=sizesToArray($product['sizes']);
        foreach ($sizes as $size){
            if($size['quantity']<=$size['threshold']) {

                $cat = get_category($product['categories']);
            $item = array(
                'title' => $product['title'],
                'size' => $size['size'],
                'quantity' => $size['quantity'],
                'threshold' => $size['threshold'],
                'category' => $cat['parent'] . ' ~ ' . $cat['child']
            );
           $lowItems[] = $item;
           }

        }
    }
    ?>

    <div class="col-md-8">
        <h3 class="text-center">Изтрошени производи</h3>
        <table class="table table-bordered tab-content table-striped">
            <thead>
                <th>Продукт</th>
                <th>Категорија</th>
                <th>Големина</th>
                <th>Количина</th>
                <th></th>

            </thead>
            <tbody>
            <?php foreach ($lowItems as $item): ?>
            <tr<?=($item['quantity']==0)?'class="danger"':''; ?>>
                <td><?=$item['title'];?></td>
                <td><?=$item['category'];?></td>
                <td><?=$item['size'];?></td>
                <td><?=$item['quantity'];?></td>
                <td><?=$item['threshold'];?></td>

            </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<?php
include 'includes/footer.php'
?>
