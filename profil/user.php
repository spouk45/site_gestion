<?php include('../config.php');?>
<?php include(HEAD);?>

<?php session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

include(HEADER);
?>
<h2>Gestion du Profil</h2>
<div id="wrapper">
    <div>
        <!-- compte -->
        <form method="POST" action="proc/user.php" id="form">
            <p><input type="text" value="<?php echo $_SESSION['user']['name'];?>" name="user" id="user"> <span class="form_info">- Modifiez votre nom d'utilisateur</span></p>
            <p><input type="password" name="oldPass" id="oldPass"> <span class="form_info">- Entrez votre ancien mot de passe</span></p>
            <p><input type="password" name="pass1" id="pass1"> <span class="form_info">- Entrez votre nouveau mot de passe</span></p>
            <p><input type="password" name="pass2" id="pass2"> <span class="form_info">- Entrez à nouveau</span></p>

            <p><input type="submit" value="Valider"></p>
        </form>
        <div id="boxError"></div>
    </div>

</div>

<script>
    $(document).ready(function(){

        $('#form').submit(function(e){
            e.preventDefault();
            var $this=$(this);
            var pass1=$('#pass1').val();
            var pass2=$('#pass2').val();
            var oldPass=$('#oldPass').val();


            var error=0;
            if(pass1.length<3){
                $('#boxError').html('<p>Minimum 4 caractères pour le mot de passe.</p>');
                error=1;
            }
            if(pass1!=pass2){
                $('#boxError').html('<p>Mot de passe différent</p>');
                error=1;
            }
            if(oldPass.length<3){
                $('#boxError').html('<p>Erreur sur l\'ancien mot de passe.</p>');
                error=1;
            }

            if(error==0){
                /* exec */
                var url=$this.attr('action');

                $.ajax({
                    method: "POST",
                    url: url,
                    data: $this.serialize()

                }).done(function(html){
                    alert(html);
                });
            }

        });



    });

</script>
