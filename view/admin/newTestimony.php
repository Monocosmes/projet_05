<?php $pageTitle = "Site CFDT INTERCO77"; ?>

	<section>
		<?php
			if(isset($_POST['editTestimonyView']))
   			{
   				$authorId = $testimonyData['testy_author_id'];
   				$authorLogin = $testimonyData['login'];
   				echo '<form id="shapeForm" method="post" action="index.php?action=editTestimony&amp;tid='.$testimonyId.'" class="col-md-8 padding_rule">';
   				echo '<legend>Modifier un Témoignage</legend>';
   			}
   			else
   			{
   				$authorId = $_SESSION['id'];
   				$authorLogin = $_SESSION['login'];
   				echo '<form id="shapeForm" method="post" action="index.php?action=addTestimony" class="col-md-8 padding_rule">';
   				echo '<legend>Nouveau Témoignage</legend>';
   			}
		?>
			<div class="form-group">
                <p>Choisissez une catégorie</p>
                <div class="form-check form-check-inline">
                    <input type="radio" name="categories" class="form-check-input" id="sexualHarassment" value="1" required="true" <?= (isset($testimonyData['categories']) AND $testimonyData['categories'] === '1')?'checked="true"':'' ?>>
                    <label class="form-check-label" for="sexualHarassment">Harcèlement sexuel</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="categories" class="form-check-input" id="discrimination" value="2" required="true" <?= (isset($testimonyData['categories']) AND $testimonyData['categories'] === '2')?'checked="true"':'' ?>>
                    <label class="form-check-label" for="discrimination">Discrimination</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="categories" class="form-check-input" id="sexism" value="3" required="true" <?= (isset($testimonyData['categories']) AND $testimonyData['categories'] === '3')?'checked="true"':'' ?>>
                    <label class="form-check-label" for="sexism">Sexisme</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" name="categories" class="form-check-input" id="moralHarassment" value="4" required="true" <?= (isset($testimonyData['categories']) AND $testimonyData['categories'] === '4')?'checked="true"':'' ?>>
                    <label class="form-check-label" for="moralHarassment">Harcèlement moral</label>
                </div>
            </div>

            <div class="form-group">
                <label>Auteur</label>
                <input class="form-control" type="hidden" name="authorId" value="<?= htmlspecialchars($user->id()) ?>">
                <input class="form-control" type="text" value="<?= htmlspecialchars($user->login()) ?>" disabled="true">
            </div>
            <div class="form-group">
                <label>Titre</label>
                <input class="form-control" type="text" name="title" required="true" placeholder="Titre de l'article" value="<?= isset($article)?htmlspecialchars($article->title()):'' ?>">
            </div>
            <div class="form-group">
                <label>Article</label>
                <textarea name="content" rows="20" class="form-control" placeholder="Tapez votre article ici..."><?= isset($article)?$article->content():'' ?></textarea>
            </div>	
			<button type="submit" name="publish" value="1">Publier</button>
			<button type="submit" name="publish" value="0">Enregistrer</button>
		</form>
	</section>
