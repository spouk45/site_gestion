<?php include('config.php');?>
<?php include(HEAD);?>

<?php session_start();
if(!isset($_SESSION['user'])){
    echo 'Accès refusé';
    exit();
}

 include(HEADER);?>
<h2>Accueil</h2>
<div id="home-nav">

    <div>
        <p class="homeTitle">Client</p>
        <p class="img"><a href="client/"><img src="img/nav/client.png"></a></p>
    </div>
    <div>
        <p class="homeTitle">Retour chantier</p>
        <p class="img"><a href="historique/"><img src="img/nav/rapport.png"></a></p>
    </div>
    <div>
        <p class="homeTitle">Sous-traitant</p>
        <p class="img"><a href="client/sub.php"><img src="img/nav/sub.jpg"></a></p>
    </div>
    <div>
        <p class="homeTitle">Paramètres</p>
        <p class="img"><a href="setting/index.php"><img src="img/nav/setting.png"></a></p>
    </div>
    <div>
        <p class="homeTitle">Produits</p>
        <p class="img"><a href="equipment/index.php"><img src="img/nav/pompe.png"></a></p>
    </div>
    <div id="alert">
        <p class="homeTitle" id="alertTitle">Alerte</p>
        <p class="img"><a href="alert/index.php"><img src="img/nav/alert-icon.png"></a></p>
    </div>
    <div>
        <p class="homeTitle">Fluido</p>
        <p class="img"><a href="fluido/index.php"><img src="img/nav/bouteille.png"></a></p>
    </div>
</div>


<script>

    $("img").mousedown(function(){
        return false;
    });

    // lancement de recherche d'alert

    $.getJSON( '<?php echo URL_ROOT.'alert/proc/check_alert.php';?>', function( json ) {
        //$( ".result" ).html( data );
        var countAlert=json.countAlert;
        $('#alertTitle').text('Alerte : '+countAlert);
            if(countAlert>0){
                $('#alert').addClass('anim-alert');
            }

       // alert(JSON.stringify(json));

    });



</script>
<? include (FOOTER);?>