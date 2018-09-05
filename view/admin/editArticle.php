<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'container'; ?>

<section class="container">

	<h2 class="sectionTitle"><?= ($_SESSION['article'] === 'testimony')?'Modifier un Témoignage':'Modifier un Article'; ?></h2>
			
   	<?= $this->displayEditArticleFormLine($article) ?>   		
			    
		<?php if($_SESSION['article'] === 'testimony') :?>
			<div class="form-group">
				<select name="categoryId" class="form-control">
					<option value="0">Sélectionnez une catégorie</option>
					<?php foreach($categories as $category) :?>
						<option <?= ($article->categoryId() === $category->id())?'selected':'' ?> value="<?= $category->id() ?>"><?= $category->name() ?></option>
					<?php endforeach ?>
				</select>
        	    
        	</div>
    	<?php endif ?>
		<div class="form-group">
	        <label>Auteur</label>
            <input class="form-control" type="hidden" name="authorId" value="<?= (int) 1 ?>">
            <input class="form-control" type="text" value="<?= htmlspecialchars($user->login()) ?>" disabled="true">
		</div>
		<div class="form-group">
            <label>Titre</label>
            <input class="form-control" type="text" name="title" required="true" placeholder="Titre de l'article" value="<?= (!isset($_SESSION['title'])) ? htmlspecialchars($article->title()) : htmlspecialchars($_SESSION['title']) ?>">
		</div>
		<div class="form-group">
            <label>Article</label>
            <textarea name="content" rows="20" class="form-control textarea" placeholder="Tapez votre article ici..."><?= (!isset($_SESSION['content'])) ? $article->content() : $_SESSION['content'] ?></textarea>
		</div>

		<?php if($_SESSION['article'] === 'news' AND $_SESSION['rank'] > 4) :?>
			<div class="form-group">
				<label class="form-control" for="highlight"><input type="checkbox" name="highlight" id="highlight" value="1" <?= ($article->highlight())?'checked="true"':'' ?>>&nbsp;Mettre cet article en lumière</label>
			</div>
		<?php endif ?>

		<?php if($_SESSION['rank'] > 4) :?>
			<button class="button" type="submit" name="published" value="1">Publier</button>
		<?php endif ?>

		<button class="button" type="submit" name="published" value="0">Enregistrer</button>
		<?= $article->articleLink() ?>
	</form>
</section>
