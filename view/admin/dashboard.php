<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="container"'; ?>

<section class="container">

   	<h2 class="sectionTitle">Tableau de bord</h2>

  	<div class="d-flex justify-content-between flex-wrap">
  		<section class="col-lg-6 col-sm-12 dashboards borders paddingRule">

  			<h3 class="sectionTitle">Gestion des articles</h3>

  			<p><a href="<?= HOST.'newArticle.html' ?>">Rédiger un nouvel article</a></p>
    		<p><a href="<?= HOST.'newTestimony.html' ?>">Rédiger un nouveau témoignage</a></p>
            <p><a href="<?= HOST.'newsNotPublished.html' ?>"><?= ($newsNotPublished > 1) ? 'Articles non publiés&nbsp:&nbsp' : 'Article non publié&nbsp:&nbsp' ?><?= $newsNotPublished ?></a></p>
            <p><a href="<?= HOST.'testimoniesNotPublished.html' ?>"><?= ($testimoniesNotPublished > 1) ? 'Témoignages non publiés&nbsp:&nbsp' : 'Témoignage non publié&nbsp:&nbsp' ?><?= $testimoniesNotPublished ?></a></p>

    	</section>

    	<section class="col-lg-6 col-sm-12 dashboards borders paddingRule">
    		<h3 class="sectionTitle">Gestion des commentaires</h3>

  			<p><a href="<?= HOST.'reportedPosts.html' ?>">Commentaires signalés : <?= $countPNReported + $countPTReported ?></a></p>

            <div class="separator"></div>

            <form class="paddingRule shapeForm" method="post" action="<?= HOST.'addModerationMessage' ?>">
                <legend>Ajouter / modifier des phrases de modération</legend>
                <div class="form-group">
                    <label for="existingMessages">Phrases existantes</label>
                    <select name="sentenceId" class="form-control" id="existingMessages">
                        <option value="0">Choisir la phrase à modifier</option>
                        <?php foreach($sentences AS $sentence) :?>
                            <option value="<?= htmlspecialchars($sentence->id()) ?>"><?= htmlspecialchars($sentence->moderationMessage()) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="moderationMessage">Phrase de modération</label>
                    <input class="form-control" type="text" name="moderationMessage" id="moderationMessage">
                </div>
                
                <button class="button" type="submit">Envoyer</button>
                
            </form>
    	</section>
    </div>

    <div class="d-flex justify-content-between flex-wrap">
  		<section class="col-sm-12 paddingRule dashboards borders">

  			<h3 class="sectionTitle">Gestion des utilisateurs</h3>

            <form class="paddingRule shapeForm" method="post" action="<?= HOST.'validateUsers' ?>">
                <legend>Valider un membre basic</legend>
                
                <?php if($users) :?>
                    <?php foreach($users AS $user) :?>
                        <div class="form-group isAccepted" id="isAccepted-<?= $user->id() ?>">                            
                            <input type="hidden" name="ids[]" value="<?= htmlspecialchars($user->id()) ?>">
                            <input id="yes-<?= htmlspecialchars($user->id()) ?>" name="isAccepted[]" type="checkbox" value="1" />
                            <label for="yes-<?= htmlspecialchars($user->id()) ?>">Oui</label>
                            <input id="no-<?= htmlspecialchars($user->id()) ?>" name="isAccepted[]" type="checkbox" value="0" />
                            <label for="no-<?= htmlspecialchars($user->id()) ?>">Non</label>
                            <a href="<?= HOST.'profile/userId/'.$user->id() ?>"><?= htmlspecialchars($user->login()).' : '.$user->name().' '.$user->lastname().' - '.$user->matricule() ?></a>
                        </div>
                    <?php endforeach ?>
                    <input type="hidden" name="rank" value="3">
                    <button class="button" type="submit">Envoyer</button>
                <?php else :?>
                    <p>Aucune demande de validation n'a été envoyée.</p>
                <?php endif ?>
            </form>

            <div class="separator"></div>

  			<form class="paddingRule shapeForm" method="post" action="changeRank">
                <legend>Changer le rang d'un utilisateur</legend>

                <div class="form-group">
                    <label for="nickname">Identifiant du membre</label>
                    <input class="form-control" type="text" name="login" id="nickname">
                </div>
                <div id="loginList" class="borders paddingRule"></div>

                <div class="form-group">
                    <label for="rank">Nouveau rang</label>
                    <select class="form-control" name="rank" id="rank">
                        <option>Sélectionnez les nouveaux droits ...</option>
                        <option value="0">Vérouiller le compte</option>
                        <option value="1">Dévérouiller le compte</option>
                        <option value="2">Membre Basic</option>
                        <option value="3">Membre Validé</option>
                        <option value="4">Membre du bureau</option>
                        <?php if($_SESSION['rank'] > 5) :?>
                            <option value="5">Administrateur</option>
                        <?php endif ?>
                    </select>
                </div>
                
                <button class="button" type="submit">Envoyer</button>
                
            </form>

    	</section>    	
    </div>
</section>
