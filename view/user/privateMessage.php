<?php $pageTitle = $privateMessage->title();  $wrapper = 'class="container"'; ?>

<section class="paddingRule container">

	<h2 class="sectionTitle"><?= $privateMessage->title() ?></h2>

    <div class="d-flex justify-content-center">
        <?= $this->displayLeaveConversationButton($privateMessage, 'button') ?>
    </div>

	<p>Expéditeur : <a href="<?= HOST.'profile/userId/'.$privateMessage->authorId() ?>"><?= $privateMessage->authorName() ?></a> - Destinataire : <a href="<?= HOST.'profile/userId/'.$privateMessage->receiverId() ?>"><?= $privateMessage->receiverName() ?></a></p>
	<div>
		<?php if($answers) :?>
            <?php foreach($answers AS $answer) :?>
                <div class="col-12 borders paddingRule marginRule <?= ($_SESSION['id'] === $answer->authorId()) ? 'addPadding' : '' ?>" id="messageId-<?= $answer->id() ?>">
                    <div class="buttons">
                        <?= $this->displayEditMessageButton($answer) ?>
                    </div>
                    <?= $this->displayDeleteMessageButton($answer) ?>

			        <p>
                        Envoyé le : <span title="Le <?= $answer->formatDateAndHour($answer->creationDate()) ?>"><?= $answer->formatDate($answer->creationDate()) ?></span> par <a href="<?= HOST.'profile/userId/'.$privateMessage->authorId() ?>"><?= $answer->authorName() ?></a>
                    </p>

			        <div class="article paddingRule"><?= nl2br(htmlspecialchars($answer->content())) ?></div>
                </div>
		    <?php endforeach ?>
        <?php endif ?>
	</div>
</section>

<section class="paddingRule container">    
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