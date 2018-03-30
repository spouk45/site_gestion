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
<h2>Gestion des status</h2>

<?php

/* FICHIER EN ATTENTE */
?>
<!-- affichage tableau -->
<?php $tabTitle=array('name'=>'Nom');?>
<div id="client" class="cadre ">
    <?php include (DIR_ROOT.'inc/table.php');?>
</div>