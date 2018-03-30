<?php include('../config.php');?>
<?php include(HEAD);?>

<?php session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

include(HEADER);?>
<h2>Gestion du Profil</h2>
<div id="wrapper">
    <div>
        <!-- compte -->
        <ul>
            <li><a href="user.php">Modification du compte</a></li>
        </ul>
    </div>
    <div>
        <!-- gestion des utilisateur/droit d'acces -->
        <ul>
            <li>Créer un nouveau compte</li>
            <li>Modifier un compte</li>
            <li>Gestion des autorisations d'accès</li>

        </ul>
    </div>
</div>