<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="content"'; ?>

<section class="content">
    <h2 class="sectionTitle"><?= (!isset($allNews))?'Témoignages':'Articles'; ?></h2>

    <?= (!isset($allNews))?$this->displayTestimonyMenu():''; ?>

   	<?php if(isset($articles) AND count($articles) > 0) :?>
        <div id="newsPageContent">
        	<?php foreach($articles as $article) :?>
           		
        		<?php if($_SESSION['rank'] > 3 OR $article->published()) :?>
                    <?php $article->setArticleLink($article->title()); ?>
           		
            		<div class="newsBlock paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?> <?= (!$article->published())?'notPublished':''; ?><?= (isset($testimonies))?' testimony-'.$article->categoryId().' testimonies':''; ?>">

                        <?php if(isset($testimonies)) :?>
                            <?= $this->displayDeleteTestimonyButton($article) ?>
                        <?php else :?>
                            <?= $this->displayDeleteNewsButton($article) ?>
                        <?php endif ?>

                        <?= $this->displayCategoryName($article) ?>

            		    <p>Par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($article->authorId())?>"><?= htmlspecialchars($article->authorName()) ?></a> le <?= htmlspecialchars($article->addDateFr()) ?></p>
            	    	<p class="newsTitle"><?= $article->articleLink() ?></p>
            	        <?= substr($article->content(), 0, 250) ?>

                        <?php if(isset($testimonies)) :?>
                            <p><a href="<?= HOST.'testimony/testimonyId/'.$article->id() ?>">Lire la suite...</a></p>
                        <?php else :?>
                            <p><a href="<?= HOST.'news/newsId/'.$article->id() ?>">Lire la suite...</a></p>
                        <?php endif ?>

            	        <?= $this->displayCommentCount($article) ?>

            	        <div class="buttons">
                            <?= $this->displayEditLink($article) ?>
                            <?= $this->displayHighlightLink($article) ?>
                            <?= $this->displayPusblishLinks($article) ?>
                        </div>

            	  	</div>                	    
            	<?php endif ?>
            		       		
           	<?php endforeach ?>
        </div>
    <?php else :?>
        <p>Aucun article publié actuellement</p>
    <?php endif ?>
</section>
