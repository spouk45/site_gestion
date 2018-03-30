<?php 
include('../../config.php');
header(CHARSET);

if(!isset($_POST['user_name']) || !isset($_POST['user_password']))
{
	echo 'Une erreur s\'est produite. Veuillez recommencer.';
	exit();
}

$data['name']=$_POST['user_name'];
$data['pass']=$_POST['user_password'];
//$data['connect']='connect';

include(DIR_ROOT.'register/class/Account.php');

try{
//$Account=new Account($data);
include(CONNECT);
$AccountManager=new AccountManager($db);
$userId=$AccountManager->checkConnect($data);
	// on récupère les droits
	//$level=$AccountManager->getLevel($userId);
//$Account->setUserId($userId);
}
catch(Exception $e){
	//echo $e->getMessage();
	$reponse='Login ou mot de passe incorrect.';
	echo json_encode(['reponse' => $reponse ]);
	exit();
	}
$reponse = 'ok';
 echo json_encode(['reponse' => $reponse ]);

session_start();
$_SESSION['user']['id']=$userId;
$_SESSION['user']['name']=$data['name'];
//$_SESSION['level']=$level;

