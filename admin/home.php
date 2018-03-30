<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
// controle d'acces
 session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
include(DIR_ROOT.'admin/inc/admin_acces.php');

// -------------
?> <nav>
    <ul>
        <li><a href="<?php echo URL_ROOT.'admin/add_user.php';?>">Ajouter un utilisateur</a></li>
        <li><a href="<?php echo URL_ROOT.'admin/user_list.php';?>">Liste des utilisateurs</a></li>
        <li><a href="<?php echo URL_ROOT.'admin/set_user.php';?>">Modifier un utilisateur</a></li>
    </ul>
</nav>





<? include (FOOTER);?>