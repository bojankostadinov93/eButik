<h3 class="text-center">Популарни производи</h3>

<?php//znaci ovoa ga prave za da ti ga dava popularni proizvodi sal kaj mene nejke zaradi toa so ne mi e sredeno plakanjeto so e

$transQ=$db->query("SELECT * FROM cart WHERE  paid=1 ORDER BY id DESC  LIMIT 5");
$results=array();
while($row=mysqli_fetch_assoc($transQ)){
$results[]=$row;
}
$row_count  =$transQ->num_rows;
$user_ids=array();
for($i=0;$i<$row_count;$i++){
    $jeson_items=$results[$i]['items'];
    $items=json_decode($jeson_items,true);
    foreach ($items as $item){
        if(!in_array($item['id'].$user_ids)){
            $user_ids[]=$item['id'];
        }
    }
}
?>
<div id="recent_widgets">
    <table class="table table-condensed">
        <?php foreach ($user_ids as $id):
            $productQ=$db->query("SELECT id,title FROM products WHERE id='{$id}'");
            $product=mysqli_fetch_assoc($productQ);

            ?>
                <tr>
                    <td><?=substr($product['title'],0,15);?></td>
                    <td><a class="text-primary" onclick="detailsmodal('<?=$id;?>')"></a> </td>
                    <td></td>
                </tr>
        <?php endforeach; ?>
    </table>
</div>
