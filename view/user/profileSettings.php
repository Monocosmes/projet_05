<?php $pageTitle = "Site CFDT INTERCO77 - ".$user->login(); $wrapper = 'class="container"'; ?>

<section class="container">

	<h2 class="sectionTitle">Réglage du profil</h2>

	<div class="centerText">
		<?= $this->displayNewMessageButton() ?>
	</div>	
	
	<p>Choisissez qui peut voir vos informations :</p>

	<form class="paddingRule shapeForm" method="post" action="<?= HOST.'saveSettings/userId/'.$user->id() ?>">
		<p id="seeEmail" class="form-group">
			<label for="seeEmail"><span class="uppercase">Email :</span> <?= $user->email() ?></label> <br>
			<?php for($i = 0; $i < 6; $i++) :?>
				<input type="radio" name="seeEmail" value="<?= $i ?>" <?= ($user->seeEmail() === $i) ? 'checked="true" id="seeEmailValue"' : '' ?>>
			<?php endfor ?>
			<br>
			<span id="seeEmailText"></span>
		</p>

		<div class="separator"></div>

		<p id="seePhoneNumber" class="form-group">
			<label for="seePhoneNumber"><span class="uppercase">Numéro de Téléphone :</span> <?= $user->phoneNumber() ?></label> <br>
			<?php for($i = 0; $i < 6; $i++) :?>
				<input type="radio" name="seePhoneNumber" value="<?= $i ?>" <?= ($user->seePhoneNumber() === $i) ? 'checked="true" id="seePhoneNumberValue"' : '' ?>>
			<?php endfor ?>
			<br>
			<span id="seePhoneNumberText"></span>
		</p>

		<div class="separator"></div>

		<p id="seeName" class="form-group">
			<label for="seeName"><span class="uppercase">Prénom :</span> <?= $user->name() ?></label> <br>
			<?php for($i = 0; $i < 6; $i++) :?>
				<input type="radio" name="seeName" value="<?= $i ?>" <?= ($user->seeName() === $i) ? 'checked="true" id="seeNameValue"' : '' ?>>
			<?php endfor ?>
			<br>
			<span id="seeNameText"></span>
		</p>

		<div class="separator"></div>

		<p id="seeLastName" class="form-group">
			<label for="seeLastName"><span class="uppercase">Nom :</span> <?= $user->lastname() ?></label> <br>
			<?php for($i = 0; $i < 6; $i++) :?>
				<input type="radio" name="seeLastName" value="<?= $i ?>" <?= ($user->seeLastName() === $i) ? 'checked="true" id="seeLastNameValue"' : '' ?>>
			<?php endfor ?>
			<br>
			<span id="seeLastNameText"></span>
		</p>

		<?php if($_SESSION['rank'] > 3) :?>

			<div class="separator"></div>

			<p class="form-group">
				<label for="contactInfo">
					<input type="checkbox" name="contactInfo" id="contactInfo" <?= ($user->onContact() === 1) ? 'checked="true"' :'' ?>>
					Je souhaite apparaitre sur la page de contact
				</label>
			</p>

		<?php endif ?>

		<input class="button" type="submit" value="Sauvegarder">
		<?= $this->displayCancelButton($user) ?>
	</form>
	
</section>