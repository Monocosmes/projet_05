<?php $pageTitle = "Messagerie Privée"; $wrapper = 'class="container"'; ?>

<section class="container">

	<h2 class="sectionTitle">Messagerie Privée</h2>

	<div class="text-center">
		<?= $this->displayNewMessageButton() ?>
	</div>
	
	<?php if(count($messages) > 0) :?>

		<?php foreach($messages AS $index => $message) :?>

			<div class="paddingRule marginRule borders <?= (!$message->isRead() AND $message->receiverIdView() == $_SESSION['id']) ? 'notPublished' : '' ?>">
				<?= $this->displayLeaveConversationButton($message, 'deleteButton') ?>

				<p class="col-11">
					Débutée le : <span title="Le <?= $lastPMs[$index]->formatDateAndHour($lastPMs[$index]->creationDate()) ?>"><?= $message->formatDate($message->creationDate())?></span> par
					<a href="<?= HOST.'profile/userId/'.$message->authorId() ?>">
						<?= $message->authorName() ?>
					</a>
					<?= (!$message->isRead() AND $message->receiverIdView() == $_SESSION['id']) ? ' - <span class="textRed">Nouveau</span>' : '' ?>
					<?= (($message->authorId() != $_SESSION['id'] AND !$message->authorIsOn()) OR ($message->receiverId() != $_SESSION['id'] AND !$message->receiverIsOn())) ? ' - <span class="textRed">Votre interlocuteur a quitté la conversation</span>' : '' ?>
				</p>
					
				<p><a href="<?= HOST.'privateMessage/pmId/'.$message->id() ?>"><?= $message->title() ?></a></p>
				<?php if(!empty($lastPMs[$index])) :?>
					<p class="">Dernier message par <a href="<?= HOST.'profile/userId/'.$lastPMs[$index]->authorId() ?>"><?= $lastPMs[$index]->authorName() ?></a> le <span title="Le <?= $lastPMs[$index]->formatDateAndHour($lastPMs[$index]->creationDate()) ?>"><?= $lastPMs[$index]->formatDate($lastPMs[$index]->creationDate()) ?></span></p>
				<?php endif ?>
			</div>

		<?php endforeach ?>
	<?php else :?>
		<p class="text-center marginRule">Vous n'avez aucun message privé actuellement</p>
	<?php endif ?>
	
</section>