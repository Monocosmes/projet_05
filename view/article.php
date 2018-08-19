<?php $pageTitle = "Site CFDT INTERCO77 - ".$article->title(); $wrapper = 'class="container"'; ?>



<section class="container">
    <h2 class="sectionTitle" id="<?= htmlspecialchars($article->id()) ?>"><?= htmlspecialchars($article->title()) ?></h2>
    <article class="article paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?>">
        <?php if(isset($testimonies)) :?>
            <?= $this->displayDeleteTestimonyButton($article) ?>
        <?php else :?>
            <?= $this->displayDeleteNewsButton($article) ?>
        <?php endif ?>
        <p>Article écrit par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($article->authorId()) ?>"><?= htmlspecialchars($article->authorName()) ?></a> le <?= $article->addDateFr() ?><?= ($article->edited())?' - Article modifié le '.$article->editDate():''; ?></p>    
        <?= $this->displayCategoryName($article) ?>    
        <?= $article->content() ?>    
        <div class="buttons">
            <?= $this->displayEditLink($article) ?>
            <?= $this->displayHighlightLink($article) ?>
            <?= $this->displayPusblishLinks($article) ?>
        </div>
    </article>
</section>

<?php if((isset($news) AND $_SESSION['rank'] > 0) OR (!isset($news) AND $_SESSION['rank'] > 2)) :?>
    <?php $articlePost = (isset($news)) ? 'newsPost' : 'testimonyPost'; ?>

    <section class="container">
        <?php if(isset($posts) AND count($posts) > 0) :?>
            <h2 class="sectionTitle">commentaires</h2>                        
            <?php foreach($posts as $post) :?>
                    
                <div class="comments paddingRule" id="post-<?= $post->id() ?>">

                    <?= $this->displayDeletePostButton($post, $articlePost) ?>
                    <div class="buttons">
                        <?= $this->displayReportPostButton($post, $articlePost) ?>
                        <?= $this->displayEditPostButton($post, $articlePost) ?>
                    </div>
                    <p>Par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($post->authorId()) ?>"><?= htmlspecialchars($post->authorName()) ?></a> le <?= htmlspecialchars($post->addDateFr()) ?><?= ($post->reported() == 1) ? ' - <span class="textRed">Ce commentaire a été signalé</span>' : '' ?></p>
                    <div><?= nl2br(htmlspecialchars($post->content())) ?></div>
                    
                </div>
                <div class="separator"></div>
            <?php endforeach ?>
        <?php else :?>
            <p>Ajoutez le premier commentaire à cet article</p>
        <?php endif ?>    
    </section>
    
    <section class="container" id="commentSection">
        <?php if($_SESSION['isLogged']) :?>    
            <?php $path = (isset($news)) ? 'addPost/newsId/' : 'addPost/testimonyId/'; ?>
            <form id="shapeForm" method="post" action="<?= HOST.$path.$article->id() ?>" class="paddingRule">                        
                <legend>Ajouter un commentaire</legend>
                <div class="form-group">
                    <label>Auteur</label>
                    <input class="form-control" type="hidden" name="authorId" value="<?= $_SESSION['id'] ?>">
                    <input class="form-control" type="text" value="<?= htmlspecialchars($_SESSION['login']) ?>" disabled="true">
                </div>
                <div class="form-group">
                    <label>Commentaire</label>
                    <textarea name="content" rows="5" class="form-control" placeholder="Tapez votre commentaire ici..."></textarea>
                </div>
                <div class="form-group">
                    <input class="button" type="submit" value="Ajouter">
                </div>
            </form>
        <?php else :?>
            <p>Vous devez être connecté pour poster un commentaire</p>
        <?php endif ?>
    </section>
<?php endif ?>
