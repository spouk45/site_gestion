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
    include(DIR_ROOT.'class/Generic.php');
    $Generic=new Generic($db);
    $seek['id']=$id;
    $data=$Generic->getData('sub',$seek,'','','');
    $data=$data[0];
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}
/*?><pre><?php print_r($data);?></pre><?php*/

?><h2>Edition client</h2>
    <div id="container" class="detail">
        <form method="POST" action="<?php echo URL_ROOT.'client/proc/update_sub.php';?>" id="formClient">
            <input type="hidden" name="id" id="id" value="<?php echo $id;?>">
            <div id="administratif" class="group">
                <h4><span>Sous-traint</span></h4>
                <p> <span>Nom: <input type="text" name="name" value="<?php echo $data['name'];?>" id="name"></span>

                </p> <p id="gr_contact">Contact: <input type="text" name="contact" value="<?php echo $data['contact'];?>" id="contact"></p>
            </div>

            <div id="coord" class="group">
                <h4><span>Coordonnées client</span></h4>
                <div class="ib">
                    <h5>Adresse:</h5>
                    <p class="right">Rue: <input type="text" name="road" id="road" value="<?php echo $data['road'];?>"></p>
                    <p class="right">Code postal: <input type="text" name="postal" id="postal" value="<?php echo $data['postal'];?>"></p>
                    <p class="right">Ville: <input type="text" name="city" id="city" value="<?php echo $data['city'];?>"></p>
                </div>
                <div class="ib">
                    <h5>Contact:</h5>
                    <p class="right"> Téléphone: <input type="text" name="tel" id="tel" value="<?php echo $data['tel'];?>" pattern="^[0-9]{0,10}$"></p>
                    <p class="right"> e-mail: <input type="text" name="mail" id="mail" value="<?php echo $data['mail'];?>" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"></p>
                </div>
            </div>

            <div id="com" class="group">
                <h4><span>Commentaire</span></h4>
                <p><textarea id="com" name="com"><?php echo $data['com'];?></textarea></p>
            </div>
            <input type="submit" value="Valider">
        </form>
        <div id="box_error"></div>
    </div>
    <script>
        $(document).ready(function(){
            function reloader(){ // redirection de page

                window.location.assign('../');
            }

            $('#formClient').submit(function(e){
                e.preventDefault();
                var $this = $(this);
                var name=$('#name').val();

                if( name=='' ){
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
                                $('#container').html('<p>Client modifier avec succès</p>');
                                setTimeout(reloader, 2500);
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