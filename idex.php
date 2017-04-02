<?php
include_once 'core/init.php';
//include_once 'core/mongodb.php';
include'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerfull.php';
include 'includes/leftbar.php';

$sql="SELECT * FROM products WHERE featured=1";
$featured=$db->query($sql);

?>





    <!--main content-->
    <div class="col-md-8">

    <div class="row">
        <h2 class="text-center">Feature Products</h2>
        <?php while($product=mysqli_fetch_assoc($featured)) : ?>
        <div class="col-md-3">
            <h4><?php echo $product['title'];?></h4>
            <img src="<?php echo $product['image']?>" alt="<?php echo $product['title']?>"class="img-thumb"/><!--img-thumb da ti gi podrede kako so treba u dobar redosled-->
            <p class="list-price text-danger">List Price <s>$<?php echo $product['list_price'];?></s></p>
            <p class="price">Our price:$<?php echo $product['price'];?></p>
            <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?= $product['id']; ?>)">Details</button><!--znaci prae javascript funkcija koja kd ke preteisnes details ke ti ga otvore produkto so dadenio id so e -->
        </div>
       <?php endwhile; ?>

    </div>

    </div>
<?php

include 'includes/rightbar.php';
include 'includes/footer.php';


?>



