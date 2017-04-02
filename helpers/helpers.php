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

?>