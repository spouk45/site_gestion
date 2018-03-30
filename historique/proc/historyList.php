<?php
include('../../config.php');
header(CHARSET);

//print_r($_POST);
try{
    // --------- Verification droit ---------
    session_start();
    if(!isset($_SESSION['user'])){
        echo 'Accès refusé';
        throw new Exception('erreur de connection');
        //exit();
    }
    // ------------------------------------

    // **** R�cup�ration des donn�es ****
    //print_r($_POST);
    if(!isset($_POST)){
        throw new Exception('Aucune données récupérer');
    }
    if(empty($_POST['clientId'])){
        throw new Exception('il manque des données');
    }

    $clientId=$_POST['clientId'];

    include(CONNECT);
    include('../class/History.php');
    include('../class/HistoryManager.php');

    $data=array();
    $HistoryManager=new HistoryManager($db);
    $data=$HistoryManager->getHistory($clientId,false);

    $groupEquipment='';

    foreach ($data as $key=>$value){
       foreach($value as $key2=>$value2){
           //echo $key2;
        switch($key2){
            case 'historyLinkId';
                //$groupEquipment[$value2][]=array(
                $groupEquipment[$value2][]=array(
                    'productName'=>$data[$key]['productName'],
                    'equipmentId'=>$data[$key]['equipmentId'],
                    'serial'=>$data[$key]['serial'],
                    'repere'=>$data[$key]['repere'],
                    );
                break;
            }
       }
    }

    $data2=array();
    $data2=$HistoryManager->getHistory($clientId,true);

    foreach ($data2 as $key=>$value){
        foreach($value as $key2=>$value2){
            //echo $key2;
            switch($key2){

                case 'date':
                    //echo $value['date'];
                    $data2[$key][$key2]=date('d-m-Y',$value2);
                    break;
                case 'historyLinkId':
                    $data2[$key]['product']=$groupEquipment[$value2];
                    break;
            }
        }
    }
}
catch(Exception $e){
    //$json['reponse']=$e->getMessage();
    //echo json_encode($json,JSON_UNESCAPED_UNICODE);
    echo $e->getMessage();
    exit();
}
//$json['reponse']='ok';
//$json['data']=
  /* ?><pre><?php print_r($data);?></pre><?php*/
  /* ?><pre><?php print_r($data2);?></pre><?php*/

    foreach($data2 as $value){
    ?><div class="cadreHistory" data-id="<?php echo $value['id'];?>">
            <div class="titleHistory">
                <div class="optionBlock">
                    <span><img src="<?php echo URL_ROOT.'img/edit.png';?>" class="buttonEdit" data-id="<?php echo $value['id'];?>"></span>
                    <span><img src="<?php echo URL_ROOT.'img/delete.png';?>" class="buttonDelete" data-id="<?php echo $value['id'];?>"></span>
                </div>
            <p class="date"><?php echo 'Le: '.$value['date'];?> <span><img src="<?php echo URL_ROOT.'img/arrow-hide.gif';?>" class="toShow"></span></p>
                <ul class="equipmentList">
                <?php foreach($value['product'] as $product){
                     ?> <li data-equipmentId="<?php echo $product['equipmentId'];?>"><?php echo 'Produit: '.$product['repere'].' - '.$product['productName'].' - '.$product['serial'];?></li><?php
                }?></ul>

            </div>
        <div class="contentHistory">
              <p><?php echo nl2br($value['text']);?></p>
        </div>
     </div>
<?php }

?>
<script>
    $(document).ready(function() {
        $('.toShow').click(function(){
            var div=$(this).closest('div.titleHistory');
            var ul=div.children('ul');
            ul.toggle();
        });

        $('.buttonEdit').click(function(){
            var id=$(this).attr('data-id');
            //edit(id);
            var div=$(this).closest('div.cadreHistory');
            var cible=div.children('div.contentHistory');
            var lastText=cible.html();
            var newText='<textarea class="textareaHistory">'+lastText+'</textarea>';
            cible.html(newText);

            $('.textareaHistory').focusout(function(){
                var text=$(this).val();
                //alert(text);
                cible.html(text);
                $.post('proc/editHistory.php',{'id':id,'text':text},function(json){
                },'json');
            });
        });

        $('.buttonDelete').click(function(){
           var $this=$(this);
            var id=$(this).attr('data-id');
            $.post('proc/deleteHistory.php',{'id':id},function(json){
                $this.closest('.cadreHistory').hide();
            },'json');
        });
    });



</script>


