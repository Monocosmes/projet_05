<?php $pageTitle = "Message Privé"; $wrapper = 'class="container"'; ?>

<section class="container">

	<h2 class="sectionTitle">Message Privé</h2>

	<form method="post" action="<?= HOST.'addNewMessage' ?>" class="paddingRule shapeForm">
        <legend>Nouveau Message</legend>

        <div class="form-group">
	        <label for="authorId">Auteur</label>
            <input class="form-control" type="hidden" name="authorId" id="authorId" value="<?= htmlspecialchars($_SESSION['id']) ?>">
            <input class="form-control" type="text" value="<?= htmlspecialchars($_SESSION['login']) ?>" disabled="true">
		</div>
		<div class="form-group">
			<label for="nickname">Destinataire</label>
			<input class="form-control" type="text" name="addressee" id="nickname" required="true" placeholder="Nom du destinataire" value="<?= (isset($_SESSION['addressee'])) ? $_SESSION['addressee'] : '' ?>">
		</div>
		<div id="loginList" class="borders paddingRule"></div>

		<div class="form-group">
            <label for="title">Titre</label>
            <input class="form-control" type="text" name="title" id="title" required="true" placeholder="Titre du message" value="<?= (isset($_SESSION['title'])) ? htmlspecialchars($_SESSION['title']) : ''?>">
		</div>
		<div class="form-group">
            <label for="content">Message</label>
            <textarea name="content" id="content" rows="20" class="form-control" placeholder="Votre message ici..." required="true"><?= (isset($_SESSION['content'])) ? htmlspecialchars($_SESSION['content']) : '' ?></textarea>
		</div>

		<button class="button" type="submit">Envoyer</button>
	</form>
</section>