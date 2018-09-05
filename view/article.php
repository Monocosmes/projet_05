<?php $pageTitle = "Site CFDT INTERCO77 - ".$article->title(); $wrapper = 'class="container"'; ?>



<article class="container">
    <h2 class="sectionTitle" id="<?= htmlspecialchars($article->id()) ?>"><?= htmlspecialchars($article->title()) ?></h2>
    <div class="col-12 borders paddingRule <?= ($_SESSION['rank'] > 3) ? 'addPadding' : '' ?>">
        <?php if(!$news) :?>
            <?= $this->displayDeleteTestimonyButton($article) ?>
        <?php else :?>
            <?= $this->displayDeleteNewsButton($article) ?>
        <?php endif ?>

        <p class="col-11">
            Rédigé par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($article->authorId()) ?>"><?= htmlspecialchars($article->authorName()) ?></a> le <span title="Le <?= $article->formatDateAndHour($article->addDate()) ?>"><?= $article->formatDate($article->addDate()) ?></span><?= ($article->edited())?' - <span title="Modifié le '.$article->formatDateAndHour($article->editDate()).'">Article modifié</span>' :''; ?>
        </p>

        <?= $this->displayCategoryName($article) ?>    
        <div class="col-10 article center paddingRule"><?= $article->content() ?></div>
        <div class="buttons">
            <?= $this->displayEditLink($article) ?>
            <?= $this->displayHighlightLink($article) ?>
            <?= $this->displayPusblishLinks($article) ?>
        </div>
    </div>
</article>

<?php if(($news AND $_SESSION['rank'] > 0) OR (!$news AND $_SESSION['rank'] > 2)) :?>
    <?php $articlePost = ($news) ? 'newsPost' : 'testimonyPost'; ?>

    <section class="container">
        <?php if(isset($posts) AND count($posts) > 0) :?>
            <h2 class="sectionTitle">commentaires</h2> 

            <?php foreach($posts as $post) :?>
                 <div class="row">
                    
                    <div class="col-2 paddingRule borders marginRule">
                        <div class="avatar col-9 center">
                            <a id="avatar" title="<?= $post->authorName() ?>" href="<?= HOST.'profile/userId/'.htmlspecialchars($post->authorId()) ?>"><img src="<?= ASSETS.'images/avatars/'.htmlspecialchars($post->avatar()) ?>"></a>
                        </div>
                        <p class="text-center pt-2"><a href="<?= HOST.'profile/userId/'.htmlspecialchars($post->authorId()) ?>"><?= htmlspecialchars($post->authorName()) ?></a></p>
                    </div>

                    <div class="col-10 paddingRule borders marginRule" id="post-<?= $post->id() ?>">
    
                        <?= $this->displayDeletePostButton($post, $articlePost) ?>
    
                        <div class="buttons">
                            <?= $this->displayReportPostButton($post, $articlePost) ?>
                            <?= $this->displayEditPostButton($post, $articlePost) ?>
                        </div>
    
                        <p>
                            Par <a href="<?= HOST.'profile/userId/'.htmlspecialchars($post->authorId()) ?>"><?= htmlspecialchars($post->authorName()) ?></a> le <span title="Le <?= $post->formatDateAndHour($post->addDate()) ?>"><?= $post->formatDate($post->addDate()) ?><?= ($post->edited())?' <span title="Modifié le '.$post->formatDateAndHour($post->editDate()).'">(Modifié)</span>' :''; ?><?= ($post->reported()) ? ' - <span class="textRed">Ce commentaire a été signalé</span>' : '' ?>
                        </p>
    
                        <?php if(($post->reported() OR $post->moderated()) AND $_SESSION['rank'] > 3) :?>
    
                            <form class="shapeForm paddingRule col-6 offset-6" method="post" action="<?= HOST.'moderatePost' ?>">
        
                                <input type="hidden" name="id" value="<?= htmlspecialchars($post->id()) ?>">
                                <input type="hidden" name="articleId" value="<?= htmlspecialchars($post->articleId()) ?>">
                                <input type="hidden" name="dbName" value="<?= (isset($news)) ? 'postsnews' : 'poststestimony' ?>">
                                <label for="moderationMessage">Motif de modération</label>
                                <div class="d-flex">
                                    <div class="align-self-center">                                
                                        <select class="form-control" name="moderationId" id="moderationId">
                                            <option>Sélectionnez une raison...</option>
                                            <option value="-1">Retirer la modération</option>
                                            
                                            <?php foreach($moderations as $moderation) :?>
                                                <option value="<?= $moderation->id() ?>"><?= htmlspecialchars($moderation->moderationMessage()) ?></option>
                                            <?php endforeach ?>
            
                                        </select>    
                                    </div>
                                    <button type="submit" class="button">Envoyer</button>
                                </div>
    
                            </form>
                        <?php endif ?>
    
                        <?= $this->displayPost($post) ?>
                        
                    </div>
                </div>
            <?php endforeach ?>
        <?php else :?>
            <p class="marginRule">Ajoutez le premier commentaire à cet article</p>
        <?php endif ?>    
    </section>
    
    <section class="container">
        <?php if($_SESSION['isLogged'] === session_id()) :?>    
            <?php $path = ($news) ? 'addPost/newsId/' : 'addPost/testimonyId/'; ?>
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
            <p class="marginRule">Vous devez être <a class="loginPopup" href="<?= HOST.'signin.html' ?>">connecté</a> pour poster un commentaire</p>
        <?php endif ?>
    </section>
<?php endif ?>
