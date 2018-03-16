<?php

include('includes/header.php');

//foreach($accounts as $account){
?>

<h1>Inscription</h1>

<?php
// Si il y a une erreur dans le formulaire
if(isset($error_message)){
	echo '<p class="error-message">' . $error_message . '</p>';
}
?>

<div class="connexion">

	<form class="flex" action="../controllers/registration.php" method="post">
		<input type="text" name="mail" placeholder="Mon E-mail" required autofocus>
		<input type="text" name="name" placeholder="Mon Prénom" required>
		<input type="password" name="password" placeholder="Mon mot de passe" required>
		<input type="password" name="confirmation" placeholder="Confirmation du mot de passe" required>
		<input type="hidden" name="verif" value="">
		<input type="submit" name="connection" value="Créer mon compte">
	</form>

	<p><a href="../controllers/index.php">Vous êtes déjà inscrit? Connectez-vous !</a></p>
</div>


<?php

include('includes/footer.php');

?>
