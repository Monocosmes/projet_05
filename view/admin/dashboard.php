<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="content"'; ?>

<section class="content">

   	<h2 class="sectionTitle">Tableau de bord</h2>

  	<div class="d-flex justify-content-between flex-wrap">
  		<section class="col-lg-6 col-sm-12 dashboards borders paddingRule">

  			<h3 class="sectionTitle">Gestion des articles</h3>

  			<a href="<?= HOST.'newArticle.html' ?>">Rédiger un nouvel article</a></p>
    		<a href="<?= HOST.'newTestimony.html' ?>">Rédiger un nouveau témoignage</a>

    	</section>

    	<section class="col-lg-6 col-sm-12 dashboards borders paddingRule">
    		<h3 class="sectionTitle">Gestion des commentaires</h3>

  			<p><a href="<?= HOST.'reportedPosts.html' ?>">Commentaires signalés : <?= $countPNReported + $countPTReported ?></a></p>

            <div class="separator"></div>

            <form class="paddingRule shapeForm" method="post" action="addModerationMessage">
                <legend>Ajouter de nouvelles phrases de modération</legend>
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

            <form class="paddingRule shapeForm" method="post" action="changeRank">
                <legend>Valider un membre basic</legend>
                
                <?php if($users) :?>
                    <?php foreach($users AS $user) :?>
                        <div class="form-group">
                            <label for="<?= htmlspecialchars($user->login()) ?>"><input id="<?= htmlspecialchars($user->login()) ?>" name="logins[]" type="checkbox" value="<?= htmlspecialchars($user->login()) ?>" > <a href="<?= HOST.'profile/userId/'.$user->id() ?>"><?= htmlspecialchars($user->login()).' : '.$user->name().' '.$user->lastname().' - '.$user->matricule() ?></a></label>
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
