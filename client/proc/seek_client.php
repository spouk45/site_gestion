<?php
include('../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST['name']) || !isset($_POST['serial']) || !isset($_POST['city']) ) {
    echo 'Erreur lors de la récupération des données.';
    exit();
}

try{
    $data=null;
    if($_POST['name']!= null){
        $data['name']=$_POST['name'];
    }
    if($_POST['serial']!= null){
        $data['serial']='CL'.$_POST['serial'];
    }
    if($_POST['city']!= null){
        $data['city']=$_POST['city'];
    }


    //include(DIR_ROOT.'client/class/CustomerManager.php');
    include(DIR_ROOT.'/class/Generic.php');
    include(CONNECT);
    /*$CustomerManager=new CustomerManager($db);
    $data=$CustomerManager->getCustomer($seek);*/
    $CustomerManager=new Generic($db);
    $table='customer';
    $param='AND';
    $list='id,name,city,tel,status,serial';
    $order='name';
    $data=$CustomerManager->getData($table,$data,$param,$list,$order);


}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}
?>


<?php
$tabTitle=array('name'=>'Nom',
    'city'=>'Ville',
    'tel'=>'Téléphone',
    'serial'=>'n° client');
include (DIR_ROOT.'inc/table.php');?>
