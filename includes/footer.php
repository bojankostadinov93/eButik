</div><br><br>

<div class="col-lg-12 text-center" >&copy;Copyright 2017 Fashion Boutique</div>



<script>
    jQuery(window).scroll(function(){
        var vscroll =jQuery(this).scrollTop();
        console.log(vscroll);
        jQuery('#logotext').css({
            "transform":"translate(0px,"+vscroll/2+"px)"
        })
        var vscroll =jQuery(this).scrollTop();
        console.log(vscroll);
        jQuery('#back-flower').css({
            "transform":"translate("+vscroll/5+"px,"+vscroll/2+"px)"
        })
        var vscroll =jQuery(this).scrollTop();
        console.log(vscroll);
        jQuery('#fore-flower').css({
            "transform":"translate(0px,"+vscroll/2+"px)"
        })
    });

    function detailsmodal(id){
       var data = {"id": id};
        jQuery.ajax({
            url: '/eButik/includes/detailmodal.php',
            method: "post",
            data : data,
            success: function(data){
                jQuery('body').append(data);
                jQuery('#details-modal').modal('toggle');
            },
            error:function(){
                alert("Somthing get wrong!");
            }
        });
    }
    function update_cart(mode,edit_id,edit_size){
            var data ={"mode":mode, "edit_id":edit_id, "edit_size":edit_size};
            jQuery.ajax({
            url: '/eButik/admin/parsers/update_cart.php',
            method: "post",
            data : data,
                success: function() {location.reload(); },
                error:function(){alert("Somthing went wrong!");}
            });
    }

    function add_to_cart () {
        jQuery('#modal_errors').html("");
        var size = jQuery('#size').val();//za da gi zeme podatocite od textboxo
        var quantity=jQuery('#quantity').val();//  istoto ga prae i za quantity
        var available =jQuery('#available').val();
        var error= '';
        var data=jQuery('#add_product_form').serialize();// zimagi informaciite i gi serializira

        if(size=='' || quantity=='' || quantity==0){
            error+='<p class="text-danger text-center">Ве молиме одберете количина и големина.</p>';
            jQuery('#modal_errors').html(error);
            return;

        }else if( quantity > available ){
            error+='<p class="text-danger text-center">Имаме само '+available+' парчиња на располагање.</p>';//znaci istoto kako so e gore sal ovoa ne rabote nz zaso
            jQuery('#modal_errors').html(error);
            return;
        }else {
            jQuery.ajax({
                url:'/eButik/admin/parsers/add_cart.php',
                method: "post",
                data: data,
                success : function () {
                    location.reload();// za da bide cookie uspesno treba da se naprave reload na stranata
                },
                error: function () {
                    alert("Nesto trgna naopaku");
                }
            });
        }
    }


</script>
</body>
</html>