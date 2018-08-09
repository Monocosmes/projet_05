<?php $pageTitle = "Site CFDT INTERCO77"; ?>

<section>
			
   	<?= $this->displayAddArticleFormLine(); ?>   		
			    
		<?php if($_SESSION['article'] === 'testimony') :?>
			<div class="form-group">
				<select name="categoryId" class="form-control">
					<option value="0">Sélectionnez une catégorie</option>
					<?php foreach($categories as $category) :?>
						<option <?= (isset($article) AND $article->categoryId() === $category->id())?'selected':'' ?> value="<?= $category->id() ?>"><?= $category->name() ?></option>
					<?php endforeach ?>
				</select>
        	    
        	</div>
    	<?php endif ?>
		<div class="form-group">
	        <label>Auteur</label>
            <input class="form-control" type="hidden" name="authorId" value="<?= htmlspecialchars($user->id()) ?>">
            <input class="form-control" type="text" value="<?= htmlspecialchars($user->login()) ?>" disabled="true">
		</div>
		<div class="form-group">
            <label>Titre</label>
            <input class="form-control" type="text" name="title" required="true" placeholder="Titre de l'article" value="<?= (isset($_SESSION['title'])) ? htmlspecialchars($_SESSION['title']) : ''?>">
		</div>
		<div class="form-group">
            <label>Article</label>
            <textarea name="content" rows="20" class="form-control" placeholder="Tapez votre article ici..."><?= (isset($_SESSION['content'])) ? $_SESSION['content'] : '' ?></textarea>
		</div>

		<?php if($_SESSION['article'] === 'news') :?>
			<div class="form-group">
				<label class="form-control" for="highlight"><input type="checkbox" name="highlight" id="highlight" value="1">&nbsp;Mettre cet article en lumière</label>
			</div>
		<?php endif ?>

		<button class="buttons" type="submit" name="published" value="1">Publier</button>
		<button class="buttons" type="submit" name="published" value="0">Enregistrer</button>
		<?= (isset($article))?$article->articleLink():'' ?>
	</form>
</section>
