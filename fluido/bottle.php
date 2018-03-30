<?php include('../config.php');?>
<?php include(HEAD);?>
<?php
session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}
$new_bottle=1;
include(HEADER);

?>


<!-- affichage des filtres -->
<?php
// list des gaz
include (CONNECT);
include(DIR_ROOT.'fluido/class/GazManager.php');
$GazManager=new GazManager($db);
$gazList=$GazManager->getGaz('');

// liste des type de bouteilles
include(DIR_ROOT.'class/Generic.php');
$Type=new Generic($db);
$typeList=$Type->getData('flu_type','','','id,name','');

// liste des fournisseurs
$Fournisseur=new Generic($db);
$fournisseurList=$Fournisseur->getData('fournisseur','','','id,name','');
/*?><pre><?php print_r($fournisseurList);?></pre><?php*/

// selection de l'année en cours
$y=date('Y',time());

?>


<div id="filter" class="filter">
    <h3>Recherche</h3>
    <div> <form method="POST" action="proc/listBottle.php" id="formFilter">
            <p>Numéro de bouteille: <label for="serial"></label><input type="text" name="serial" id="serial" value=""></p>
            <p>Gaz:
                <label for="gazId"></label><select id="gazId" name="gazId">
                    <option value="" selected></option>
                    <?php foreach($gazList as $value) { ?>
                        <option value = "<?php echo $value['id'];?>" ><?php echo $value['name'];?></option >
                    <?php }?>
                </select>
            </p>
            <p>Type de bouteille:
                <label for="typeId"></label><select id="typeId" name="typeId">
                    <option value="" selected></option>
                    <?php foreach($typeList as $value) { ?>
                        <option value = "<?php echo $value['id'];?>" ><?php echo $value['name'];?></option >
                    <?php }?>
                </select>
            </p>
            <p>Fournisseur:
                <label for="fournisseurId"></label><select id="fournisseurId" name="fournisseurId">
                    <option value="" selected ></option>
                    <?php foreach($fournisseurList as $value) { ?>
                        <option value = "<?php echo $value['id'];?>" ><?php echo $value['name'];?></option >
                    <?php }?>
                </select>
            </p>
            <p>
                Année d'achat:<label for="dateOfBuy"></label><input type="text" name="dateOfBuy" id="dateOfBuy" value="<?php echo $y;?>">
            </p>

        </form>
    </div>
</div>



<!-- affichage tableau -->
<div id="bottle" class="cadre"></div>
<script>
    $(document).ready(function() {

        var form = $('#formFilter');
        form.on('submit', function(e) {
            e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire

            var $this = $(this);

            $.ajax({
                url: $this.attr('action'),
                type: $this.attr('method'),
                data: $this.serialize(),
                success: function(html) {
                    $('#bottle').html(html);
                }
            });

        });

        function result(){
            form.trigger( "submit" );
        }
        // -- Envoie de la requete au chargement de la page. --
        result();

        // -- on change --
        var formChildren = $('#formFilter > *' );
        formChildren.change(function(){
            result();
        })
    });
</script>
