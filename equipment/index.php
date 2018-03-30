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
<h2>Menu Produits</h2>
<!--
<div id="seek_customer">
    Recherche: <input type="text" name="seek" id="seek" />
</div>
-->

<div>
    <ul>
        <li><a href="<?php echo URL_ROOT.'equipment/new_product.php';?>">Ajouter un produit</a></li>
        <li><a href="<?php echo URL_ROOT.'equipment/new_product_category.php';?>">Ajouter une catégorie de produit</a></li>
        <li><a href="<?php echo URL_ROOT.'equipment/product.php';?>">Rechercher un produit</a></li>
        <li><a href="<?php echo URL_ROOT.'equipment/category.php';?>">Voir les Catégories de produits</a></li>
        <li><a href="<?php echo URL_ROOT.'equipment/mark.php';?>">Editer une marque</a></li>
        <li><a href="<?php echo URL_ROOT.'equipment/new_mark.php';?>">Ajouter une marque</a></li>
    </ul>
</div>

<?php include(FOOTER);?>

