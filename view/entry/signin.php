<?php $pageTitle = "Site CFDT INTERCO77"; ?>

<section class="container">
	<div class="row col-md-4" id="shapeForm">
		<form method="post" action="<?= HOST.'signin' ?>" class="col-md-12 padding_rule">
			<div class="form-group">
				<label>Login / Email</label>
				<input type="text" name="login" class="form-control" value="<?= (isset($_SESSION['yourLogin']))?$_SESSION['yourLogin']:''; ?>">
			</div>
			<div class="form-group">
				<label>Mot de passe</label>
				<input type="password" name="password" class="form-control">
			</div>
			<div class="form-group">
				<input class="float-md-right buttons" type="submit" value="Se connecter">
			</div>
		</form>
	</div>
</section>
