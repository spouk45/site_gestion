<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

include(HEADER);

?>

<!-- navigation fluido -->
<ul>
    <li>gestion des bouteilles
        <ul>
            <li><a href="bottle.php">gestion des bouteilles</a></li>
            <li><a href="gaz.php">gestion du gaz</a></li>
            <li><a href="move.php">gestion mouvement de fluide</a></li>
            <li><a href="bilan.php">Bilan</a></li>
        </ul>
    </li>


</ul>

