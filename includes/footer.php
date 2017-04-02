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


</script>
</body>
</html>