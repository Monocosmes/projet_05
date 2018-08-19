<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="container"'; ?>

<section class="container">

	<h2 class="sectionTitle">Connexion</h2>

	<div class="col-md-4 center">
		<form method="post" action="<?= HOST.'signin' ?>" class="paddingRule" id="shapeForm">
			<div class="form-group">
				<label>Login / Email</label>
				<input type="text" name="login" class="form-control" value="<?= (isset($_SESSION['yourLogin']))?$_SESSION['yourLogin']:''; ?>">
			</div>
			<div class="form-group">
				<label>Mot de passe</label>
				<input type="password" name="password" class="form-control">
			</div>
			
			<input class="button" type="submit" value="Se connecter">
			
		</form>
	</div>
</section>
