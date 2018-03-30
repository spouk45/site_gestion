<?php include('../config.php');?>
<?php include(HEAD);
// controle d'acces
session_start();
if(!isset($_SESSION['user'])){
echo 'Accès refusé';
exit();
}
include(DIR_ROOT.'admin/inc/admin_acces.php');

include(DIR_ROOT.'admin/inc/header.php');
?>

<h2> Ajouter un utilisateur</h2>

<form id="add_user" method="POST" action="<?php echo URL_ROOT.'admin/proc/add_user.php';?>">
    Nom d'utilisateur: <input type="text" id="user_name" name="user_name">
    Mot de pass: <input type="text" id="user_password" name="user_password" value="0000">
    <input type="submit" id="add_submit" value="Valider">
</form>

<div id="error_box"></div>

<script>
    $(document).ready(function() {
        // Lorsque je soumets le formulaire
        $('#add_user').on('submit', function(e) {
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
            /*
            else if(/[$^+<>!#~`()]/.test(user_name) || /[\<\>]/.test(user_password) )
            {
                $('#error_box').html('<p>Login ou mot de pass incorrect.<p>');
            }*/

            else {
                // Envoi de la requête HTTP en mode asynchrone
                $.ajax({
                    url: $this.attr('action'),
                    type: $this.attr('method'),
                    data: $this.serialize(),
                    dataType: 'json', // JSON
                    success: function(json) {
                       // alert(json.bool);
                        if (json.bool === true) {
                            $('#error_box').html('<p>' + json.reponse + '</p><p><a href="<?php echo URL_ROOT.'admin/home.php';?>">Retour</a></p>');
                        } else {
                            $('#error_box').html('<p>' + json.reponse + '</p>');
                        }
                    }
                });
            }
        });
    });
</script>

<?php include(DIR_ROOT.'admin/inc/footer.php');?>