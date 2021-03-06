<?php

require_once '../core/init.php';
if(!is_logged_in()){
    login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
//zimanje na brendovi od databazata

$sql="SELECT * FROM brand ORDER BY brand";
$results=$db->query($sql);
$errors=array();

// editiranje na brend
if(isset($_GET['edit'])&& !empty($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_id = sanitize($edit_id);
    $sql2="SELECT * FROM brand WHERE  id='$edit_id'";
    $edit_result=$db->query($sql2);
    $eBrand= mysqli_fetch_assoc($edit_result);
}
//brisenje na brend
if(isset($_GET['delete'])&& !empty($_GET['delete'])){
      $delete_id=(int)$_GET['delete'];
    $delete_id=sanitize($delete_id);
    $sql="DELETE FROM brand WHERE id='$delete_id'";
    $db->query($sql);
    header('Location: brands.php');
}
//ako e pritisnato kopceto za vnesuvanje na brend
if(isset($_POST['add_submit'])){
    $brand=sanitize( $_POST['brand']);
    //proverka ako  brand e prazno
    if($_POST['brand']=='' ){
        $errors[].='Ве молиме внесете бренд';
    }
    //proverka ako brendo vise postoe u databazata
    $sql="SELECT * FROM brand WHERE brand ='$brand'";
    if(isset($_GET['edit'])){
        $sql="SELECT * FROM brand WHERE brand='$brand' AND id != '$edit_id'";
    }
    $result=$db->query($sql);
    $count=mysqli_num_rows($result);
    if($count >0){
       $errors[].=$brand.' веќе постои ве молиме внесете некој друг бренд';
    }


    // displayu errors
    if(!empty($errors)){
        echo display_errors($errors);
    }else{
        //doodi brend vo databazata
        $sql="INSERT INTO brand (brand) VALUES ('$brand')";
        if(isset($_GET['edit'])){
            $sql="UPDATE brand SET brand='$brand' WHERE id='$edit_id'";//sql prave za editiranje u bazata
        }
        $db->query($sql);
        header('Location:brands.php');// i da se vrne pa na brand.php
    }
}
?>
<h2 class="text-center">Брендови</h2><hr>
<!--Brend form-->
<div class="text-center">
    <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'')?>" method="post">
        <div class="form-group">
            <?php
            $brand_value='';
            if(isset($_GET['edit'])){
                $brand_value=$eBrand['brand'];
            }else{
                if(isset($_POST['brand'])){
                    $brand_value=sanitize( $_POST['brand']);
                }
            }
            ?>
            <label for="brand"><?=((isset($_GET['edit']))?'Корегирај':'Додај ')?> Бренд</label><!-- ovoa ti e kd e normalno da pokazuva add brand ali kd pretisnes edit da se smene kopceto u edit brand-->
            <input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value;?>">
           <?php
           if(isset($_GET['edit'])); ?>
            <a href="brands.php" class="btn btn-default">Cancel</a>
            <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Корегирај':'Додај');?> Бренд" class="btn btn-lg btn-success">
        </div>

    </form>
</div><hr>

<table class="table table-bordered table-striped table-auto table-condensed">
    <thead>
    <th></th><th>Бренд</th><th></th>
    </thead>
    <tbody>
    <?php
    while($brand=mysqli_fetch_assoc($results)):
    ?>
    <tr>
        <td><a href="brands.php?edit=<?=$brand['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></td>
        <td><?=$brand['brand'];?></td>
        <td><a href="brands.php?delete=<?=$brand['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span</td>

    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php
include 'includes/footer.php'
?>
