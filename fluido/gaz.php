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

<!-- affichage des filtres -->
<?php
// list des gaz
include (CONNECT);
include(DIR_ROOT.'fluido/class/GazManager.php');
$GazManager=new GazManager($db);
$data=$GazManager->getGaz('');

$tabTitle=array('name'=>'Nom');
$tableParam['delete']=1;
$tableParam['edit']=1;

?>
<div id="wrapper">

    <form method="POST" action="proc/addGaz.php" id="gazForm">
        <p>Ajout d'un gaz:</p>
        <p><input type="text" name="name" id="name" placeholder="Nom du gaz">
        <input type="submit" value="+"></p>
    </form>
    <div id="boxError"></div>
    <div id="gaz" class="cadre"></div>
</div>

<?php include(DIR_ROOT.'inc/table.php'); ?>

<script>
    $(document).ready(function() {

        var form = $('#gazForm');
        form.on('submit', function(e) {
            e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire

            var $this = $(this);


            $.ajax({
                url: $this.attr('action'),
                type: $this.attr('method'),
                data: $this.serialize(),
                dataType:'json',
                success: function(json) {
                    $('#gaz').html(json);
                   // location.reload();
                   if(json.reponse!='ok'){
                       $('#boxError').html(json.reponse);
                   }
                    else{
                       location.reload();
                   }
                }
            });

        });

        $('.td-edit').click(function(){
           var $this=$(this);
            var tr=$this.parent();
            var id=tr.attr('data-tr-id');
            var tdName=tr.children('td:first-child');
            var name=tdName.text().trim();
            tdName.html('<input type="text" value="'+name+'">');
            //alert(name);
            var input=tdName.children('input');
            input.focus();
            input.change(function(){
               var newName=input.val();
                $.post('proc/updateGaz.php',{'name':newName,'id':id},function(json){
                    if(json.reponse!='ok'){
                        $('#boxError').html(json.reponse);
                    }
                    else{
                        tdName.html(newName);
                    }
                },'json');
            });
            input.focusout(function(){
                tdName.html(name);
            });
        });

        $('.td-delete').click(function(){
            var id=$(this).parent().attr('data-tr-id');
            var $this=$(this);
            var rep=confirm('Etes vous sur de vouloir supprimer ce gaz?');
            if(rep==true){
                $.post('proc/deleteGaz.php',{'id':id},function(json){
                    if(json.reponse!='ok'){
                        $('#boxError').html(json.reponse);
                    }
                    else{
                        $this.parent().hide();
                    }
                },'json');
            }

        });


    });
</script>
