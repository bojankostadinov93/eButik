<?php

function display_errors($errors){
    $display='<ul class="bg-danger">';
    foreach($errors as $error){
        $display.='<li class="text-danger">'.$error. '</li>';

    }
    $display.='</ul>';
    return $display;
}

function sanitize($dirty){
    return htmlentities($dirty,ENT_QUOTES,"UTF-8");// prae funkcija za da kd vnasas html tagovi u texto deka se unasat brendovite da ne bidat funkcionalti html tagovite
}
function money($number){//funkcija za da ti gi ga dava $ kaj cenata poso u bazata ne ga pisuva dolaro
    return '$'.number_format($number,2);

}
function login($user_id){//funkcija za da naprave session taka si gu krstimoSBUser
    $_SESSION['SBUser']=$user_id;
    global $db;
    $date= date("Y-m-d H:i:s");
    $db->query("UPDATE users SET last_login='$date' WHERE id='$user_id'");
    $_SESSION['success_flash']='Вие сте логирани';
    header('Location:index.php');
}
function is_logged_in(){
    if(isset($_SESSION['SBUser'])&& $_SESSION['SBUser']>0){
        return true;
    }return false;
}
function  login_error_redirect($url='login.php'){
        $_SESSION['error_flash']='Мора да бидете најавени за да имате пристап до страната.';
        header('Location:'.$url);
}
function  permission_error_redirect($url='login.php'){
    $_SESSION['error_flash']='Вие немате дозвола за пристам до страната.';
    header('Location:'.$url);
}
function has_permission($permission='admin'){
        global $user_data;
        $permissions=explode(',', $user_data['permissions']);
    if(in_array($permission,$permissions,true)){
        return true;
    }
    return false;
}
function pretty_date($date){
    return date("M d, Y h:i A", strtotime($date));
}
?>