<?php $pageTitle = "Site CFDT INTERCO77 - Contactez-nous !"; $wrapper = 'class="container"'; ?>

<section class="container">
	
	<h2 class="sectionTitle">l'équipe du bureau</h2>

	<?php if(isset($users)) :?>

		<div class="d-flex justify-content-between flex-wrap">

		<?php foreach($users AS $user) :?>
			<div class="col-xl-4 col-md-6 col-sm-12 memberBlock borders">
				<h3 class="text-center marginRule"><a href="<?= HOST.'profile/userId/'.$user->id() ?>"><?= htmlspecialchars($user->lastname()).'&nbsp;'.htmlspecialchars($user->name()) ?></a></h3>
				<div class="d-flex justify-content-between paddingRule">
					<div class="dataUser">
						<p>Identifiant : <a href="<?= HOST.'profile/userId/'.htmlspecialchars($user->id()) ?>"><?= htmlspecialchars($user->login()) ?></a></p>
	
						<?php if(($user->seeEmail() <= $_SESSION['rank'] AND $user->seeEmail() != 0) OR $user->id() === $_SESSION['id']) :?>
							<p>Email : <?= htmlspecialchars($user->email()) ?></p>
						<?php endif ?>
						<?php if(($user->seePhoneNumber() <= $_SESSION['rank'] AND $user->seePhoneNumber() != 0) OR $user->id() === $_SESSION['id']) :?>
							<p>Téléphone : <?= ($user->phoneNumber()) ? htmlspecialchars($user->phoneNumber()) : 'Non renseigné' ?></p>
						<?php endif ?>
					</div>
					<div class="avatar marginRule">
						<a title="<?= htmlspecialchars($user->login()) ?>" href="<?= HOST.'profile/userId/'.htmlspecialchars($user->id()) ?>"><img src="<?= ASSETS.'images/avatars/'.$user->avatar() ?>" alt="avatar de <?= $user->login() ?>" ></a>
					</div>
				</div>
			</div>
		<?php endforeach ?>
				
			</div>
	<?php else :?>
		<p class="text-center marginRule">Nous sommes désolés mais aucun membre du bureau n'a encore partagé ses informations de contact.</p>
	<?php endif ?>
</section>