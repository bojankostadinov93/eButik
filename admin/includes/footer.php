</div><br><br>

<div class="col-lg-12 text-center" >&copy;Copyright 2017 Fashion Boutique</div>



<script>
    function updateSizes(){
        var sizeString ='';
        for(var i=1;i<=12;i++){
            if( jQuery('#size'+i).val()!=''){
                sizeString +=jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+':'+jQuery('#threshold'+i).val()+',';
            }
        }
    jQuery('#sizes').val(sizeString);
    }

    function get_child_options(selected){//funkcija za da ti gi dava decata od roditelite so sa
        if(typeof selected=='undefined'){
            var selected='';
        }
        var parentID =jQuery('#parent').val();
        jQuery.ajax({
            url:'/eButik/admin/parsers/child_categories.php',
            type: 'POST',
            data: { parentID : parentID,selected:selected},
            success:function(data){
                jQuery('#child').html(data);
            },
            error: function () {
                alert("Somthing went wrong with child options")
            },
        });
    }
    jQuery('select[name="parent"]').change(function() {
        get_child_options();
    });

</script>
</body>
</html>