<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

include(HEADER);
try{
    if(!isset($_POST['id'])){
        throw new Exception('Erreur de récupération des données.');
    }

    $id=$_POST['id'];
    // on récupère les données de la bouteille

    include(CONNECT);
    include(DIR_ROOT.'fluido/class/BottleManager.php');
    include(DIR_ROOT.'class/Generic.php');
    $BottleManager=new BottleManager($db);
    $bottle=$BottleManager->getBottle($_POST);
    if($bottle==null){throw new Exception('Aucune donnée trouvée.');}
    $bottle=$bottle[0];
    // formatage de la date
    if($bottle['dateOfBuy']!=null){
        $Date=new DateTime();
        $Date->setTimestamp($bottle['dateOfBuy']);
        $bottle['dateOfBuy']=$Date->format('d/m/Y');
    }
   if($bottle['dateOfSell']!=null){
       $Date=new DateTime();
       $Date->setTimestamp($bottle['dateOfSell']);
       $bottle['dateOSell']=$Date->format('d/m/Y');
   }

    //print_r($bottle);

    // recup des type de gaz
    $Gen=new Generic($db);
    $listType='id,name';
    $gazList=$Gen->getData('flu_gaz','','',$listType,'');
    // print_r($gazList);

    //recup des type de bouteille
    $listType='id,name';
    $typeBottleList=$Gen->getData('flu_type','','',$listType,'');

    // recup liste fournisseur
    $listType='id,name';
    $fournisseurList=$Gen->getData('fournisseur','','',$listType,'');


}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

?><h2>Edition d'une bouteille</h2>
<div id="wrapper" class="detail">
    <form method="POST" action="<?php echo URL_ROOT.'fluido/proc/editBottle.php';?>" id="formEditBottle">
        <input type="hidden" name="id" id="id" value="<?php echo $bottle['id'];?>">
        <p>Type de bouteille:
            <label for="typeId"></label><select id="typeId" name="typeId">
                <?php foreach ($typeBottleList as $value){
                    ?><option value="<?php echo $value['id'];?>" <?php if($value['id']==$bottle['typeId']){echo 'selected';}?> ><?php echo $value['name'];?></option>
                <?php } ?>
            </select>
        </p>
        <p>N° de série: <input type="text" id="serial" name="serial" value="<?php echo $bottle['serial'];?>"></p>
        <p>Date d'achat: <input type="text" id="dateOfBuy" name="dateOfBuy"  value="<?php echo $bottle['dateOfBuy'];?>" maxlength="10" pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d"></p>
        <p>Date rendu: <input type="text" id="dateOfSell" name="dateOfSell"  value="<?php echo $bottle['dateOfSell'];?>" maxlength="10" pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d"></p>
        <div id="ifCharge">
            <p>Type de gaz:
                <label for="gazId"></label><select id="gazId" name="gazId">
                    <option value=""></option>
                    <?php foreach ($gazList as $value){
                        ?><option value="<?php echo $value['id'];?>" <?php if($value['id']==$bottle['gazId']){echo 'selected';}?> ><?php echo $value['name'];?></option>
                    <?php } ?>
                </select>
            </p>
            <p>charge en Kg: <input type="text" id="charge" name="charge" value="<?php echo $bottle['charge'];?>"></p>
        </div>
        <p>Fournisseur:
            <label for="fournisseurId"></label><select id="fournisseurId" name="fournisseurId">
                <?php foreach ($fournisseurList as $value){
                    ?><option value="<?php echo $value['id'];?>" <?php if($value['id']==$bottle['fournisseurId']){echo 'selected';}?> ><?php echo $value['name'];?></option>
                <?php } ?>
            </select>
        </p>
        <p><input type="submit" name="submit" id="submit" value="Valider"></p>
    </form>
    <div id="boxError"></div>
</div>
<script>
    function checkType(){
        var typeName= $('#typeId option:selected').text();
        if(typeName=='charge'){
            $('#ifCharge').css('display','block');
        }
        else {
            $('#ifCharge').css('display','none');
        }
        //alert(typeName);
    }

    $(document).ready(function() {

        checkType();// init au chargement
        $('#typeId').change(function(){
            checkType();
        });


        $('#formEditBottle').submit(function(e){
            e.preventDefault();
            var $this=$(this);
            var url=$this.attr('action');
            var data=$this.serialize();

            $.post(url,data,function(json){
                // alert(json.reponse);
                if(json.reponse!='ok'){
                    $('#boxError').html(json.reponse);
                }
                else{
                    $('#wrapper').html('<p>Bouteille modifié avec succès.</p><p><span class="hover" onclick="history.back();">Retour</span></p>');
                }
            },'json');
        });



    });

</script>



