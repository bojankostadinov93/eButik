</div><br><br>

<div class="col-lg-12 text-center" >&copy;Copyright 2017 Fashion Boutique</div>



<script>
    function updateSizes(){
        alert('update sizes');
    }

    function get_child_options(){//funkcija za da ti gi dava decata od roditelite so sa
        var parentID =jQuery('#parent').val();
        jQuery.ajax({
            url:'/eButik/admin/parsers/child_categories.php',
            type: 'POST',
            data: { parentID : parentID},
            success:function(data){
                jQuery('#child').html(data);
            },
            error: function () {
                alert("Somthing went wrong with child options")
            },
        });
    }
    jQuery('select[name="parent"]').change(get_child_options);

</script>
</body>
</html>