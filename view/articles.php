<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="container"'; ?>

<section class="container">
    <h2 class="sectionTitle"><?= (!$allNews)?'Témoignages':'Articles'; ?></h2>

    
    <?= $this->displayAddArticleButton($allNews) ?>
    
    <?php if(!$allNews) :?>
        <div id="testimonyMenu">
                 <nav class="navbar navbar-expand navbar-dark bg-dark">
                    <div class="navbar-collapse">
                        <ul class="navbar-nav nav-fill flex-wrap w-100">
                            <li class="nav-item testimonyLink" id="testimony-0">Tous&nbsp;les&nbsp;témoignages</li>
                            <?php foreach ($categories as $category) :?>
                                <li class="nav-item testimonyLink" id="testimony-<?= $category->id() ?>"><?= $category->name() ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </nav>
            </div>
    <?php endif ?>

   	<?php if(isset($articles) AND count($articles) > 0) :?>
        <div id="newsPageContent" class="row justify-content-between">
        	<?php foreach($articles as $article) :?>
           		
        		<?php if($_SESSION['rank'] > 3 OR $article->published()) :?>
                    <?php $article->setArticleLink($article->title()); ?>
           		
            		<div class="col-lg-6 col-sm-12 marginRule borders paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?> <?= (!$article->published())?'notPublished':''; ?><?= (!$allNews)?' testimony-'.$article->categoryId().' testimonies':''; ?>">

                        <?php if(!$allNews) :?>
                            <?= $this->displayDeleteTestimonyButton($article) ?>
                        <?php else :?>
                            <?= $this->displayDeleteNewsButton($article) ?>
                        <?php endif ?>

                        <?= $this->displayCategoryName($article) ?>

            		    <p class="col-11">
                            Par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($article->authorId())?>"><?= htmlspecialchars($article->authorName()) ?></a> le <span title="Le <?= $article->formatDateAndHour($article->addDate()) ?>"><?= $article->formatDate($article->addDate()) ?></span><?= ($article->edited())?' - <span title="Modifié le '.$article->formatDateAndHour($article->editDate()).'">Article modifié</span>' :''; ?>
                        </p>

            	    	<p class="newsTitle"><?= $article->articleLink() ?></p>
            	        <div class="articles center paddingRule excerptSmall">
                            <?= $article->content() ?>

                            <?php if(!$allNews) :?>
                                <p class="readMore"><a href="<?= HOST.'testimony/testimonyId/'.$article->id() ?>">Lire la suite...</a></p>
                            <?php else :?>
                                <p class="readMore"><a href="<?= HOST.'news/newsId/'.$article->id() ?>">Lire la suite...</a></p>
                            <?php endif ?>
                        </div>

                        <br>
                        
                        

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
        <p class="text-center marginRule"><?= (isset($admin)) ? 'Aucun article en attente' : 'Aucun article publié actuellement' ?></p>
    <?php endif ?>
</section>
