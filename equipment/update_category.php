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
    include(CONNECT);
    include(DIR_ROOT.'equipment/class/CategoryManager.php');
    $CategoryManager=new CategoryManager($db);
    $data=$CategoryManager->getCategoryByID($id);
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

?><h2>Edition d'une catégorie</h2>
<div id="wrapper">
    <form method="POST" action="<?php echo URL_ROOT.'equipment/proc/update_prod_category.php';?>" id="new">
        <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
        <p>
          Nom: <input type="text" name="name" value="<?php echo $data['name'];?>" id="name">
        </p>
        <p> Description:</p>
        <p>
            <textarea id="description" name="description"><?php echo $data['description'];?></textarea>
        </p>
        <p>Catégorie contenant du fluide frigorigène:</p>
        <p>
            <span class="margin-inline"><input type="radio" value="1" name="frigo" <?php if($data['frigo']==1){echo 'checked';}?> > oui</span>
           <span class="margin-inline"> <input type="radio" value="0" name="frigo" <?php if($data['frigo']==0){echo 'checked';}?> > non</span>
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
                            //alert('Tout est bon');
                            $('#wrapper').html('<p>Mise à jour réalisée avec succès</p>')
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