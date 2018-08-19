<?php $pageTitle = "Messagerie Privée"; $wrapper = 'class="container"'; ?>

<section class="content">

	<h2 class="sectionTitle">Messagerie Privée</h2>

	<div class="centerText">
		<?= $this->displayNewMessageButton() ?>
	</div>

	<div>
		<?php if($messages) :?>
			<?php foreach($messages AS $message) :?>
				<p>Conversation débutée le : <?= $message->creationDateFr()?> par <a href="<?= HOST.'profile/userId/'.$message->authorId() ?>"><?= $message->authorName() ?></a></p>
				<?php if(!$message->isRead() AND $message->receiverIdView() == $_SESSION['id']) :?>
					<p>Nouveau</p>
				<?php endif ?>
				<p><a href="<?= HOST.'privateMessage/pmId/'.$message->id() ?>"><?= $message->title() ?></a></p>
			<?php endforeach ?>
		<?php else :?>
			<p>Vous n'avez aucun message privé actuellement</p>
		<?php endif ?>
	</div>
</section>