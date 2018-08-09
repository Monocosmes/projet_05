<aside class="newsList">
    <h4>Derniers articles publiés</h4>         
    
    <?php if(isset($allNews) AND count($allNews) > 0) :?>
    
        <?php foreach($allNews as $news) :?>
        
            <?php if($news->published() OR $_SESSION['rank'] > 3) :?>            
            
                <div class="paddingRule<?= (!$news->published())?' notPublished':''; ?>">
                    <p>Par <?= htmlspecialchars($news->authorName()) ?> le <?= htmlspecialchars($news->addDateFr()) ?></p>
                    <p class="newsTitle"><a href="<?= HOST.'news/newsId/'.$news->id() ?>"><?= htmlspecialchars($news->title()) ?></a></p>
                    <div class="newsContent"><?= substr($news->content(), 0, 200).'&nbsp;...' ?></div>
                    <p>Cet article a été commenté <?= $news->commentNumber() ?> fois.</p>                               
                </div>
                <div class="separator"></div>
            <?php endif ?>
        <?php endforeach ?>
    <?php else :?>
    
        <p>Aucun article publié actuellement</p>
    
    <?php endif ?>
</aside>