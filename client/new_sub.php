<?php
include('../config.php');

include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

?>
<?php include(HEADER);?>

<?php
try{
    include(CONNECT);
    include(DIR_ROOT.'client/class/CustomerManager.php');
    $CustomerManager=new CustomerManager($db);
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

?><h2>Nouveau Sous-traitant</h2>
    <div id="formClient" class="detail">
        <form method="POST" action="<?php echo URL_ROOT.'client/proc/new_sub.php';?>" id="new">
            <div id="administratif" class="group">
                <h4><span>Sous-traitant</span></h4>
                <p>
                    <span> Nom: <input type="text" name="name" value="" id="name"></span>
                </p>
                <p id="gr_contact">Contact: <input type="text" name="contact" value="" id="contact"></p>
            </div>
            <div id="coord" class="group">
                <h4><span>Coordonnées client</span></h4>
                <div class="ib">
                    <h5>Adresse:</h5>
                    <p class="right"> Code postal: <input type="text" name="postal" id="postal" value="" pattern="^[0-9]{5,5}$"></p>
                    <p class="right"> Ville: <input type="text" name="city" id="city" value=""></p>
                    <p class="right">Numéro et rue: <input type="text" name="road" id="road" value=""></p>
                </div>
                <div class="ib">
                    <h5>Contact:</h5>
                    <p class="right"> Téléphone: <input type="text" name="tel" id="tel" value="" pattern="^[0-9]{0,10}$"></p>
                    <p class="right"> e-mail: <input type="text" name="mail" id="mail" value="" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"></p>
                </div>
            </div>
            <div id="com" class="group">
                <h4><span>Commentaire</span></h4>
                <p>
                    <textarea id="com" name="com"></textarea>
                </p>
            </div>
            <input type="submit" value="Valider">
        </form>
        <div id="box_error"></div>
    </div>
    <script>
        $(document).ready(function(){

            function reloader(){
                window.location.reload();
            }
            $('#new').submit(function(e){
                e.preventDefault();
                var $this = $(this);
                var name=$('#name').val();
                if(name==''){
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
                                $('#formClient').html('<p>Client ajouté avec succès.</p>');
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