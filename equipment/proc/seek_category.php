<?php
include('../../config.php');
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
    include(DIR_ROOT.'equipment/class/CategoryManager.php');
    include(CONNECT);
    $CategoryManager=new CategoryManager($db);
    $data=$CategoryManager->getCategory($seek);

    foreach($data as $key=>$value){
        if($value['frigo']==1){
            $data[$key]['frigo']='oui';
        }
        else {
            $data[$key]['frigo']='non';
        }
    }
}
catch(Exception $e){
    $json['reponse']=$e->getMessage();
    $json['bool']=false;
    echo json_encode($json);
    exit();
}
$tableParam['delete']=1;
$tableParam['edit']=1;
$tabTitle=array(
    'name'=>'Nom',
    'description'=>'Description',
    'frigo'=>'Contient du fluide frigo',
);

include (DIR_ROOT.'inc/table.php');
?>
<script>

    $('.td-delete>img').click(function(){
        var id=$(this).attr('data-id');
        $.post('../equipment/proc/delete_category.php',{'id':id}).done(function(data){
            $('#tr'+id).hide();
        });
    });



    $('.td-edit>img').click(function(){
        var id=$(this).attr('data-id');
        $.redirect('update_category.php', {'id': id});
    });
</script>
