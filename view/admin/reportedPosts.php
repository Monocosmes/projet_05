<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="container"'; ?>

<section class="container">

	<h2 class="sectionTitle">Commentaires signalés</h2>

	<?php if($postsNReported OR $postsTReported) :?>
		<div class="d-flex flex-wrap justify-content-between">
			<?php if($postsNReported) :?>
				<?php foreach($postsNReported as $post) :?>
						<div class="col-lg-6 col-sm-12 newsBlock borders paddingRule addPadding">
	
							<?= $this->displayDeletePostButton($post, 'newsPost') ?>
	
    	                	<div class="buttons">
    	                		<?= $this->displayReportPostButton($post, 'newsPost') ?>
    	                	    <?= $this->displayEditPostButton($post, 'newsPost') ?>
    	                	</div>
	
							<p class="col-11">Par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($post->authorId()) ?>"><?= htmlspecialchars($post->authorName()) ?></a> le <?= htmlspecialchars($post->addDateFr()) ?></p>
	
							<div><?= substr(htmlspecialchars($post->content()), 0, 500) ?></div>
							<br>
							<p><a href="<?= HOST.'news/newsId/'.$post->articleId().'#post-'.$post->id() ?>">Lire la suite...</a></p>
	
						</div>
				<?php endforeach ?>
			
			<?php endif ?>

			<?php if($postsTReported) :?>
			
				<?php foreach($postsTReported as $post) :?>
					<div class="col-lg-6 col-sm-12 newsBlock borders paddingRule addPadding">
	
						<?= $this->displayDeletePostButton($post, 'testimonyPost') ?>
	
    	                <div class="buttons">
    	                	<?= $this->displayReportPostButton($post, 'testimonyPost') ?>
    	                	<?= $this->displayEditPostButton($post, 'testimonyPost') ?>
    	                </div>
	
						<p class="col-11">Par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($post->authorId()) ?>"><?= htmlspecialchars($post->authorName()) ?></a> le <?= htmlspecialchars($post->addDateFr()) ?></p>
	
						<div><?= substr(htmlspecialchars($post->content()), 0, 500) ?></div>
						<br>
						<p><a href="<?= HOST.'testimony/testimonyId/'.$post->articleId().'#post-'.$post->id() ?>">Lire la suite...</a></p>
	
					</div>
				<?php endforeach ?>
			
			<?php endif ?>
		</div>
	<?php else :?>
		<div>
			Aucun commentaire n'a été signalé.
		</div>
	<?php endif ?>
</section>
