<?php
include('../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST['name'])) {
    echo 'Erreur lors de la récupération des données.';
    exit();
}

try{
    $data=null;
    if($_POST['name']!= null){
        $data['name']=$_POST['name'];
    }

    include(DIR_ROOT.'/class/Generic.php');
    include(CONNECT);
    $CustomerManager=new Generic($db);
    $table='sub';
    $param='';
    $list='id,name,city,tel,contact';
    $order='name';
    $data=$CustomerManager->getData($table,$data,$param,$list,$order);

}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

$tabTitle=array('name'=>'Nom',
    'city'=>'Ville',
    'tel'=>'Téléphone',
    'contact'=>'Contact');
include (DIR_ROOT.'inc/table.php');?>
