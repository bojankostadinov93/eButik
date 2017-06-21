<?php
include_once 'core/init.php';
//include_once 'core/mongodb.php';
include'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';
include 'includes/leftbar.php';

if(isset($_GET['cat'])){// ako ga ima category.php?cat=$category['id'] ke produze nadole da se izvrsuva t.e ako e pritisnato na categoriite
    $cat_id=sanitize($_GET['cat']);
}else{
    $cat_id='';
}

$sql="SELECT * FROM products WHERE categories='$cat_id'";// prae query za da ti gi dade productite od taa kategorija
$productQ=$db->query($sql);

$category= get_category($cat_id);


?>





    <!--main content-->
    <div class="col-md-8">

        <div class="row">
            <h2 class="text-center"><?=$category['parent'].' '.$category['child'];?></h2><!--koga i da pretisnes na bilo koj kako naslolov u h2 dfa ti ga dava izbranoto-->
            <?php while($product=mysqli_fetch_assoc($productQ)) : ?>
                <div class="col-md-3">
                    <h4><?php echo $product['title'];?></h4>
                    <?php $photos=explode(',',$product['image']); ?>
                    <img src="<?php echo $photos[0];?>" alt="<?php echo $product['title']?>"class="img-thumb"/><!--img-thumb da ti gi podrede kako so treba u dobar redosled-->
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