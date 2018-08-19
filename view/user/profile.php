<?php $pageTitle = "Site CFDT INTERCO77 - ".$user->login(); $wrapper = 'class="content"'; ?>

<section class="content">

	<h2 class="sectionTitle container"><?= $user->login() ?></h2>

	<div class="centerText">
		<?= $this->displayNewMessageButton() ?>
	</div>
	
	<div class="container">
		<?= $this->displayEditProfileButton($user) ?>
		<?= $this->displaySettingProfileButton($user) ?>
		<?= $this->displayMessageButton($user) ?>
	</div>

	<div class="container">
		<p>Date d'inscription : <?= $user->suscribeDate() ?></p>
		<?php if(($user->seeEmail() <= $_SESSION['rank'] AND $user->seeEmail() != 0) OR $user->id() === $_SESSION['id']) :?>
			<p>Email : <?= $user->email() ?></p>
		<?php endif ?>
		<?php if(($user->seePhoneNumber() <= $_SESSION['rank'] AND $user->seePhoneNumber() != 0) OR $user->id() === $_SESSION['id']) :?>
			<p>Téléphone : <?= ($user->phoneNumber()) ? $user->phoneNumber() : 'Non renseigné' ?></p>
		<?php endif ?>
		<?php if(($user->seeName() <= $_SESSION['rank'] AND $user->seeName() != 0) OR $user->id() === $_SESSION['id']) :?>
			<p>Prénom : <?= ($user->name()) ? $user->name() : 'Non renseigné' ?></p>
		<?php endif ?>
		<?php if(($user->seeLastName() <= $_SESSION['rank'] AND $user->seeLastName() != 0) OR $user->id() === $_SESSION['id']) :?>
			<p>Nom : <?= ($user->lastname()) ? $user->lastname() : 'Non renseigné' ?></p>
		<?php endif ?>
		<p>Role : <?= $user->role() ?></p>
	</div>
	
</section>