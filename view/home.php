<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="container"'; ?>

<section class="container">

    <h2 class="sectionTitle">Aujourd'hui à la une !</h2>

    <article class="article center paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?>">
        <?php if(isset($news) AND !empty($news) AND $news->published()) :?>

        <?= $this->displayDeleteNewsButton($news) ?>

        <p>Article écrit par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($news->authorId()) ?>"><?= htmlspecialchars($news->authorName()) ?></a> le <?= htmlspecialchars($news->addDateFr()) ?><?= ($news->edited())?' - Article modifié le '.htmlspecialchars($news->editDate()):''; ?></p>
            <h3 class="uppercase"><?= $news->articleLink() ?></a></h3>
            <?= substr($news->content(), 0, 1000)?>
            <p><a href="<?= HOST.'news/newsId/'.$news->id() ?>">Lire la suite...</a></p>
            
            <div class="buttons">
                <?= $this->displayEditLink($news) ?>
                <?= $this->displayPusblishLinks($news) ?>
            </div>

        <?php else :?>
            <p>Aucun article n'est à la une actuellement</p>
        <?php endif ?>
    </article>

    <section class="row center">

        <h2 class="sectionTitle">Derniers articles publiés</h2>

        <?php if(count($allNews) > 0) :?>
            <div id="lastNews" class="displayFlex">
                <?php foreach($allNews as $news) :?>
                    
                    <?php $news->setArticleLink($news->title()); ?>
                    <div class="newsBlock paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?>">
                        <?= $this->displayCategoryName($news) ?>

                        <?= $this->displayDeleteNewsButton($news) ?>

                        <p>Par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($news->authorId()) ?>"><?= htmlspecialchars($news->authorName()) ?></a> le <?= htmlspecialchars($news->addDateFr()) ?></p>
                        <p class="newsTitle"><?= $news->articleLink() ?></p>
                        <?= substr($news->content(), 0, 250)?>
                        <p><a href="<?= HOST.'news/newsId/'.$news->id() ?>">Lire la suite...</a></p>
                        <?= $this->displayCommentCount($news) ?>

                        <div class="buttons">
                            <?= $this->displayEditLink($news) ?>
                            <?= $this->displayHighlightLink($news) ?>
                            <?= $this->displayPusblishLinks($news) ?>
                        </div>
                    </div>
                    
                <?php endforeach ?>
            </div>
        <?php else :?>
            <p>Aucun article publié actuellement</p>
        <?php endif ?>
    </section>

    <h2 class="sectionTitle">Dernier témoignage</h2>
    <article class="article center paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?>">
        
        <?php if(isset($testimony) AND !empty($testimony)) :?>

        <?= $this->displayDeleteTestimonyButton($testimony) ?>

        <p>Article écrit par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($testimony->authorId()) ?>"><?= htmlspecialchars($testimony->authorName()) ?></a> le <?= htmlspecialchars($testimony->addDateFr()) ?><?= ($testimony->edited())?' - Article modifié le '.htmlspecialchars($testimony->editDate()):''; ?></p>
            <h3><?= $testimony->articleLink() ?></a></h3>
            <?= substr($testimony->content(), 0, 1000) ?>
            <p><a href="<?= HOST.'testimony/testimonyId/'.$testimony->id() ?>">Lire la suite...</a></p>
            <?= $this->displayCommentCount($testimony) ?>
            
            <div class="buttons">
                <?= $this->displayEditLink($testimony) ?>
                <?= $this->displayHighlightLink($testimony) ?>
                <?= $this->displayPusblishLinks($testimony) ?>
            </div>
        <?php else :?>
            <p>Aucun témoignage publié actuellement</p>
        <?php endif ?>
        
    </article>
    
</section>
