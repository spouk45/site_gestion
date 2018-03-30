<?php include('../config.php');?>
<?php include(HEAD);?>

<?php session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

include(HEADER);
// on récupère la liste des status
include(CONNECT);
include(DIR_ROOT.'class/Generic.php');
$Gen=new Generic($db);
$table='status';
$field='';
$param='';
$list='id,name,timeAlert';
$order='';
$data=$Gen->getData($table,$field,$param,$list,$order);

$tabTitle=array('name'=>'status','timeAlert'=>'Nb jours avant alerte');

?><h2>Paramètres</h2>

<div class="detail">

    <div id="status" class="group">
        <h4><span>Status</span></h4>
            <form action="" method="POST" id="formNewStatus">
                <p>Nouveau status: <input type="text" id="nameStatus" name="nameStatus"></p>
            </form>
            <?php
            $tableParam['delete']=1;
            //$tableParam['edit']=1;
            include('../inc/table.php');?>
    </div>
</div>
<div id="boxError"></div>
<script>
    $(document).ready(function(){

        function isEmptyOrSpaces(str){
            return str === null || str.match(/^ *$/) !== null;
        }

        var nameStatus=$('#nameStatus');

        nameStatus.change(function(){
            var name=$('#nameStatus').val();

           if(!isEmptyOrSpaces(name)){
               $('#formNewStatus').trigger('submit');
           }

       }) ;

        $('#formNewStatus').submit(function(e){
            e.preventDefault();
            $.post('../status/proc/addStatus.php',$('#formNewStatus').serialize()).done(function(data){
                location.reload(true);
            });
        });

        $('.td-delete>img').click(function(){
            var id=$(this).attr('data-id');
            $.post('../status/proc/deleteStatus.php',{'id':id}).done(function(data){
                $('#tr'+id).hide();
            });
        })


/*
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
                $.post('../status/proc/updateStatus.php',{'id':id,'name':newName}).done(function(data){
                    //alert(data);
                    $('#tr'+id+'>td:first-child').html(newName);
                });
                //refermer le input

            });
        });
*/
        $('tr td:first-child').click(function(){

            var td=$(this);
            var tr=td.parent();
            var id=tr.attr('data-tr-id');

            if(!td.children('input').length){
                //alert('eiet');
                var name=$(this).text().trim();
                $(this).html('<input type="text" class="inputStatus" name="name" value="'+name+'" >');
                var input=$(this).children('input');
                input.focus();

                input.change(function(){
                    var newName=$(this).val();
                    $.post('../status/proc/updateStatus.php',{'id':id,'name':newName}).done(function(data){
                        //alert(data);
                        $('#tr'+id+'>td:first-child').html(newName);
                    });
                });
                input.focusout(function() {
                    $('#tr'+id+'>td:first-child').html(name);
                });
            }
        });

        $('tr td:nth-child(2)').click(function(){
            var td=$(this);
            var tr=td.parent();
            var id=tr.attr('data-tr-id');
            if(!td.children('input').length){
                var temp=$(this).text().trim();
                $(this).html('<input type="text" class="inputStatus" name="temp" value="'+temp+'" >');
                var input=$(this).children('input');
                input.focus();

                input.change(function(){
                    var newTemp=$(this).val();
                    $.post('../alert/proc/set_alert.php',{'id':id,'temp':newTemp}).done(function(data){
                        //alert(data);
                        td.html(newTemp);
                    });
                });
                input.focusout(function() {
                    td.html(temp);
                });
            }

        });

    });



</script>