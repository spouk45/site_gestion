<?php
include('../../config.php');
include(CONNECT);


try {
    $table = 'flu_bottle';
    $list = '';

    if (!isset($_POST['serial']) || !isset($_POST['gazId']) || !isset($_POST['typeId']) || !isset($_POST['fournisseurId']) || !isset($_POST['dateOfBuy'])) { //bug post existe sur un load
        throw new Exception('Erreur de récupération des donneés.');
    }
    $post = '';
    $param = '';
    $dataSend=null;
    $post = $_POST;
    $order='dateOfBuy DESC';


    if (isset($post['dateOfBuy']) && $post['dateOfBuy'] != 0) {
        $year = $post['dateOfBuy'];
        $year2 = $post['dateOfBuy'] + 1;
        $Date = new DateTime($year . '-01-01');
        $Date2 = new DateTime($year2 . '-01-01');
        $start = $Date->format('U');
        $end = $Date2->format('U');
        // on fait le trie des dates une fois les autres résultat déjà récupéré.
    }
    if (isset($post['serial']) && $post['serial']!=null) {
       $dataSend['serial']=$post['serial'];
    }
    if (isset($post['gazId']) && $post['gazId']!=null) {
        $dataSend['gazId']=$post['gazId'];
    }
    if (isset($post['typeId']) && $post['typeId']!=null) {
        $dataSend['typeId']=$post['typeId'];
    }
    if (isset($post['fournisseurId']) && $post['fournisseurId']!=null) {
        $dataSend['fournisseurId']=$post['fournisseurId'];
    }
    if($dataSend!=null){
        $param='AND';    }


    include(DIR_ROOT . 'class/Generic.php');
    include('../class/BottleManager.php');
    include('../class/MoveManager.php');
    $MoveManager=new MoveManager($db);
    $BottleManager=new BottleManager($db);
    $Gen = new Generic($db);
    include('../class/gazManager.php');
    $GazManager = new gazManager($db);
    include(DIR_ROOT . 'fournisseur/class/FournisseurManager.php');
    $FournisseurManager = new FournisseurManager($db);
    $data = $Gen->getData('flu_bottle', $dataSend, $param, $list,$order); // récupération des données de la base

// --- filtre des donées avec les dates ---
    if($data == null){
        throw new Exception('Aucune donnée trouvée');
    }
    if(isset($start)&&isset($end)) {
         foreach ($data as $key => $data2) {

            if ($data2['dateOfBuy'] < $start || $data2['dateOfBuy'] > $end) {
                unset($data[$key]);
            }
         }
    }

    // --- génération d'un array title
    $tabTitle = array(
        'serial' => 'n° de bouteille',
        'typeName' => 'Type de bouteille',
        'gazName' => 'Gaz',
        'charge' => 'Charge initiale',
        'chargeIn' => 'Charge actuelle',
        'fournisseurName' => 'Fournisseur',
        'dateOfBuyFr' => 'Date d\'achat',
        'dateOfSellFr' => 'Date rendu'
    );

    if ($data == null) {
        throw new Exception('Aucune donnée trouvée.');
    }

    foreach ($data as $key => $data2) {
        foreach ($data2 as $key2 => $value) {
            switch ($key2) {
                case 'id':
                    // recherche du contenu de la bouteille
                    $move=$MoveManager->getMove($value,'','');
                    //print_r($move);
                    $count=0;
                    foreach($move as $v){
                        $count+=$v['chargeIn']-$v['chargeOut'];
                    }
                    $data[$key]['chargeIn']=$count;
                    break;
                case 'dateOfBuy':
                    if ($value != null) {
                        $data[$key]['dateOfBuyFr'] = date('d m Y', $value);
                    }
                    break;

                case 'dateOfSell':
                    if ($value != null) {
                        $data[$key]['dateOfSellFr'] = date('d m Y', $value);
                    }
                    break;

                case 'gazId':
                    if($value!=null){
                        $dataGaz = $GazManager->getGaz($value);
                        $data[$key]['gazName'] = $dataGaz[0]['name'];
                    }
                   else{
                       $data[$key]['gazName']='';
                   }

                    //echo 'val: '.$value;
                    break;

                case 'typeId':
                    $dataType = $BottleManager->getType($value);
                    $data[$key]['typeName'] = $dataType;
                    break;

                case 'fournisseurId': // a faire
                    $comp['id'] = $value;
                    $list = 'name';
                    $dataFournisseur = $FournisseurManager->getData('fournisseur', $comp, '', $list,'');//array
                    $dataFournisseurName = $dataFournisseur[0]['name'];
                    $data[$key]['fournisseurName'] = $dataFournisseurName;

                    break;
            }
        }
    }
    /*?><pre><?php print_r($data); ?></pre><?php*/
}
catch(Exception $e){
$reponse=$e->getMessage();
    echo  '<p>'.$reponse.'</p>';
exit();
}
//$ref='id';
$tableParam['delete']=1;
$tableParam['edit']=1;
include(DIR_ROOT.'inc/table.php');

?>
<script>
    $(document).ready(function(){
       $('.td-edit').click(function(){
          var id=$(this).parent().attr('data-tr-id');
           $.redirect('edit_bottle.php',{'id':id});
          // alert(id);
       });

        $('.td-delete').click(function(){
            var id=$(this).parent().attr('data-tr-id');
            $.post('proc/deleteBottle.php',{'id':id},function(json){

                if(json.reponse!='ok'){
                    $('boxError').html(json.reponse);
                }
                else{
                    $('#tr'+id).css('display','none');
                }
            },'json');
        });
    });
</script>

