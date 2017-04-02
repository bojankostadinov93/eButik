<?php
require_once'../core/init.php';
$id=$_POST['id'];
$id=(int)$id;
$sql="SELECT * FROM products WHERE id='$id'";
$result=$db->query($sql);
$product=mysqli_fetch_assoc($result);//asocijativna array prave,ustvari prave ga ovioa za da koga kliknes details da ti dade modal od dadenio produkt so ti e
$brand_id=$product['brand'];
$sql="SELECT brand FROM brand WHERE id='$brand_id'";
$brand_query=$db->query($sql);
$brand=mysqli_fetch_assoc($brand_query);
$sizestring=$product['sizes'];
$size_array=explode(',',$sizestring);


?>

<!--Details modal-->

<?php  ob_start(); ?>

<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" onclick="closeModal()" aria-label="Close"><!--onclick="closeModal() ustvari kd ke pretisnes na ikso so e za isklucuvanje da ti ga izbrise modal-->
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center"><?php echo $product['title']; ?></h4>


            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="center-block">
                                <img src="<?= $product['image']; ?>" alt=<?= $product['title']; ?> class="details img-responsive">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h4>Details</h4>
                            <p><?= $product['description']; ?></p>
                            <hr>
                            <p>Price:$<?= $product['price']; ?></p>
                            <P>Brand:<?= $brand['brand']; ?></P>
                            <form action="add_cart.php" method="post">
                                <div class="form-group">
                                    <div class="col-xs-3">
                                        <label for="quantity">Quantity:</label>
                                        <input type="text" class="form-control" id="quantity" name="quantity">
                                    </div>

                                </div><br><br><br>
                                <div class="form-group">
                                    <label for="size">Size:</label>
                                    <select name="size" id="size" class="form-control">
                                        <option value=""></option>
                                        <?php
                                        foreach($size_array as $string){
                                            $string_array=explode(':',$string);
                                            $size=$string_array[0];
                                            $quantity=$string_array[1];
                                            echo '<option value="'.$size.'">'.$size.'('.$quantity.'Available)</option>';
                                        }
                                        ?>

                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" onclick="closeModal()">Затвори</button>
                <button class="btn btn-danger" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span>Внеси во кошничка</button>
            </div>
        </div>
    </div>
</div>
<script>
    function closeModal(){
        jQuery('#details-modal').modal('hide');//ovoa e kako ke ga zatvore modalo
        setTimeout(function(){
            jQuery('#details-modal').remove();
            jQuery('.modal-backdrop').remove();
        },500);// ovoa e koga ke pretisnes eden produkt pa drug da ne ti go pokazuva istio modal zatoa gi brise id to od prvoto pretisnato na 500ms


    }
</script>
<?php echo ob_get_clean(); ?>