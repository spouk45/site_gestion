<?php
include('../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST['id'])){
    echo 'Erreur lors de la récupération des données.';
    exit();
}

try{
    $id=$_POST['id'];

    include(CONNECT);
    include(DIR_ROOT.'equipment/class/EquipmentManager.php');
    $EquipmentManager=new EquipmentManager($db);
    $data=$EquipmentManager->getEquipment($id);

}
catch(Exception $e){
    echo $e->getMessage();
    exit();

}

// affichage de la liste de matos
$tabTitle=array(
    //'equipmentId'=>'Nom',
    //'clientId'=>'Marque',
    //'productId'=>'Catégorie',
    'mark'=>'Marque',
    'categoryName'=>'Type',
    'productName'=>'Nom',
    'serial'=>'N°série',
);
if(isset($_POST['edit'])){
    if($_POST['edit']==0){
        // pas d'affichage des modif
    }
}
else{
    $tableParam['delete']=1;
    $tableParam['edit']=1;
}

include (DIR_ROOT.'inc/table.php');



