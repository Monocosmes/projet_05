<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="container"'; ?>

<section class="container">
    <h2 class="sectionTitle">Recherche : <?= htmlspecialchars($_GET['search']) ?></h2>

   	<?php if(isset($results) AND count($results) > 0) :?>
        <div id="newsPageContent">
        	<?php foreach($results as $result) :?>
        		
                <?php $result->setArticleLink($result->title()); ?>
           		
            	<div class="col-lg-6 col-sm-12 marginRule borders paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?> <?= (!$result->published())?'notPublished':''; ?><?= (method_exists($result, 'categoryId'))?' testimony-'.$result->categoryId().' testimonies':''; ?>">

                    <?php if(method_exists($result, 'categoryId')) :?>
                        <?= $this->displayDeleteTestimonyButton($result) ?>
                    <?php else :?>
                        <?= $this->displayDeleteNewsButton($result) ?>
                    <?php endif ?>

                    <?= $this->displayCategoryName($result) ?>

            		<p class="col-11">Par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($result->authorId())?>"><?= htmlspecialchars($result->authorName()) ?></a> le <?= htmlspecialchars($result->addDateFr()) ?></p>
            	    <p class="newsTitle"><?= $result->articleLink() ?></p>
            	    <div class="articles center paddingRule">
                        <?= substr($result->content(), 0, 500).'...' ?>
                    </div>

                    <br>
                        
                    <?php if(method_exists($result, 'categoryId')) :?>
                        <p><a href="<?= HOST.'testimony/testimonyId/'.$result->id() ?>">Lire la suite...</a></p>
                    <?php else :?>
                        <p><a href="<?= HOST.'news/newsId/'.$result->id() ?>">Lire la suite...</a></p>
                    <?php endif ?>

            	    <?= $this->displayCommentCount($result) ?>

            	    <div class="buttons">
                        <?= $this->displayEditLink($result) ?>
                        <?= $this->displayHighlightLink($result) ?>
                        <?= $this->displayPusblishLinks($result) ?>
                    </div>

            	</div>
           	<?php endforeach ?>
        </div>
    <?php else :?>
        <p class="text-center marginRule">Cette recherche n'a retourné aucun résultat.</p>
    <?php endif ?>
</section>
