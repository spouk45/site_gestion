<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
    if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
    }


?>
<?php include(HEADER);
/* --- recherche des marques et catégorie */
include(DIR_ROOT.'class/Generic.php');
include(CONNECT);
$Gen=new Generic($db);
$categoryList=$Gen->getData('prod_category','','','id,name','');
$markList=$Gen->getData('mark','','','id,name','');

?>
<h2>Produits</h2>

<div id="wrapper">
    <div id="filter" class="filter">
        <h3>Recherche</h3>
        <div> <form method="POST" action="proc/seek_product.php" id="formFilter">
                <div>
                <p>Marque: <label for="markId"></label>
                    <select name="markId" id="markId">
                        <option value=""></option>
                        <?php foreach($markList as $value){ ?>
                            <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                        <?php } ?>
                    </select>
                </p>
                <p>Categorie: <label for="categoryId"></label> <select name="categoryId" id="categoryId">
                        <option value=""></option>
                        <?php foreach($categoryList as $value){ ?>
                            <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                        <?php } ?>
                    </select>
                </p>
                </div>
               <div> <p>Nom: <label for="name"></label><input type="text" name="name" id="name" value=""></p></div>

            </form>
        </div>
    </div>

    <!-- affichage tableau -->
    <div id="product_list" class="cadre hoverTab"></div>
</div>

<script>
    $('#name').keyup(function(){
        var name=$('#name').val();
        var markId=$('#markId').val();
        var categoryId=$('#categoryId').val();
        /*
        $.post('<?php echo URL_ROOT."equipment/proc/seek_product.php";?>',{ name: name,markId:markId,categoryId:categoryId },function(data){
           $('#product_list').html(data);
        });*/
        $('#formFilter').trigger('submit');

    });

    $('#markId').change(function(){
            $('#formFilter').trigger('submit');
    });

    $('#categoryId').change(function(){
            $('#formFilter').trigger('submit');
    });

    $('#formFilter').submit(function(e){
        e.preventDefault();
        var $this=$(this);
        $.ajax({
            url: $this.attr('action'),
            type: $this.attr('method'),
            data: $this.serialize(),
            success: function(html) {
                $('#product_list').html(html);
            }
        });
    });



</script>
<?php include(FOOTER);?>

