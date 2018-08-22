<?php $pageTitle = "Site CFDT INTERCO77 - ".$article->title(); $wrapper = 'class="container"'; ?>



<section class="container">
    <h2 class="sectionTitle" id="<?= htmlspecialchars($article->id()) ?>"><?= htmlspecialchars($article->title()) ?></h2>
    <article class="article borders paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?>">
        <?php if(isset($testimonies)) :?>
            <?= $this->displayDeleteTestimonyButton($article) ?>
        <?php else :?>
            <?= $this->displayDeleteNewsButton($article) ?>
        <?php endif ?>
        <p class="col-11">Article écrit par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($article->authorId()) ?>"><?= htmlspecialchars($article->authorName()) ?></a> le <?= $article->addDateFr() ?><?= ($article->edited())?' - Article modifié le '.$article->editDate():''; ?></p>    
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

                    <p>Par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($post->authorId()) ?>"><?= htmlspecialchars($post->authorName()) ?></a> le <?= htmlspecialchars($post->addDateFr()) ?><?= ($post->reported()) ? ' - <span class="textRed">Ce commentaire a été signalé</span>' : '' ?></p>

                    <?php if(($post->reported() OR $post->moderated()) AND $_SESSION['rank'] > 3) :?>

                        <form class="shapeForm paddingRule col-6" method="post" action="<?= HOST.'moderatePost' ?>">
    
                            <input type="hidden" name="id" value="<?= htmlspecialchars($post->id()) ?>">
                            <input type="hidden" name="articleId" value="<?= htmlspecialchars($post->articleId()) ?>">
                            <input type="hidden" name="dbName" value="<?= (isset($news)) ? 'postsnews' : 'poststestimony' ?>">

                            <div class="form-group">
                                <label for="moderationMessage">Motif de modération</label>
                                <select class="form-control" name="moderationId" id="moderationId">
                                    <option>Sélectionnez une raison...</option>
                                    <option value="-1">Retirer la modération</option>
                                    
                                    <?php foreach($moderations as $moderation) :?>
                                        <option value="<?= $moderation->id() ?>"><?= htmlspecialchars($moderation->moderationMessage()) ?></option>
                                    <?php endforeach ?>
    
                                </select>
                            </div>
    
                            <button type="submit" class="button">Envoyer</button>

                        </form>
                    <?php endif ?>

                    <?= $this->displayPost($post) ?>
                    
                </div>
                <div class="separator"></div>
            <?php endforeach ?>
        <?php else :?>
            <p>Ajoutez le premier commentaire à cet article</p>
        <?php endif ?>    
    </section>
    
    <section class="container">
        <?php if($_SESSION['isLogged']) :?>    
            <?php $path = (isset($news)) ? 'addPost/newsId/' : 'addPost/testimonyId/'; ?>
            <form method="post" action="<?= HOST.$path.$article->id() ?>" class="paddingRule shapeForm">                        
                <legend>Ajouter un commentaire</legend>
                <div class="form-group">
                    <label for="authorId">Auteur</label>
                    <input id="authorId" class="form-control" type="hidden" name="authorId" value="<?= $_SESSION['id'] ?>">
                    <input class="form-control" type="text" value="<?= htmlspecialchars($_SESSION['login']) ?>" disabled="true">
                </div>
                <div class="form-group">
                    <label for="content">Commentaire</label>
                    <textarea id="content" name="content" rows="5" class="form-control" placeholder="Tapez votre commentaire ici..."></textarea>
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
