<?php $pageTitle = "Site CFDT INTERCO77 - Contactez-nous !"; $wrapper = 'class="content"'; ?>

<section class="content">
	<h2 class="sectionTitle">l'équipe du bureau</h2>

	<?php if(isset($users)) :?>

		<div class="d-flex justify-content-between flex-wrap">

		<?php foreach($users AS $user) :?>
			<div class="col-xl-4 col-md-6 col-sm-12 memberBlock borders paddingRule d-flex justify-content-between">
				<div>
					<h3><?= htmlspecialchars($user->lastname()).'&nbsp'.htmlspecialchars($user->name()) ?></h3>
	
					<?php if(($user->seeName() <= $_SESSION['rank'] AND $user->seeName() != 0) OR $user->id() === $_SESSION['id']) :?>
						<p>Prénom : <?= ($user->name()) ? htmlspecialchars($user->name()) : 'Non renseigné' ?></p>
					<?php endif ?>
					<?php if(($user->seeLastName() <= $_SESSION['rank'] AND $user->seeLastName() != 0) OR $user->id() === $_SESSION['id']) :?>
						<p>Nom : <?= ($user->lastname()) ? htmlspecialchars($user->lastname()) : 'Non renseigné' ?></p>
					<?php endif ?>
					
					<p>Identifiant : <a href="<?= HOST.'profile/userId/'.htmlspecialchars($user->id()) ?>"><?= htmlspecialchars($user->login()) ?></a></p>

					<?php if(($user->seeEmail() <= $_SESSION['rank'] AND $user->seeEmail() != 0) OR $user->id() === $_SESSION['id']) :?>
						<p>Email : <?= htmlspecialchars($user->email()) ?></p>
					<?php endif ?>
					<?php if(($user->seePhoneNumber() <= $_SESSION['rank'] AND $user->seePhoneNumber() != 0) OR $user->id() === $_SESSION['id']) :?>
						<p>Téléphone : <?= ($user->phoneNumber()) ? htmlspecialchars($user->phoneNumber()) : 'Non renseigné' ?></p>
					<?php endif ?>
				</div>
				<div class="avatar">
					<a title="<?= htmlspecialchars($user->login()) ?>" href="<?= HOST.'profile/userId/'.htmlspecialchars($user->id()) ?>"><img src="<?= ASSETS.'images/avatars/'.$user->avatar().'.jpg' ?>"></a>
				</div>
			</div>
		<?php endforeach ?>
				
			</div>
	<?php else :?>
		<p class="centerText">Nous sommes désolés mais aucun membre du bureau n'a encore partagé ses informations de contact.</p>
	<?php endif ?>
</section>