<?php $pageTitle = "Site CFDT INTERCO77"; ?>

<section>
    <h2 class="uppercase center_text"><?= (!isset($allNews))?'Témoignages':'Articles'; ?></h2>

    <?= (!isset($allNews))?$this->displayTestimonyMenu():''; ?>

   	<?php if(isset($articles) AND count($articles) > 0) :?>
        <div id="newsPageContent">
        	<?php foreach($articles as $article) :?>
           		
        		<?php if($_SESSION['rank'] > 3 OR $article->published()) :?>
                    <?php $article->setArticleLink($article->title()); ?>
           		
            		<div class="newsBlock paddingRule <?= (!$article->published())?'notPublished':''; ?><?= (isset($testimonies))?' testimony-'.$article->categoryId():''; ?>">

                        <?= $this->displayCategoryName($article) ?>

            		    <p>Par <?= htmlspecialchars($article->authorName()) ?> le <?= htmlspecialchars($article->addDateFr()) ?></p>
            	    	<p class="newsTitle"><?= $article->articleLink() ?></p>
            	        <?= substr($article->content(), 0, 250).'&nbsp;...' ?>

            	        <?= $this->displayCommentNumber($article) ?>

            	        <div>
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
