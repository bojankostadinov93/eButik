<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <a href="/eButik/admin/index.php"class="navbar-brand">Fashion Boutique Admin</a>
        <ul class="nav navbar-nav">

            <li><a href="brands.php">Brands</a> </li>
            <li><a href="categories.php">Categories</a> </li>
            <li><a href="products.php">Products</a> </li>
            <?php if(has_permission('admin')):?>
            <li><a href="users.php">Users</a> </li>
            <?php endif;?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Здраво <?=$user_data['first'];?>!
                <span class="caret"></span>
                </a>
                <ul class="dropdown-menu"role="menu">
                    <li><a href="change_password.php">Сменете ја лозинката</a> </li>
                    <li><a href="logout.php">Одјави се</a> </li>

                </ul>
            </li>


          <!--  <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['category'] ?><span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">

                        <li><a href="#"></a></li>
                        </ul>

            </li>


                        -->




    </div>
</nav>
