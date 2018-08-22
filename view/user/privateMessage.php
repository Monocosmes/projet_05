<?php $pageTitle = $privateMessage->title();  $wrapper = 'class="content"'; ?>

<section class="paddingRule content">

	<h2 class="sectionTitle"><?= $privateMessage->title() ?></h2>

	<p>Expéditeur : <a href="<?= HOST.'profile/userId/'.$privateMessage->authorId() ?>"><?= $privateMessage->authorName() ?></a> - Destinataire : <a href="<?= HOST.'profile/userId/'.$privateMessage->receiverId() ?>"><?= $privateMessage->receiverName() ?></a></p>
	<div>
		<?php foreach($answers AS $answer) :?>
			<p>Envoyé le : <?= $answer->creationDateFr()?> par <a href="<?= HOST.'profile/userId/'.$privateMessage->authorId() ?>"><?= $answer->authorName() ?></a></p>
			<p><?= htmlspecialchars($answer->content()) ?></p>
		<?php endforeach ?>		
	</div>
</section>

<section class="paddingRule content">    
    <form method="post" action="<?= HOST.'answerPrivateMessage/pmId/'.$privateMessage->id() ?>" class="paddingRule shapeForm">
        <legend>Répondre</legend>
        <div class="form-group">
            <label>Réponse</label>
            <input class="form-control" type="hidden" name="addresseeId" value="<?= ($privateMessage->authorId() == $_SESSION['id']) ? $privateMessage->receiverId() : $privateMessage->authorId() ?>">
            <input class="form-control" type="hidden" name="authorId" value="<?= $_SESSION['id'] ?>">
            <textarea name="content" rows="5" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <input class="button" type="submit" value="Répondre">
        </div>
    </form>
</section>