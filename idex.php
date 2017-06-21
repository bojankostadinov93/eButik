<?php
include_once 'core/init.php';
//include_once 'core/mongodb.php';
include'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerfull.php';
include 'includes/leftbar.php';

$sql="SELECT * FROM products WHERE featured=1 AND deleted=0";
$featured=$db->query($sql);

?>


<meta charset="utf-8" />


<!--main content-->
    <div class="col-md-8">

    <div class="row">
        <h2 class="text-center">Одбрани продукти</h2>
        <?php while($product=mysqli_fetch_assoc($featured)) : ?>
        <div class="col-md-3">
            <h4 class="text-center"><?php echo $product['title'];?></h4>
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



