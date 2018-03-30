<?php
include('../../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST['seek'])){
    echo 'Erreur lors de la récupération des données.';
    exit();
}

try{
    $seek=$_POST['seek'];
    include(DIR_ROOT.'module/product/class/ProductManager.php');
    include(CONNECT);
    $ProductManager=new ProductManager($db);
    $data=$ProductManager->getProduct($seek);

}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    $json['bool']=false;
    echo json_encode($json);
    exit();
}
?>
<div>
    <ul>
        <?php
        if($data!=null){
            foreach($data as $value){
                ?><li onclick="selectProduct('<?php echo $value['id'];?>','<?php echo $value['name'];?>')">
                    <?php echo $value['name'].' ';?>
                </li>
            <?php }
        }?>
    </ul>
</div>
