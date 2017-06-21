<?php
include_once 'core/init.php';
//include_once 'core/mongodb.php';
include'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';
include 'includes/leftbar.php';

$sql="SELECT * FROM products";
$cat_id=(($_POST['cat'])!=''?sanitize($_POST['cat']):'');
if($cat_id==''){
$sql .= ' WHERE deleted=0';
}else{
    $sql.=" WHERE categories = '{$cat_id}' AND deleted=0";
}
$price_sort=(($_POST['price_sort'])!=''?sanitize($_POST['price_sort']):'');
$min_price=(($_POST['min_price'])!=''?sanitize($_POST['min_price']):'');
$max_price=(($_POST['max_price'])!=''?sanitize($_POST['max_price']):'');
$brand=(($_POST['brand'])!=''?sanitize($_POST['brand']):'');
if($min_price!=''){
    $sql.=" AND price >= '{$min_price}'";

}
if($max_price!=''){
    $sql.=" AND price <= '{$max_price}'";

}
if($brand != ''){
    $sql .=" AND brand ='{$brand}'";
}
if($price_sort =='low'){
    $sql.=" ORDER BY price";
}
if($price_sort=='high'){
    $sql .=" ORDER BY price DESC";
}
$productQ=$db->query($sql);

$category= get_category($cat_id);


?>





    <!--main content-->
    <div class="col-md-8">

        <div class="row">
            <?php if($cat_id != ''): ?>
            <h2 class="text-center"><?=$category['parent'].' '.$category['child'];?></h2><!--koga i da pretisnes na bilo koj kako naslolov u h2 dfa ti ga dava izbranoto-->
            <?php else: ?>
                <h2 class="text-center">Fashion Boutique</h2>
            <?php endif; ?>
    <?php while($product=mysqli_fetch_assoc($productQ)) : ?>
                <div class="col-md-3">
                    <h4><?php echo $product['title'];?></h4>
                    <?php $photos=explode(',',$product['image']); ?>
                    <img src="<?php echo $photos[0];?>" alt="<?php echo $product['title']?>"class="img-thumb"/><!--img-thumb da ti gi podrede kako so treba u dobar redosled-->
                    <p class="list-price text-danger">Стара цена <s><?php echo money($product['list_price']);?></s></p>
                    <p class="price">Нова цена:<?php echo money($product['price']);?></p>
                    <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id']; ?>)">Детали</button><!--znaci prae javascript funkcija koja kd ke preteisnes details ke ti ga otvore produkto so dadenio id so e -->
                </div>
            <?php endwhile; ?>

        </div>

    </div>
<?php

include 'includes/rightbar.php';
include 'includes/footer.php';


?>