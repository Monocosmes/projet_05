<?php $pageTitle = "Site CFDT INTERCO77 - ".$user->login(); $wrapper = 'class="container"'; ?>

<section class="container">

	<h2 class="sectionTitle"><?= $user->login() ?> <?= ($user->accountLocked()) ? ' - <span class="textRed">Compte bloqué</span>' :'' ?></h2>

	<div class="text-center">
		<?= $this->displayNewMessageButton() ?>
	</div>

	<?php if($user->id() === $_SESSION['id']) :?>
		<div id="avatarUpload" class="marginRule p-4 text-center">
			<h3 class="uppercase">Modifier votre avatar</h3>
			<p>Glissez / Déposez votre image ici</p>
			<div id="clickUpload" class="button mb-4">
				<span>Cliquez pour changer votre avatar</span>
				<input type="file" name="file" id="file">
			</div>
			<p>Taille max 500ko et 500 x 750 pixels</p>			
		</div>
	<?php endif ?>

	<div>	
		<div class="row justify-content-between">
			<div class=" d-flex justify-content-between borders paddingRule marginRule <?= ($user->id() === $_SESSION['id'] AND (is_null($user->matricule()) OR is_null($user->phoneNumber()) OR is_null($user->lastname()) OR is_null($user->name()))) ? 'col-lg-6' : 'col-lg-12' ?>  col-md-12">
				<div>
					<p>Date d'inscription : <?= $user->formatDate($user->suscribeDate()) ?></p>
					<p>Dernière connexion : <?= (!is_null($user->lastLogin())) ? '<span title="Le '.$user->formatDateAndHour($user->lastLogin()).'">'.$user->formatDate($user->lastLogin()).'</span>' : 'Jamais' ?></p>
					<?php if(($user->seeEmail() <= $_SESSION['rank'] AND $user->seeEmail() != 0) OR $user->id() === $_SESSION['id']) :?>
						<p>Email : <?= htmlspecialchars($user->email()) ?></p>
					<?php endif ?>
					<?php if(($user->seePhoneNumber() <= $_SESSION['rank'] AND $user->seePhoneNumber() != 0) OR $user->id() === $_SESSION['id']) :?>
						<p>Téléphone : <?= ($user->phoneNumber()) ? htmlspecialchars($user->phoneNumber()) : 'Non renseigné' ?></p>
					<?php endif ?>
					<?php if(($user->seeName() <= $_SESSION['rank'] AND $user->seeName() != 0) OR $user->id() === $_SESSION['id']) :?>
						<p>Prénom : <?= ($user->name()) ? htmlspecialchars($user->name()) : 'Non renseigné' ?></p>
					<?php endif ?>
					<?php if(($user->seeLastName() <= $_SESSION['rank'] AND $user->seeLastName() != 0) OR $user->id() === $_SESSION['id']) :?>
						<p>Nom : <?= ($user->lastname()) ? htmlspecialchars($user->lastname()) : 'Non renseigné' ?></p>
					<?php endif ?>
					<p>Rôle : <?= $user->role() ?></p>
					<p>Travaille à la commune : <?= ($user->employee()) ? 'Oui' : 'Non'; ?></p>
				</div>
				<div>
					<div class="avatar marginRule" id="<?= $user->id() ?>">
						<img id="avatar" src="<?= ASSETS.'images/avatars/'.$user->avatar() ?>" alt="avatar de <?= $user->login() ?>" >
					</div>
				</div>
			</div>
		
			<?php if($user->id() === $_SESSION['id'] AND (is_null($user->matricule()) OR is_null($user->phoneNumber()) OR is_null($user->lastname()) OR is_null($user->name()) OR $user->rank() < 3)) :?>
				<form class="shapeForm paddingRule marginRule col-lg-6 col-md-12" method="post" action="<?= HOST.'updateProfile' ?>">
					<legend>Complétez votre profil</legend>
					<input type="hidden" name="id" value="<?= $user->id() ?>" >
					<input type="hidden" class="form-control" name="email" value="<?= $user->email() ?>" />
					<input type="hidden" class="form-control" name="login" value="<?= $user->login() ?>" />
					<input type="hidden" name="employee" value="<?= ($user->employee()) ?>" />

					<?php if(is_null($user->name())) :?>
						<div id="name" class="form-group">
    	            		<label for="name">Prénom</label>
    	            		<input type="text" class="form-control" name="name" />
    	        		</div>
    	        	<?php else :?>
    	        		<input type="hidden" class="form-control" name="name" value="<?= $user->name() ?>" />
					<?php endif ?>
					<?php if(is_null($user->lastname())) :?>
						<div id="lastname" class="form-group">
    	        		    <label for="lastname">Nom</label>
    	        		    <input type="text" class="form-control" name="lastname" />
    	        		</div>
    	        	<?php else :?>
    	        		<input type="hidden" class="form-control" name="lastname" value="<?= $user->lastname() ?>" />
					<?php endif ?>
					<?php if(is_null($user->phoneNumber())) :?>
						<div class="form-group">
    	       		     	<label for="phoneNumber">Téléphone</label>
    	       		     	<input type="text" class="form-control" name="phoneNumber" placeholder="Sous la forme suivante : 0160606789" />
    	       		 	</div>
    	       		 <?php else :?>
    	        		<input type="hidden" class="form-control" name="phoneNumber" value="<?= $user->phoneNumber() ?>" />
					<?php endif ?>
					<?php if(is_null($user->matricule())) :?>
						<div class="form-group">
    	       		     	<label for="matricule">Matricule</label>
    	       		     	<input type="text" class="form-control" name="matricule" />
    	       		 	</div>
    	       		 <?php else :?>
    	        		<input type="hidden" class="form-control" name="matricule" value="<?= $user->matricule() ?>" />
					<?php endif ?>
					<?php if($user->rank() === 2) :?>
						<div class="form-group">
    	       		     	<label for="askVerification">
    	       		     		<input type="checkbox" name="askVerification" id="askVerification" <?= ($user->askVerification()) ? 'checked' : '' ?> />
    	       		     		Demander à passer en <a href="<?= HOST.'roles.html#employeeMember' ?>">Membre Validé</a><?= ($user->askVerification()) ? ' - demande en cours' : '' ?>
    	       		     	</label>
    	       		 	</div>
					<?php endif ?>					
					<input class="button" type="submit" value="Envoyer" />					
				</form>
			<?php endif ?>
		</div>
		<div>
			<?= $this->displayEditProfileButton($user) ?>
			<?= $this->displaySettingProfileButton($user) ?>
			<?= $this->displayMessageButton($user) ?>
			<?= $this->displayDeleteAccountButton($user) ?>
			<?= $this->displayLockAccountButton($user) ?>
		</div>
	</div>
</section>