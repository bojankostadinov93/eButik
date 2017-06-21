    <?php
/**
 * Created by PhpStorm.
 * User: Bojan
 * Date: 5/23/2017
 * Time: 11:03 AM
 */
require_once 'core/init.php';
include 'includes/head.php';
include "includes/navigation.php";
include 'includes/headerpartial.php';
//$cart_id=1;

    if($cart_id !=0){
    $cartQ=$db->query("SELECT * FROM cart WHERE id='{$cart_id}'");
    $result=mysqli_fetch_assoc($cartQ);
        $items=json_decode($result['items'],true);

    $i=1;
    $sub_total=0;
    $item_count=0;
    }

?>
    <div class="col-md-12">
        <div class="row">
            <h2 class="text-center">Мојата кошничка</h2><hr>
            <?php if($cart_id ==''): ?>
            <div class="bg-danger">
                <p class="text-center text-danger">
                    Твојата кошничка е празна!
                </p>
            </div>
            <?php
            else: ?>
            <table class="table table-bordered table-condensed table-striped">
                <thead><th>#</th><th>Производ</th><th>Цена</th><th>Количина</th><th>Големина</th><th>Тотал</th></thead>
                <tbody>
                <?php

                   foreach ( $items as $item){

                    $product_id = $item['id'];
                    $productQ=$db->query("SELECT * FROM products WHERE id='{$product_id}'");
                    $product=mysqli_fetch_assoc($productQ);
                    $productSizes=$product['sizes'];
                    $sArray=explode(',', $productSizes);

                    foreach ( $sArray as $sizeString){
                        $s=explode(':', $sizeString);

                        if($s[0]==$item['size']){
                            $available=$s[1];
                        }
                    }
                        ?>
                    <tr>
                        <td><?=$i;?></td>
                        <td><?=$product['title'];?></td>
                        <td><?=money($product['price']);?></td>
                        <td>
                            <button class="btn btn-xs btn-danger" onclick="update_cart('removeone','<?php echo $product['id']; ?>','<?php echo $item['size']; ?>');">-</button>                            <?=$item['quantity'];?>
                            <?php  if($item['quantity']< $available) :?>
                                <button class="btn btn-xs btn-danger" onclick="update_cart('addone','<?php echo $product['id']; ?>','<?php echo $item['size']; ?>');">+</button>                            <?php else :?>
                                <span class="text-danger">Максимално достапни</span>
                           <?php endif;

                           ?>
                        </td>
                        <td><?=$item['size']?></td>
                        <td><?=money($item['quantity']*$product['price']);?></td>
                        </tr>
                <?php
                       $i++;
                       $item_count +=$item['quantity'];

                       $sub_total +=($product['price']*$item['quantity']);

                   }
                $tax=TAXRATE*$sub_total;
                $tax=number_format($tax,2);
                $grand_total=$tax+$sub_total;
                global $grand_total;

                ?>


                </tbody>
            </table>
                <table class="table table-bordered table-condensed text-right">

                    <thead class="totals-table-header"><th>Број на производи</th><th>Цена на производи</th><th>Достава</th><th>Целокупна цена</th></thead>
                    <tbody>
                     <tr>
                         <td><?=$item_count;?></td>
                         <td><?=money($sub_total);?></td>
                         <td><?=money($tax);?></td>
                         <td class="bg-success"><?=money($grand_total);?></td>
                     </tr>
                    </tbody>
                </table>
                <!-- Check out Button -->
                <button type="button" class="btn btn-primary btn-lg pull-right"  data-toggle="modal" data-target="#checkoutModal" >
                 <span class="glyphicon glyphicon-shopping-cart"> </span>  Продолжете >>
                </button>



                <!-- Modal -->

                <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="checkoutModalLabel">Адреса на достава</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <form action="thankYou.php" method="post" id="payment-form">
                                    <span class="bg-danger" id="payment-errors"></span>
                                    <input type="hidden" name="tax" value="<?=$tax;?>">
                                    <input type="hidden" name="sub_total" value="<?=$sub_total;?>">
                                    <input type="hidden" name="grand_total" value="<?=$grand_total; ?>">
                                    <input type="hidden" name="cart_id" value="<?=$cart_id;?>">
                                    <input type="hidden" name="description" value="<?=$item_count.'продукти'.(($item_count>1)?'':'').'од Fashion Boutique.';?>">

                                    <div id="step1" style="display:block;">
                                        <div class="form-group col-md-6">
                                            <label for="full_name">Име и презиме:</label>
                                            <input class="form-control" id="full_name" name="full_name" type="text">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email">Емаил:</label>
                                            <input class="form-control" id="email" name="email" type="email">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="street">Адреса на улицата:</label>
                                            <input class="form-control" id="street" name="street" type="text" data-stripe="address_line1">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="street2">Адреса на улицата 2:</label>
                                            <input class="form-control" id="street2" name="street2" type="text" data-stripe="address_line2" >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="city">Град:</label>
                                            <input class="form-control" id="city" name="city" type="text" data-stripe="address_city">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="state">Регион:</label>
                                            <input class="form-control" id="state" name="state" type="text" data-stripe="address_state">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="zip_code">Поштенски број:</label>
                                            <input class="form-control" id="zip_code" name="zip_code" type="text" data-stripe="address_zip">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="country">Држава:</label>
                                            <input class="form-control" id="country" name="country" type="text" data-stripe="address_country">
                                        </div>

                                    </div>
                                    <div id="step2" style="display:none;">
                                        <div>
                                            <?php
                                          /*  if (isset($_POST['name'])) {
                                            $name_c = $_POST['name'];
                                            }
                                            if (isset($_POST['number'])) {
                                            $number = $_POST['number'];
                                            }
                                            if (isset($_POST['cvc'])) {
                                            $cvc = $_POST['cvc'];
                                            }
                                            if (isset($_POST['exp_month'])) {
                                            $exp_month = $_POST['exp_month'];
                                            }
                                            if (isset($_POST['exp_year'])) {
                                            $exp_year = $_POST['exp_year'];
                                            }
                                            $errors=array();
                                            $required1=array(
                                            'name'  => 'Full Name',
                                            'number'      =>'Number',
                                            'cvc'     =>'Cvc',
                                            'exp_month'       =>'Exp_month',
                                            'exp_year'       =>'Exp_year',
                                            );
                                            foreach($required1 as $f =>$d) {
                                            if (empty($_POST[$f]) || $_POST[$f] == '') {
                                            $errors[] = $d . ' е потребно.';
                                            }
                                            }
                                            if(!empty($errors)){
                                            echo display_errors($errors);
                                            }else{
                                            echo'passed';
                                            }
                                            */?>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="name">Име и презиме од картичката</label>
                                            <input type="text" id="name" name="name" class="form-control" data-stripe="name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="number">Број на картичка</label>
                                            <input type="text" id="number" name="number" class="form-control" data-stripe="number">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="cvc">CVC</label><br>
                                            <input type="text" id="cvc"  name="cvc" class="form-control" data-stripe="cvc" >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exp-month">Месец на истекување на картичката</label>
                                            <select id="exp-month" class="form-control" name="exp_month" data-stripe="exp_month">
                                                <option value=""></option>
                                                <?php for($i=1; $i < 13; $i++): ?>
                                                    <option value="<?=$i;?>"><?=$i;?></option>

                                            <?php endfor;?>
                                                </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exp-year">Година на истекување на картичката</label>
                                            <select id="exp-year" class="form-control" name="exp_year" data-stripe="exp_year">
                                                <option value=""></option>
                                                <?php $yr=date("Y");?>
                                                <?php for($i=0;$i<11;$i++): ?>
                                                <option value="<?=$yr + $i?>"<?=$yri=$yr+$i;?>><?=$yri?></option>
                                                <?php endfor; ?>


                                            </select>


                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" >Откажете се</button>
                                <button type="button" class="btn btn-primary" onclick="check_address();" id="next_button">Продолжите >></button>
                                <button type="button" class="btn btn-primary" onclick="back_address();" id="back_button" style="display:none"><< Назад </button>
                                <button type="submit" class="btn btn-primary"  id="checkout_button" style="display:none">Купи >></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            <?php endif;?>

        </div>
    </div>
