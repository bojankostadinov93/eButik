<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/eButik/core/init.php';// ovoa mu prae PATH na products.php
include 'includes/head.php';

$email=((isset($_POST['email']))?sanitize($_POST['email']):'');
$email=trim($email);
$password=((isset($_POST['password']))?sanitize($_POST['password']):'');
$password=trim($password);
$hashed=password_hash($password,PASSWORD_DEFAULT);
$errors=array();


?>

<style>
    body{
        background-image: url("/eButik/images/headerlogo/pozadina7.jpg ");
        background-size:100vw 100vh ;
        background-attachment: fixed;
    }
</style>

<div id="login-form">
    <div>
        <?php
            if($_POST){
                //form validation
                if(empty($_POST['email']) || empty($_POST['password'])){
                    $errors[]='Внесете емаил и лозинка.';
                }

                //validacija na email
                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $errors[]='Мора да внесете валидна емаил.';
                }
                //password e poveke od 6 karakteri
                if(strlen($password)<6){
                    $errors[]='Лозинката мора да биде поголема од 6 карактери.';
                }

                //ako postoe usero u databazata
                $query=$db->query("SELECT * FROM users WHERE email='$email'");
                $user=mysqli_fetch_assoc($query);
                $userCount=mysqli_num_rows($query); //znaci so ovaa funkcija kazuvani ako veke gu ima u bazata vraka 1 ako gu nema vraka 0
                if($userCount<1){
                    $errors[]='Вашиот емаил не постои во нашата база.';
                }
                if(!password_verify($password,$user['password'])){
                    $errors[]='Вашата лозинка не одговара на нашите податоци';
                }



                //proverka za greski
                if(!empty($errors)){
                    echo display_errors($errors);
                }else{
                    //log user in
                    $user_id=$user['id'];
                    login($user_id);
                }

            }
        ?>
    </div>
    <h2 class="text-center">Најава</h2><hr>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="email">Емаил:</label>
            <input type="text" name="email" id="email" class="form-control" value="<?=$email;?>">
        </div>
        <div class="form-group">
            <label for="password">Лозинка:</label>
            <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
        </div>
        <div class="form-group">
            <input type="submit" value="Најави се" class="btn btn-primary"  >
        </div>
    </form>
    <p class="text-right"><a href="/eButik/idex.php" alt="home"> Посетете ја нашата страна </a> </p>
</div>


<?php
include 'includes/footer.php';
?>
