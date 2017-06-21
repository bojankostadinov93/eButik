<?php
$cat_id=((isset($_REQUEST['cat']))?sanitize($_REQUEST['cat']):'');
$price_sort=((isset($_REQUEST['price_sort']))?sanitize($_REQUEST['price_sort']):'');
$min_price=((isset($_REQUEST['min_price']))?sanitize(($_REQUEST['min_price'])):'');
$max_price=((isset($_REQUEST['max_price']))?sanitize(($_REQUEST['max_price'])):'');
$b=((isset($_REQUEST['brand']))?sanitize($_REQUEST['brand']):'');
$brandQ=$db->query("SELECT * FROM brand ORDER BY brand");


?>
<h3 class="text-center">Пребарувајте по:</h3>
<h4 class="text-center">Цена</h4>
<form action="search.php" method="post">
    <input type="hidden" name="cat" value="<?=$cat_id?>">
    <input type="hidden" name="price_sort" value="0">
    <input type="radio" name="price_sort" value="low"<?php(($price_sort=='low')?'checked':'');?> Најниска до највисока<br>
    <input type="radio" name="price_sort" value="high"<?php(($price_sort=='high')?'checked':'');?> Највисока до најниска<br><br>
    <input type="text" name="min_price" class="price-range" placeholder="Min $" value="<?=$min_price;?>">До
    <input type="text" name="max_price" class="price-range" placeholder="Max $" value="<?=$max_price;?>"><br><br>
    <h4 class="text-center" >Brand</h4>
    <input type="radio" name="brand" value=""<?=(($b=='')?'checked':'');?>>Сите<br>
    <?php while ($brand=mysqli_fetch_assoc($brandQ)): ?>
        <input type="radio" name="brand" value="<?=$brand['id']; ?>"<?=(($b==$brand['id'])?'checked':'');?>><?=$brand['brand'];?><br>

    <?php endwhile; ?>
    <input type="submit" value="Пребарувај" class="btn btn-xs btn-primary">
</form>
<?php
