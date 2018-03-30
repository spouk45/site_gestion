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
    include(DIR_ROOT.'equipment/class/MarkManager.php');
    include(CONNECT);
    $MarkManager=new MarkManager($db);
    $data=$MarkManager->getMark($seek);


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
);

include (DIR_ROOT.'inc/table.php');
?>
<script>

    $('.td-delete>img').click(function(){
        var id=$(this).attr('data-id');
        $.post('../equipment/proc/delete_mark.php',{'id':id}).done(function(data){
            $('#tr'+id).hide();
        });
    });



    $('.td-edit>img').click(function(){
        var id=$(this).attr('data-id');
        var name=$('#tr'+id+' td:first-child').text();
        name=name.trim();
        $('#tr'+id+'>td:first-child').html('<input type="text" class="inputStatus" name="name" value="'+name+'" >');
        //$('#tr'+id+'>td:first-child').html('<p contenteditable="true" class="inputStatus">'+name+'</p>');

        $('.inputStatus').change(function(){
            // var newName=$(this).text();
            var newName=$(this).val();
            //alert(newName+id);
            // lancer un ajax pour la modification ds la bdd
            $.post('../equipment/proc/update_mark.php',{'id':id,'name':newName}).done(function(data){
                //alert(data);
                $('#tr'+id+'>td:first-child').html(newName);
            });
        });
    });
</script>
