<?php
session_start();
// if (empty($_SESSION['token'])) {
//     $_SESSION['token'] = bin2hex(random_bytes(32));
// }
// $token = $_SESSION['token'];

// Chargement automatique des classes
require('../services/Autoloader.php');
Autoloader::autoload();

// Si la variable $_SESSION['id'] n'existe pas, nous ne sommes pas connectés, on redirige automatiquement vers la page de connexion
if(!isset($_SESSION['id'])){
	header('location: index.php');
}

// On instancie notre manager
$manager = new AccountManager();

// Si un formulaire a été envoyé
if($_POST){

	// if(empty($_POST['verif']) && !empty($_POST['token'])){
	//
	// 	if (hash_equals($_SESSION['token'], $_POST['token'])) {
			// Si le formulaire de déconnexion est soumis, on détruit les variables de session et on redirige vers la page de connexion
			if(isset($_POST['logout'])){
				session_destroy();
				header('Location: index.php');
			}

			// Si le formulaire de création de compte est soumis
			if(isset($_POST['new']) && !empty($_POST['new'])){

				// Si le champ name est bien rempli, et n'est pas vide
				if(isset($_POST['name']) && !empty($_POST['name'])){

					$name = htmlspecialchars($_POST['name']);

					// Si le nom envoyé correspond aux noms autorisés dans la classe Account
					if (in_array($name, Account::ACCOUNT)){

						// On instancie un objet $account
						$account = new Account([
							'name' => $name,
							'userID' => $_SESSION['id']
						]);

						// On ajoute l'instance à la base de données
						$manager->add($account);

						// Si le nom ne correspond pas aux noms autorisés dans la classe, on déclare un message d'erreur
					} else {
						$error_message = "Le type de compte n'est pas valide";
					}

					// Si le champ name est vide ou n'existe pas, on déclare un message d'erreur
				} else {
					$error_message = "Veuillez renseigner le champ";
				}

			}

			// Si c'est le formulaire pour ajouter ou retirer de l'argent qui est soumis
			elseif((isset($_POST['debit']) && !empty($_POST['debit'])) || (isset($_POST['payment']) && !empty($_POST['payment']))){

				// On récupère l'ID du compte et on le convertit en integer
				$id = (int) $_POST['id'];
				// On récupère la somme envoyée et on le convertir en integer
				$balance = (int) $_POST['balance'];

				// On crée une instance $account en fonction de l'ID
				$account = $manager->getAccount($id);

				// Si on clique sur retirer
				if(isset($_POST['debit'])){
					// On retire de "l'argent"
					$account->debit($balance);
				}
				// Sinon on ajoute
				else {
					$account->payment($balance);
				}

				// On met à jour notre base de données avec la nouvelle valeur de l'attribut $balance
				$manager->update($account);
			}

			// Si c'est le formulaire de transert qui est soumis
			elseif(isset($_POST['transfer']) && !empty($_POST['transfer'])){

				$idDebit = (int) $_POST['idDebit'];
				$idPayment = (int) $_POST['idPayment'];
				$balance = (int) $_POST['balance'];

				// On instancie l'objet compte à créditer, et celui à débiter
				$account1 = $manager->getAccount($idDebit);
				$account2 = $manager->getAccount($idPayment);

				// La méthode tranfer permet d'effectuer le virement
				$account1->transfer($account2, $balance);

				// On met à jour nos deux comptes en base de données
				$manager->update($account1);
				$manager->update($account2);
			}

			// Si c'est le formulaire de suppression qui est soumis
			elseif(isset($_POST['delete']) && !empty($_POST['delete'])){
				$id = (int) $_POST['id'];

				// On instancie un objet $account en fonction de l'ID
				$account = $manager->getAccount($id);
				// On le supprime en BDD
				$manager->delete($account);
			}

	// 	}
	// 	else
	// 	{
	// 		$error_message = 'erreur';
	// 	}
	//
	// }
	else
	{
		session_destroy();
		header('Location: index.php');

	}

}

// La variable $accountAvailabled nous sert à lister les comptes possibles à créer
$accountAvailabled = Account::ACCOUNT;

// On récupère tous les comptes dans la BDD
$accounts = $manager->getAll($_SESSION['id']);

// La variable $nbAccounts nous sert à savoir combien il y a de comptes en BDD pour afficher ou non le formulaire de tranfert
$nbAccounts = count($accounts);


// Enfin, on inclut la vue
include "../views/accounts.php";
