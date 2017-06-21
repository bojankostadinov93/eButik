<?php
$sql="SELECT *FROM categories WHERE parent = 0";
$pquery=$db->query($sql);// raniras ga parent query

?>
<meta charset="utf-8" />

<nav class="navbar navbar-default navbar-fixed-top" >
    <div class="container">
        <a href="idex.php"class="navbar-brand">Fashion Boutique</a>
        <ul class="nav navbar-nav">
            <?php while($parent = mysqli_fetch_assoc($pquery)): ?>
             <?php $parent_id =$parent['id'];
                   $sql2="SELECT * FROM categories WHERE parent='$parent_id'";
                   $cquery= $db->query($sql2);

                ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category'] ?><span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <?php while($child=mysqli_fetch_assoc($cquery)):?>
                    <li><a href="category.php?cat=<?=$child['id'];//kako da izgleda linko kd ke pretisnes na nekoi kategorii?>"><?php echo $child['category']; ?></a></li>
                    <?php endwhile; ?>

                </ul>

            </li>
            <?php endwhile; ?>
            <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Мојата кошничка</a> </li>

        </ul>


         <!--   <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Жени<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Маици</a> </li>
                    <li><a href="#">Панталони</a> </li>
                    <li><a href="#">Чевли</a> </li>
                    <li><a href="#">Додатоци</a> </li>

                </ul>

            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Момчиња<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Маици</a> </li>
                    <li><a href="#">Панталони</a> </li>
                    <li><a href="#">Чевли</a> </li>
                    <li><a href="#">Додатоци</a> </li>

                </ul>

            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Девојчиња<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Маици</a> </li>
                    <li><a href="#">Панталони</a> </li>
                    <li><a href="#">Чевли</a> </li>
                    <li><a href="#">Додатоци</a> </li>

                </ul>

            </li>

        </ul>  -->

    </div>
</nav>