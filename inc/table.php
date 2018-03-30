
<?php if(!isset($tabTitle) && !isset($data)){
    echo 'il manque des données pour l\'affichage du tableau.';
    exit();
}
if(!array($tabTitle)){
    echo 'tabList doit etre array';
    exit();
}
if($data!=null){

    /* NEED:
         $tabTitle
         $data
    */
    /* PARAM:
            $tableParam['delete']
             $tableParam['edit']
    */
   /* ?><pre><?php print_r($data);?></pre><?php*/
?>

<table class="divTab">
   <thead>
    <tr>
        <?php foreach ($tabTitle as $value){
            echo '<th>'.$value.'</th>';
        }
        if(isset($tableParam['delete']) && !isset($tableParam['add'])) {
            ?><th><img class="ico" src="<?php echo URL_ROOT.'img/delete.png';?>"></th><?php
        }
        if(isset($tableParam['edit']) && !isset($tableParam['add']))  {
            ?><th><img class="ico" src="<?php echo URL_ROOT.'img/edit.png';?>"></th><?php
        }
        if(isset($tableParam['add'])) {
            ?><th><img class="ico" src="<?php echo URL_ROOT.'img/add.png';?>"></th><?php
        }
        ?>
    </tr>
   </thead>
    <tbody>
    <?php foreach ($data as $data2){?>
        <tr class="row" <?php echo 'id=tr'.$data2['id'];?> data-tr-id="<?php echo $data2['id'];?>" >
            <?php foreach($tabTitle as $key=>$value){
                ?><td>

                <?php
                if(isset($data2[$key])) {
                    echo nl2br(htmlentities($data2[$key]));
                }
            ?> </td><?php
            }
            if(isset($tableParam['delete']) && !isset($tableParam['add'])){
                ?><td class="td-delete"><img class="ico hover" src="<?php echo URL_ROOT.'img/delete.png';?>" data-id="<?php echo $data2['id'];?>"></td><?php
            }
            if(isset($tableParam['edit']) && !isset($tableParam['add'])){
                ?><td class="td-edit"><img class="ico hover" src="<?php echo URL_ROOT.'img/edit.png';?>" data-id="<?php echo $data2['id'];?>"></td><?php
            }
            if(isset($tableParam['add'])){
                ?><td class="td-add"><img class="ico hover" src="<?php echo URL_ROOT.'img/add.png';?>" data-id="<?php echo $data2['id'];?>"></td><?php
            }
            ?>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php }
else {echo 'Aucune donnée trouvée.';}