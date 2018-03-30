<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
if(!isset($_POST['id'])){
    echo '<p>erreur de récupération des données.</p>';
    exit();
}


include(HEADER);?>
<h2>Historique</h2>


<?php
try{

    if(!is_numeric($_POST['id'])){
        echo '<p>id doit etre numéric.</p>';
    }
    $clientId=$_POST['id'];
    include(DIR_ROOT.'/class/Generic.php');
    include(CONNECT);
    $Gen=new Generic($db);
    $table='customer';
    $data['id']=$_POST['id'];
    $param='';
    $list='';
    $order='';
    $data=$Gen->getData($table,$data,$param,$list,$order);
    $data=$data[0];

    $civilityId['id']=$data['civilityId'];
    $data['civility']=$Gen->getData('civility',$civilityId,'','tag','');
    $data['civility']= $data['civility'][0]['tag'];
    if($data['status']==0){
        $data['statusName']='Prospect';
    }
    else {
        $data['statusName']='client';
    }
    $subId['id']=$data['sub_id'];
    $data['sub']=$Gen->getData('sub',$subId,'','name','');
    $data['sub']= $data['sub'][0]['name'];
    if($data['contact']==null){

    }
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}



?><div id="viewClient" class="detail">
    <div>
        <div id="administratif" class="group">
            <h4><span>Client</span></h4>
            <p>
                <span id="serial">N°client: <?php echo $data['serial'];?></span>
                <span id="statusName"><?php echo $data['statusName'];?></span>
            <p>
                <span id="civility"><?php  echo $data['civility'];?></span>
                <span id="name"><?php echo $data['name'];?></span>
                <span id="firstName"><?php echo $data['firstName'];?></span>
            </p>
        </div>

        <div id="equipment" class="group">
            <h4><span>Equipement</span></h4>
            <div id="contentEquipment" ></div>
        </div>
    </div>
</div>

<div id="historique" class="detail">
    <div class="group">
        <h4><span>Ajouter un rapport</span></h4>
        <div id="boxError"></div>
        <form method="POST" action="" id="historyForm">
            <input type="hidden" id="customerId" value="<?php echo $_POST['id'];?>">
          <p> Date: <input type="text" id="historyDate" name="historyDate" class="datePicker"></p>
           <p> <textarea id="historyText" name="historyText"></textarea></p>

            <input type="submit" value="Envoyer">
        </form>
    <div id="boxSucces"></div>
    </div>
    <div class="group">
        <h4><span>Historique</span></h4>
        <div id="historyList"></div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var id=$('#customerId').val(); // récupérer via hidden status
        $.post('../equipment/load/equipmentClient.php',{'id':id,'edit':0}).done(function(data){
            //data=JSON.parse(data);
            $('#contentEquipment').html(data);
            loadCheckBox($('#contentEquipment'));
            formSubmit();
            $('#contentEquipment :checkbox').click(function(){
               filterProduct();
            });
        });

        getHistory();
        var tbody=$('#contentEquipment table tbody');

    });

    function loadCheckBox(container){
        var table=container.children('table');
        var thead=table.children('thead');
        var tbody=table.children('tbody');

        var contentThead=thead.children('tr').html();
        var newContentThead=contentThead+='<th><input id="allCheck" type="checkbox" checked></th>';
        var newThead='<tr>'+newContentThead+'</tr>';
        //alert(newThead);
        thead.html(newThead);

        var newContentTbody='';
        tbody.children('tr').each(function(){

            var id=$(this).attr('data-tr-id');
            var actual=$(this).html();
            actual+='<td><input type="checkbox" checked></td>';
            newContentTbody+='<tr class="row" data-tr-id="'+id+'">'+actual+'</tr>';
            tbody.html(newContentTbody);
        });

        $('#allCheck').click(function(){
          if($(this).is(':checked')){
              tbody.children('tr').each(function(){
                  var id=$(this).attr('data-tr-id');
                  $(this).find('input[type=checkbox]').prop('checked',true);
              });

          }
            else{
              tbody.children('tr').each(function(){
                  var id=$(this).attr('data-tr-id');
                  $(this).find('input[type=checkbox]').prop('checked',false);
              });

          }
        });

    }

    function formSubmit(){
        $('#historyForm').submit(function(e){
            e.preventDefault();
            // récupération des id selectionné
            var tbody=$('#contentEquipment table tbody');
            var table=[];
            var i=0;
            tbody.find('input:checked').each(function(){
                    table[i]=$(this).parents('tr').attr('data-tr-id');
                    i++;
            });

            var date=$('#historyDate').val();// récupération de la date
            var text=$('#historyText').val();

            $.post('proc/addHistory.php',{'equipmentId':table,'date':date,'text':text},function(json){
                if(json.reponse!='ok'){
                    $('#boxError').html(json.reponse);
                    $('#boxSucces').html('');
                }
                else{
                   $('#boxSucces').html('<p>Historique ajouté avec succès.</p>');
                    $('#boxError').html('');
                    getHistory();
                }

               // alert(json.reponse);
            },'json');
            //alert(date +'<br>'+ text +'<br>'+ table);
        });
    }

    function getHistory(){
        var clientId=$('#customerId').val(); // récupérer via hidden status
        $.post('proc/historyList.php',{'clientId':clientId},function(data){

            $('#historyList').html(data);

        });

    }

    function filterProduct(){
        // on récupère la selection
        var tbody=$('#contentEquipment table tbody');
        var table=[];
        var i=0;
        tbody.find('input:checkbox:not(:checked)').each(function(){
            table[i]=$(this).parents('tr').attr('data-tr-id');
            i++;
        });
        //alert(table);
        // on récupère la liste des histo
        var list=$('#historyList .cadreHistory');
        // on display off ceux qui ne sont pas selectionné

        list.each(function(){
            $(this).show();
        });
        list.each(function(){
            var k=0;
            var i=0;
            $('ul li').each(function(){
                var $this=$(this);
                k++;
                $.each(table,function(key,val){

                    if($this.attr('data-equipmentId')== val){
                        i++;
                        $this.css('color','red');
                    }

                });

            });
            var count=k-i;
            if(count==0){
                $(this).hide();
                //$this.parents('.cadreHistory').css('border','14px solid');
                //  alert($this.parent('ul').text());
            }

        });

    }

</script>