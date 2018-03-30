<?php include('config.php');?>
<?php include(HEAD);?>

<?php session_start();
if(isset($_SESSION['user']['id'])){
    header('location:'.URL_ROOT.'home.php');
}?>

<div id="screen">
    <div id="connect">
        <form method="POST" action="<?php echo URL_ROOT.'register/proc/user_connect.php';?>" id="form_connection">
            <p><input autofocus placeholder="Nom d'utilisateur" type="text" id="user_name" name="user_name" /></p>
               <p> <input placeholder="Mot de passe" type="password" id="user_password" name="user_password" /></p>
                <p><input type="submit" id="user_submit" name="user_submit" value="Valider" /></p>
        </form>
        <div id="error_box" class="text_error"></div>
    </div>
</div>


    <script>
        $(document).ready(function() {
            // Lorsque je soumets le formulaire
            $('#form_connection').on('submit', function(e) {
                e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire

                var $this = $(this); // L'objet jQuery du formulaire

                // Je récupère les valeurs
                var user_name = $('#user_name').val();
                var user_password = $('#user_password').val();

                // Je vérifie une première fois pour ne pas lancer la requête HTTP
                // si je sais que mon PHP renverra une erreur
                if(user_name === '' || user_password === '') {
                    $('#error_box').html('<p>Les champs doivent êtres remplis<p>');
                }
                else if(/[$^+<>!#~`()]/.test(user_name) || /[\<\>]/.test(user_password) )
                {
                    $('#error_box').html('<p>Login ou mot de pass incorrect.<p>');
                }

                else {
                    // Envoi de la requête HTTP en mode asynchrone
                    $.ajax({
                        url: $this.attr('action'),
                        type: $this.attr('method'),
                        data: $this.serialize(),
                        dataType: 'json', // JSON
                        success: function(json) {
                            if (json.reponse === 'ok') {
                                document.location.href = '<?php URL_ROOT;?>';
                            } else {
                                $('#error_box').html('<p>' + json.reponse + '<p>');
                            }
                        }
                    });
                }
            });
        });
    </script>
<? include (FOOTER);?>