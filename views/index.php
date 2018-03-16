<?php

include('includes/header.php');

//foreach($accounts as $account){
?>


  <h1>Connexion</h1>

	<?php
	// Si il y a une erreur dans le formulaire
	if(isset($error_message)){
		echo '<p class="error-message">' . $error_message . '</p>';
	}
	?>

	<div class="connexion">

    <form class="flex" action="../controllers/index.php" method="post">

      <input placeholder="E-mail" name="mail" type="email" value="<?php if(isset($_SESSION['mail'])){ echo $_SESSION['mail'] ;}?>" autofocus required>
      <input placeholder="Password" name="password" type="password" required>
			<!-- <input type="hidden" name="token" value="<?php echo $token; ?>"> -->
			<input type="hidden" name="verif" value="">
      <input type="submit" name="connection" value="Me connecter">

    </form>
		<p><a href="../controllers/registration.php">Vous n'avez pas encore de compte? <br>Inscrivez-vous !</a></p>
	</div>

<?php

include('includes/footer.php');

?>
