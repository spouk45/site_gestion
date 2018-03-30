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
  <?php



?><h2>Nouvelle marque</h2>
    <div id="wrapper">
        <form method="POST" action="<?php echo URL_ROOT.'equipment/proc/addMark.php';?>" id="new">
            <p>Nom: <input type="text" name="name" value="" id="name"></p>
            <p> <input type="submit" value="Valider"></p>
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
                                $('#wrapper').html('<p>Nouvelle marque ajoutée avec succès.</p><p><a href="">Ajouter une nouvelle marque</a></p>')
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