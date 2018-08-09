<?php $pageTitle = "Site CFDT INTERCO77"; ?>

<section class="content">
    <h2 class="sectionTitle container">Aujourd'hui à la une !</h2>
    <article class="article row container center paddingRule">
        <?php if(isset($news) AND !empty($news) AND $news->published()) :?>
        <p>Article écrit par <?= htmlspecialchars($news->authorName()) ?> le <?= htmlspecialchars($news->addDateFr()) ?><?= ($news->edited())?' - Article modifié le '.htmlspecialchars($news->editDate()):''; ?></p>
            <h3><?= $news->articleLink() ?></a></h3>
            <?= substr($news->content(), 0, 1000).'...' ?>
            
            <div>
                <?= $this->displayEditLink($news) ?>
                <?= $this->displayHighlightLink($news) ?>
                <?= $this->displayPusblishLinks($news) ?>
            </div>

        <?php else :?>
            <p>Aucun article publié actuellement</p>
        <?php endif ?>
    </article>

    <section class="row container center">
        <h2 class="sectionTitle">Derniers articles publiés</h2>
        <?php if(count($allNews) > 0) :?>
            <div id="lastNews" class="displayFlex">
                <?php foreach($allNews as $news) :?>
                    
                    <?php $news->setArticleLink($news->title()); ?>
                    <div class="newsBlock paddingRule <?= (!$news->published())?'notPublished':''; ?><?= (isset($testimonies))?' testimony-'.$news->categoryId():''; ?>">
                        <?= $this->displayCategoryName($news) ?>
                        <p>Par <?= htmlspecialchars($news->authorName()) ?> le <?= htmlspecialchars($news->addDateFr()) ?></p>
                        <p class="newsTitle"><?= $news->articleLink() ?></p>
                        <?= substr($news->content(), 0, 250).'&nbsp;...' ?>
                        <?= $this->displayCommentNumber($news) ?>
                        <div>
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

    <h2 class="sectionTitle container">Dernier témoignage</h2>
    <article class="article row container center paddingRule">
        
        <?php if(isset($testimony) AND !empty($testimony)) :?>
        <p>Article écrit par <?= htmlspecialchars($testimony->authorName()) ?> le <?= htmlspecialchars($testimony->addDateFr()) ?><?= ($testimony->edited())?' - Article modifié le '.htmlspecialchars($testimony->editDate()):''; ?></p>
            <h3><?= $testimony->articleLink() ?></a></h3>
            <?= substr($testimony->content(), 0, 1000).'...' ?>
            
            
            <div>
                <?= $this->displayEditLink($news) ?>
                <?= $this->displayHighlightLink($news) ?>
                <?= $this->displayPusblishLinks($news) ?>
            </div>
        <?php else :?>
            <p>Aucun témoignage publié actuellement</p>
        <?php endif ?>
        
    </article>
    
</section>
