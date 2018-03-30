<?php

include ('config.php');

$data=array('name'=>'aevav',
    'id'=>1
    );

try {
    //include('fournisseur/class/Fournisseur.php');
    //$Fournisseur=new Fournisseur($data);
    include(CONNECT);
    include('fournisseur/class/FournisseurManager.php');
    $FournisseurManager=new FournisseurManager($db);

    $FournisseurManager->deleteFournisseur(1);

}catch(Exception $e){
    $reponse=$e->getMessage();

    echo $reponse;
    exit();
}
echo 'succès';