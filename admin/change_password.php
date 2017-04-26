<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/eButik/core/init.php';// ovoa mu prae PATH na products.php
if(!is_logged_in()){
    login_error_redirect();
}
include 'includes/head.php';

$hashed=$user_data['password'];
$old_password=((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password=trim($old_password);
$password=((isset($_POST['password']))?sanitize($_POST['password']):'');
$password=trim($password);
$confirm=((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm=trim($confirm);
$new_hased= password_hash($password,PASSWORD_DEFAULT);
$user_id=$user_data['id'];
$errors=array();


?>



<div id="login-form">
    <div>
        <?php
        if($_POST){
            //form validation
            if(empty($_POST['old_password']) || empty($_POST['password'])|| empty($_POST['confirm'])){
                $errors[]='Потполети ги сите полиња.';
            }


            //password e poveke od 6 karakteri
            if(strlen($password)<6){
                $errors[]='Лозинката мора да биде поголема од 6 карактери.';
            }

            //noviot pass i povtoreniot pass ne se sovpagat
            if($password!=$confirm){
                $errors[]='Новата лозинка и повторената лозинка не се совпаѓаат.';
            }
            if(!password_verify($old_password,$hashed)){
                $errors[]='Старата лозинка ви е погрешна,обидете се повторно.';
            }


            //proverka za greski
            if(!empty($errors)){
                echo display_errors($errors);
            }else{
               //промена на лозинка
                $db->query("UPDATE users SET password='$new_hased' WHERE id='$user_id'");
                $_SESSION['success_flash']='Твојота лозинка е променета';
                header('Location:index.php');

            }

        }
        ?>
    </div>
    <h2 class="text-center">Промена на лозинка</h2><hr>
    <form action="change_password.php" method="post">
        <div class="form-group">
            <label for="old_password">Стара лозинка:</label>
            <input type="password" name="old_password" id=old_passwordl" class="form-control" value="<?=$old_password;?>">
        </div>
        <div class="form-group">
            <label for="password">Нова лозинка:</label>
            <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
        </div>
        <div class="form-group">
            <label for="confirm">Повторете ја лозинката:</label>
            <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
        </div>
        <div class="form-group">
            <a href="index.php" class="btn btn-default">Откажи се</a>
            <input type="submit" value="Најави се" class="btn btn-primary"  >
        </div>
    </form>
    <p class="text-right"><a href="/eButik/idex.php" alt="home"> Посететеја нашата страна </a> </p>
</div>


<?php
include 'includes/footer.php';
?>
