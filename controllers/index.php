<?php
session_start();
// if (empty($_SESSION['token'])) {
//     $_SESSION['token'] = bin2hex(random_bytes(32));
// }
// $token = $_SESSION['token'];

// Chargement automatique des classes
require('../services/Autoloader.php');
Autoloader::autoload();

// On instancie notre manager
$userManager = new UserManager();

// Si un formulaire est soumis
if($_POST){

	// if (!empty($_POST['token']) && empty($_POST['verif'])) {
	//
	//     if (hash_equals($_SESSION['token'], $_POST['token'])) {

					 // Si tous les champs sont remplis
					 if((isset($_POST['mail']) && !empty($_POST['mail'])) && (isset($_POST['password']) && !empty($_POST['password']))){
							 // On sécurise les infos envoyées
							 $mail = htmlspecialchars($_POST['mail']);
							 $password = htmlspecialchars($_POST['password']);

							 // On instancie l'objet $user avec les infos envoyées
							 $user = new User([
								 'mail' => $mail,
								 'password' => $password
							 ]);
					 }

					 // On vérifie si l'adresse mail existe en BDD
					 if($userManager->checkIfExist($user) == 0){
						 	$error_message = "L'adresse e-mail et/ou le mot de passe ne correspondent pas.";
					 } else {
							 // Si le password envoyé ne correspond pas au password en BDD
							if($userManager->checkPassword($user) == false){
							 		$error_message = "L'adresse e-mail et/ou le mot de passe ne correspondent pas.";
						 	}
						  // Si toutes les infos sont bonnes
						  else {
									 // On instancie un objet avec les infos en BDD
									 $user = $userManager->getUser($user);
									 // On déclare les variables de session ID et NAME
									 $_SESSION['id'] = $user->getId();
									 $_SESSION['name'] = $user->getName();
									 // On redirige vers la page des comptes
									 header('location: account.php');
						 }

					 }

	//     }
	// 		else
	// 		{
	//          $error_message = "erreur !";
	//     }
	// }

	else
	{
		$error_message = "erreur !";
	}


}

// On affiche la vue
include('../views/index.php');
