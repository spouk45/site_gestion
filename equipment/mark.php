<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

?>
<?php include(HEADER);?>
<h2>Marque</h2>
<div id="wrapper">
    <label>Recherche: <input type="text" name="seek" id="seek" /></label>

    <div id="product_list" class="cadre hoverTab"></div>

</div>
<script>
    seek();

    $('#seek').keyup(function(){
        seek();
    });

    function seek(){
        var seek=$('#seek').val();
        $.post('<?php echo URL_ROOT."equipment/proc/seek_mark.php";?>',{ seek: seek },function(data){
            $('#product_list').html(data);
        });
    }

</script>
<?php include(FOOTER);?>

