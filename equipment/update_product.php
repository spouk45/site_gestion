<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST['id'])){
    echo 'Erreur de récupération des données';
    exit();
}
?>
<?php include(HEADER);?>

<?php
try{
    $id=$_POST['id'];
    $data['id']=$id;
    include(CONNECT);
    include(DIR_ROOT.'equipment/class/ProductManager.php');
    $ProductManager=new ProductManager($db);
    $data=$ProductManager->getProduct($data);


    include(DIR_ROOT.'equipment/class/CategoryManager.php');
    $CategoryManager=new ProductManager($db);
    $CategoryList=$CategoryManager->getCategoryList();

    include(DIR_ROOT.'class/Generic.php');
    $Gen=new Generic($db);
    $markList=$Gen->getData('mark','','','','');
//print_r($data);
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

?><h2>Modification</h2>
<div id="wrapper">
    <form method="POST" action="<?php echo URL_ROOT.'equipment/proc/update_product.php';?>" id="new">
        <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
        <p>  Nom: <input type="text" name="name" value="<?php echo $data['productName'];?>" id="name">  </p>
        <p> Marque:<select name="mark" id="mark">
                <option value=""></option>
                <?php if($markList!=null){
                    foreach($markList as $value){
                        ?><option value="<?php echo $value['id'];?>" <?php if($data['markId']==$value['id']){echo 'selected';}?>><?php echo $value['name'];?></option><?php
                    }
                }?>
        </select></p>
        <p>Description:</p>
        <p><textarea id="description" name="description"><?php echo $data['description'];?></textarea>
        </p>
        <p> Catégorie: <select name="category_id" id="category_id" >
                <option value=""></option>
                <?php if($CategoryList!=null){
                    foreach($CategoryList as $value){
                        ?><option value="<?php echo $value['id'];?>" <?php if($data['categoryId']==$value['id']){echo 'selected';}?>><?php echo $value['name'];?></option><?php
                    }
                }?>
            </select>
        </p>
        <input type="submit" value="Valider">
    </form>
    <div id="box_error"></div>
</div>
<script>
    $(document).ready(function(){

        $('#new').submit(function(e){
            e.preventDefault();
            var $this = $(this);
            var name=$('#name').val();
            if( name==''){
                $('#box_error').html('<p>Certaines informations sont manquantes</p>');
            }
            else {
                $('#box_error').html('');
                $.ajax({
                    url: $this.attr('action'),
                    type: $this.attr('method'),
                    data: $this.serialize(),
                    dataType: 'json', // JSON
                    success: function(json) {
                        if(json.reponse === 'ok') {
                           // alert('Tout est bon');
                            $('#wrapper').html('<p>Modification faite avec succès.</p>');
                        } else {
                           // alert('Erreur : '+ json.reponse);
                            $('#box_error').html('<p>'+ json.reponse+'</p>');
                        }
                    }
                });
            }

        });
    });



</script>

<?php include(FOOTER);?>