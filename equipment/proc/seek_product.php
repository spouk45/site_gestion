<?php
include('../../config.php');
header(CHARSET);

session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST['name'])){
    echo 'Erreur lors de la récupération des données.';
    exit();
}

try{
    $data=$_POST;
    include(DIR_ROOT.'equipment/class/ProductManager.php');
    include(CONNECT);
    $ProductManager=new ProductManager($db);
    $data=$ProductManager->getProduct($data);
    //print_r($data);
}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    $json['bool']=false;
    echo json_encode($json);
    exit();
}

$tabTitle=array(
    'productName'=>'Nom',
    'markName'=>'Marque',
    'categoryName'=>'Catégorie',
    'description'=>'description'
    );

$tableParam['delete']=1;
$tableParam['edit']=1;
if(isset($_POST['add'])){
    $tableParam['add']=1;
}

include (DIR_ROOT.'inc/table.php');

?>
<script>

    $('.td-delete>img').click(function(){
        var id=$(this).attr('data-id');
        $.post('../equipment/proc/delete_product.php',{'id':id}).done(function(data){
            $('#tr'+id).hide();
        });
    });



    $('.td-edit>img').click(function(){
        var id=$(this).attr('data-id');

        $.redirect('update_product.php', {'id': id});
    });
</script>
