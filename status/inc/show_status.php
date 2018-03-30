<?php
if(!isset($_POST['id'])) {
    echo 'Erreur lors de la récupération des données id client.';
    exit();
}
try{ // en cours
    // chercher si un status_client exist
    $customerId=$_POST['id'];
    include(CONNECT);

    $Gen=new Generic($db);
    $table='status_client';
    $param='';
    $list='id,date,customerId,statusId';
    $order='';
    $seek=array('customerId'=>$customerId);
    $status=$Gen->getData($table,$seek,$param,$list,$order);



    $table='status';
    $list='id,name';
    $statusList=$Gen->getData($table,'',$param,$list,$order);
    $Date=new DateTime();
$date=null;
    if($status==null){
        $day=$Date->format('d-m-Y');
    }
    else {
        $status=$status[0];
       // $Day=new DateTime($status['date']);
        $date=date('d/m/Y',$status['date']);
       // $day=$Day->format('d/m/Y');
    }
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

?>
<div id="editStatus">
    <form id="formStatus" action="" method="POST">
        <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId;?>">
        <input type="hidden" id="id" name="id" value="<?php echo $status['id'];?>">
        <p>
            <label for="status"></label><select id="statusId" name="statusId">
                <option value=""></option>

            <?php foreach($statusList as $value){
                ?><option value="<?php echo $value['id'];?>"
                <?php if($status!=null){
                    if($value['id']==$status['statusId']){
                        echo 'selected';
                    }
                } ?>
                >  <?php echo $value['name'];?>
                </option>
            <?php } ?>
        </select>

       <span><label for="date">le </label>
        <input type="text" id="date" name="date" value="<?php echo $date;?>"></span>
        </p>
    </form>
    <div id="boxErrorStatus"></div>
</div>

<script>
    $(document).ready(function() {
        $('#statusId').change(function(){


           //$('#date').val();
            var dateBefore=$('#date').val();
            var d=new Date();
            var day=('0'+d.getDate()).slice(-2);
            var month= (('0'+d.getMonth()+1).slice(-2));
            var year= d.getFullYear();
            var date=day+'/'+month+'/'+year;
            $('#date').val(date);
            $('#boxErrorStatus').html('<img class="loading" src="../img/loading.gif">');
            $('#formStatus').trigger('submit');
        });


        $('#date').change(function(){
            $('#boxErrorStatus').html('<img class="loading" src="../img/loading.gif">');
            $('#formStatus').trigger('submit');
        });

        $('#formStatus').submit(function(e){
            e.preventDefault();

            $.post( "../status/proc/set_status.php",$('#formStatus').serialize() ).done(function(data){
                $('#boxErrorStatus').html(data);
            });

        });
    });
</script>
