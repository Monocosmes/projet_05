<?php $pageTitle = "Site CFDT INTERCO77"; $wrapper = 'class="container"'; ?>

<section class="container">

    <h2 class="sectionTitle">Aujourd'hui à la une !</h2>

    <article class="col-12 borders paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?>">
        <?php if(isset($news) AND !empty($news) AND $news->published()) :?>

            <?= $this->displayDeleteNewsButton($news) ?>

            <p class="col-11">Rédigé par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($news->authorId()) ?>"><?= htmlspecialchars($news->authorName()) ?></a> le <span title="Le <?= $news->formatDateAndHour($news->addDate()) ?>"><?= $news->formatDate($news->addDate()) ?></span><?= ($news->edited())?' - <span title="Modifié le '.$news->formatDateAndHour($news->editDate()).'">Article modifié</span>' :''; ?></p>
            <h3 class="uppercase"><?= $news->articleLink() ?></h3>
            <div class="col-10 article center paddingRule">
                <?= $news->content() ?>                
            </div>
            <br>
            <p><a href="<?= HOST.'news/newsId/'.$news->id() ?>">Lire la suite...</a></p>
            <?= $this->displayCommentCount($news) ?>
            
            <div class="buttons">
                <?= $this->displayEditLink($news) ?>
                <?= $this->displayPusblishLinks($news) ?>
            </div>

        <?php else :?>
            <p class="text-center marginRule">Aucun article n'est à la une actuellement</p>
        <?php endif ?>
    </article>

    <section class="row">

        <h2 class="sectionTitle">Derniers articles publiés</h2>

        <?php if(count($allNews) > 0) :?>
            <div id="lastNews" class="d-flex">
                <?php foreach($allNews as $news) :?>
                    
                    <?php $news->setArticleLink($news->title()); ?>
                    <div class="col-lg-6 col-sm-12 marginRule borders paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?>">
                        <?= $this->displayCategoryName($news) ?>

                        <?= $this->displayDeleteNewsButton($news) ?>

                        <p class="col-11">Par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($news->authorId()) ?>"><?= htmlspecialchars($news->authorName()) ?></a> le <span title="Le <?= $news->formatDateAndHour($news->addDate()) ?>"><?= $news->formatDate($news->addDate()) ?></span><?= ($news->edited())?' - <span title="Modifié le '.$news->formatDateAndHour($news->editDate()).'">Article modifié</span>' :''; ?></p>

                        <p class="newsTitle"><?= $news->articleLink() ?></p>
                        <div class="articles center paddingRule excerptSmall">
                            <?= $news->content() ?>
                            <p class="readMore"><a href="<?= HOST.'news/newsId/'.$news->id() ?>">Lire la suite...</a></p>
                        </div>
                        <br>
                        
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
            <p class="text-center marginRule">Aucun article publié actuellement</p>
        <?php endif ?>
    </section>

    <h2 class="sectionTitle">Dernier témoignage</h2>
    <article class="col-12 borders paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?>">

        <?php if(isset($testimony) AND !empty($testimony)) :?>

        <?= $this->displayDeleteTestimonyButton($testimony) ?>

        <p class="col-11">Rédigé par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($testimony->authorId()) ?>"><?= htmlspecialchars($testimony->authorName()) ?></a> le <span title="Le <?= $testimony->formatDateAndHour($testimony->addDate()) ?> ?>"><?= $testimony->formatDate($testimony->addDate()) ?></span><?= ($testimony->edited())?' - <span title="Modifié le '.$testimony->formatDateAndHour($testimony->editDate()).'">Article modifié</span>':''; ?></p>
        <p>Catégorie : <?= $testimony->categoryName() ?></p>
            <h3><?= $testimony->articleLink() ?></h3>
            <div class="col-10 article center paddingRule excerptBig">
                <?= $testimony->content() ?>
                <p class="readMore"><a href="<?= HOST.'testimony/testimonyId/'.$testimony->id() ?>">Lire la suite...</a></p>
            </div>
            <br>            
            <?= $this->displayCommentCount($testimony) ?>
            
            <div class="buttons">
                <?= $this->displayEditLink($testimony) ?>
                <?= $this->displayHighlightLink($testimony) ?>
                <?= $this->displayPusblishLinks($testimony) ?>
            </div>
        <?php else :?>
            <p class="text-center marginRule">Aucun témoignage publié actuellement</p>
        <?php endif ?>
        
    </article>
</section>
