<?php

include('includes/header.php');

?>

<div class="container">

	<header class="flex">
		<p class="margin-right">Bonjour <?php echo $_SESSION['name'] ;?></p>

		<form action="../controllers/account.php" method="post">
			<input type="hidden" name="token" value="<?php echo $token; ?>">
			<input type="hidden" name="verif" value="">
			<input type="submit" name="logout" value="Déconnexion">
		</form>
	</header>


	<?php
		if(isset($error_message)){
	?>
		<p class="error-message"> <?php echo $error_message; ?></p>
	<?php
		}
	?>

	<h1>Mon application bancaire</h1>

	<form class="newAccount" action="../controllers/account.php" method="post">
		<select class="" name="name" required>
			<option value="" disabled>Choisissez le type de compte à ouvrir</option>
			<?php foreach ($accountAvailabled as $key => $value) { ?>
				<option value="<?php echo $value ;?>"><?php echo $value ;?></option>
			<?php } ?>
		</select>
		<input type="hidden" name="token" value="<?php echo $token; ?>">
		<input type="hidden" name="verif" value="">
		<input type="submit" name="new" value="Ouvrir un nouveau compte">
	</form>

	<hr>

	<div class="main-content flex">

	<?php
	foreach ($accounts as $account) {
	?>

		<div class="card-container">

			<div class="card">
				<h3><strong><?php echo $account->getName(); ?></strong></h3>
				<div class="card-content">


					<p class="<?php echo $account->checkState();?>">Somme disponible : <?php echo $account->getBalance(); ?> €</p>

					<h4>Dépot / Retrait</h4>
					<form action="../controllers/account.php" method="post">
						<input type="hidden" name="id" value="<?php echo $account->getId(); ?>"  required>
						<input type="hidden" name="token" value="<?php echo $token; ?>">
						<input type="hidden" name="verif" value="">
						<input type="number" name="balance" placeholder="Entrer une somme à débiter/créditer" required>
						<input type="submit" name="payment" value="Créditer">
						<input type="submit" name="debit" value="Débiter">
					</form>


					<?php
						if($nbAccounts > 1){
					?>

			 		<form action="../controllers/account.php" method="post">

						<h4>Transfert</h4>
						<input type="number" name="balance" placeholder="somme à transférer"  required>
						<input type="hidden" name="idDebit" placeholder="Compte à débiter" value="<?php echo $account->getId(); ?>" required>
						<select name="idPayment" required>
							<option value="" disabled>Choisir un compte</option>
							<?php
								$idAccount = $account->getId();
								foreach ($accounts as $accountSelect) {
									if($idAccount != $accountSelect->getId()){
							?>
							<option value="<?php echo $accountSelect->getId(); ?>" ><?php echo $accountSelect->getName(); ?></option>
							<?php
									}
								}
					 		?>
						</select>
						<input type="hidden" name="token" value="<?php echo $token; ?>">
						<input type="hidden" name="verif" value="">
						<input type="submit" name="transfer" value="Transférer l'argent">
					</form>

					<?php
						}
			 		?>

			 		<form class="delete" action="../controllers/account.php" method="post">
						<input type="hidden" name="token" value="<?php echo $token; ?>">
						<input type="hidden" name="verif" value="">
				 		<input type="hidden" name="id" value="<?php echo $account->getId(); ?>"  required>
				 		<input type="submit" name="delete" value="Supprimer le compte">
			 		</form>

				</div>
			</div>
		</div>

		<?php
			}
		?>
	</div>

</div>

<?php

include('includes/footer.php');

 ?>