<script>
    function back_address(){//za kd ke udares nazad da se vrnes na Adresa za dostava
        jQuery('#payment-errors').html("");
        jQuery('#step1').css("display","block");
        jQuery('#step2').css("display","none");
        jQuery('#next_button').css("display","inline-block");
        jQuery('#back_button').css("display","none");
        jQuery('#checkout_button').css("display","none");
        jQuery('#checkoutModalLabel').html("Адреса на достава")

    }
    function check_address(){//zima gi podatocite od modalo so e za plakanje
        var data = {
            'full_name' : jQuery('#full_name').val(),
            'email' : jQuery('#email').val(),
            'street' : jQuery('#street').val(),
            'street2' : jQuery('#street2').val(),
            'city' : jQuery('#city').val(),
            'state' : jQuery('#state').val(),
            'zip_code' : jQuery('#zip_code').val(),
            'country' : jQuery('#country').val()
        };
        jQuery.ajax({
            url : '/eButik/admin/parsers/check_address.php',
            method : 'POST',
            data : data,
            success : function(data){
                if (data != 'passed') {
                    jQuery('#payment-errors').html(data);



                }
                if(data == 'passed'){//otkako ke pomine uspesno so potponuvanje na podatocite za adresa na dostava ide ponatamu kon podatoci za kartickata
                    jQuery('#payment-errors').html("");
                    jQuery('#step1').css("display","none");
                    jQuery('#step2').css("display","block");
                    jQuery('#next_button').css("display","none");
                    jQuery('#back_button').css("display","inline-block");
                    jQuery('#checkout_button').css("display","inline-block");
                    jQuery('#checkoutModalLabel').html("Внесете ги податоците од вашата картичка")
                }

            },
            error : function(){alert("something wrong");},
        });
    }




    /*submitHandler: function(validator, form, submitButton) {
        // createToken returns immediately - the supplied callback submits the form if there are no errors
        Stripe.card.createToken({
            number: $('.number').val(),
            cvc: $('.cvc').val(),
            exp_month: $('.exp_month').val(),
            exp_year: $('.exp_year').val(),
            name: $('.name').val()

        }, stripeResponseHandler);
        return false; // submit from callback
    }
    Stripe.setPublishableKey('pk_test_RmvC523dXhmp1QNXywTlERcf');

    function stripeResponseHandler(status, response) {
        if (response.error) {
            // re-enable the submit button
            $('.checkout_button').removeAttr("disabled");
            // show hidden div
            document.getElementById('a_x200').style.display = 'block';
            // show the errors on the form
            $(".payment-errors").html(response.error.message);
        } else {
            var form$ = $("#payment-form");
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            // and submit
            form$.get(0).submit();
        }
    }
/*
Stripe.setPublishableKey('pk_test_RmvC523dXhmp1QNXywTlERcf');

    function stripeRensponseHandler( status,response){
        var $form = $('#payment-form');

        if(rensponse.error){
            $form.find('#payment-errors').text(rensponse.error.message);
            $form.find('button').prop('disabled',false);
        }else{
            var token= response.id;
            $form.append($('<input type="hidden" name="stripeToken"/>').val(token));

            $form.get(0).submit();
        }
    };

    jQuery(function ($) {
        Stripe.card.createToken({
            number: $('#number').val(),
            cvc: $('#cvc').val(),
            exp_month: $('#exp-month').val(),
            exp_year: $('#exp-year').val()},stripeRensponseHandler();
        });

        return false;
    });


    Stripe.card.createToken({
        number: $('#number').val(),
        cvc: $('#cvc').val(),
        exp_month: $('#exp_month').val(),
        exp_year: $('#exp_year').val()
    }, stripeResponseHandler);

    });*/

</script>


    <?php include 'includes/footer.php';
    ?>