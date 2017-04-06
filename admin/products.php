<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/eButik/core/init.php';// ovoa mu prae PATH na products.php
include 'includes/head.php';
include 'includes/navigation.php';
if(isset($_GET['add'])){
    $brandQuery=$db->query("SELECT * FROM brand ORDER BY brand");
    $parentQuery=$db->query("SELECT * FROM categories WHERE parent=0 ORDER BY category")
?>
<h2 class="text-center">Додај нов продукт</h2><hr>
    <form action="products.php?add=1" method="post" enctype="multipart/form-data"><!--enctype ti e poso ke se dodava i sliki i trista gluposti-->
        <div class="form-group col-md-3">
            <label for="title">Наслов:</label>
            <input type="text" name="title" class="form-control" id="title" value="<?=((isset($_POST['title']))?sanitize($_POST['title']):'');?>">
        </div>
        <div class="form-group col-md-3">
            <label for="brand">Бренд:</label>
            <select class="form-control" id="brand" name="brand">
                <option value=""<?=((isset($_POST['brand'])&&  $_POST['brand']=='')?'selected':'');?>></option>
                <?php while($brand=mysqli_fetch_assoc($brandQuery)):?>
                    <option value="<?=$brand['id']?>"<?=((isset($_POST['brand'])&& $_POST['brand']==$brand['id'])? 'selected':'')?>><?=$brand['brand'];?></option>
        <?php endwhile;?>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label for="parent">Категорија на родител</label>
            <select class="form-control" id="parent" name="parent">
                <option value=""<?=((isset($_POST['parent'])&&$_POST['parent'])?'selected':'')?>></option>
                <?php while($parent=mysqli_fetch_assoc($parentQuery)):?>
                    <option value="<?=$parent['id'];?> "<?=((isset($_POST['parent'])&&$_POST['parent']==$parent['id'])?'select':'')?>><?=$parent['category'];?></option>


        <?php endwhile; ?>
        </select>

        </div>
        <div class="form-group col-md-3" >
            <label for="child">Катеротија на дете</label>
            <select id="child" name="child" class="form-control"></select>
        </div>
        <div class="form btn-group col-md-3">
            <label for="price">Цена</label>
            <input type="text" id="price" name="price" class="form-control" value="<?=((isset($_POST['price']))?sanitize($_POST['price']):'')?>">
        </div>
        <div class="form btn-group col-md-3">
            <label for="price">Стара цена</label>
            <input type="text" id="list_price" name="list_price" class="form-control" value="<?=((isset($_POST['list_price']))?sanitize($_POST['list_price']):'')?>">
        </div>
        <div class="form-group col-md-3">
            <label>Количина и големина</label>
            <button class="btn btn-default form-control" onlcick="jQuery('#sizesModal').modal('toggle'); return false;">Количина и големина</button>
        </div>
        <div class="form-group col-md-3 ">
            <label for="sizes">Големина и увид на количини</label>
            <input type="text"class="form-control"  name="sizes" id="sizes" value="<?=((isset($_POST['sizes']))?$_POST['sizes']:'');?>"readonly>
        </div>
        <div class="form-group col-md-6">
            <label for="photo">Слика на продуктот</label>
            <input type="file" name="photo" id="photo" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label for="description">Опис</label>
            <textarea id="description" name="description" class="form-control" rows="6"><?=((isset($_POST['description']))?sanitize($_POST['description']):'')?></textarea>
        </div>
        <div class="col-md-3 pull-right" >
        <input type="submit" value="Додај продукт" class="form-control btn btn-success ">
        </div><div class="clearfix"></div>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="sizesModalLabel">Големина и количина</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary "onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}else{
    $sql ="SELECT * FROM products WHERE deleted !=1";
$presults=$db->query($sql);
if(isset($_GET['featured'])){//ako e pritisnato kopceto
    $id=(int)$_GET['id'];
    $featured=(int)$_GET['featured'];
    $featuredsql="UPDATE products SET featured='$featured' WHERE id='$id'";
    $db->query($featuredsql);
    header('Location:products.php');
}
?>
<h2 class="text-center">Продукти</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Додај продукт</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered  table-condensed table-striped">
    <thead>
    <th></th>
    <th>Product</th>
    <th>Price</th>
    <th>Category</th>
    <th>Featured</th>
    <th>Sold</th>
    </thead>
    <tbody>
    <?php while($product=mysqli_fetch_assoc($presults)):
        $childID=$product['categories'];
        $catSql="SELECT * FROM categories WHERE id =$childID";
        $result= $db->query($catSql);
        $child= mysqli_fetch_assoc($result);
        $parentID=$child['parent'];
        $pSql="SELECT * FROM categories WHERE  id='$parentID'";
        $presult=$db->query($pSql);
        $parent=mysqli_fetch_assoc($presult);
        $category=$parent['category'].'-'.$child['category'];

        ?>
        <tr>
            <td>
                <a href="products.php?edit=<?=$product['id']?>" class="btn btn-xs btn-default"><span class="glyphicon-pencil"></span></a>
                <a href="products.php?delete=<?=$product['id']?>" class="btn btn-xs btn-default"><span class="glyphicon-remove-sign"></span></a>
            </td>
            <td><?= $product['title']?></td>
            <td><?= money($product['price']);?></td>
            <td><?=$category;?></td>
            <td><a href="products.php?featured=<?=(($product['featured']==0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default ">
                    <span class="glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus');?>"></span>

                </a>&nbsp<?=(($product['featured']==1)?'Избран продукт':'');?></td>
            <td>0</td>
        </tr>


    <?php endwhile ;?>
    </tbody>
</table>

<?php
}
include 'includes/footer.php';
?>



