<?php $pageTitle = "Site CFDT INTERCO77 - ".$article->title(); ?>

<section class="container-fluid">
    <div class="content">
        <div id="newsViewPage">
            <section class="paddingRule">
                <?php if(isset($article) AND !empty($article)) :?>

                    <?= $this->displayCategoryName($article) ?>
                    <h1 id="<?= $article->id() ?>"><?= htmlspecialchars($article->title()) ?></h1>
                    <?= $article->content() ?>
                    <p>Article écrit par <?= htmlspecialchars($article->authorName()) ?> le <?= $article->addDateFr() ?></p>
                    <?= ($article->edited())?'<p>Article modifié le '.$article->editDate():''; ?>

                    <div>
                        <?= $this->displayEditLink($article) ?>
                        <?= $this->displayHighlightLink($article) ?>
                        <?= $this->displayPusblishLinks($article) ?>
                    </div>
                        
                <?php else :?>                    
                    <p>Aucun article publié actuellement</p>
                <?php endif ?>
            </section>

            <?php if(isset($news) AND !empty($news)) :?>
                <section class="paddingRule">
                    <?php if(isset($posts) AND count($posts) > 0) :?>
                        <h2>Commentaires</h2>
                        
                        <?php foreach($posts as $post) :?>
                        
                            <?php if($_SESSION['rank'] >= 4 OR $_SESSION['id'] === $post->authorId()) :?>                        
                                <button class="buttons editPostButton" type="submit" name="editPost" value="<?= $post->id() ?>">Modifier</button>
                            <?php endif ?>
                            
                            <div id="post-<?= $post->id() ?>">
                                <p>Par <?= htmlspecialchars($post->authorName()) ?> le <?= htmlspecialchars($post->addDateFr()) ?></p>
                                <div>
                                    <?= $post->content() ?>
                                </div>
                            </div>
                            <div class="separator"></div>
                        <?php endforeach ?>
                    <?php else :?>
                        <p>Ajoutez le premier commentaire à cet article</p>
                    <?php endif ?>
    
                </section>
    
                <section class="paddingRule" id="commentSection">
                    <?php if($_SESSION['isLogged']) :?>
    
                        <form id="shapeForm" method="post" action="<?= HOST.'addPost/newsId/'.$news->id() ?>" class="col-md-12 paddingRule">
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
                                <input class="form-control" type="submit" value="Ajouter">
                            </div>
                        </form>
                    <?php else :?>
                        <p>Vous devez être connecté pour poster un commentaire</p>
                    <?php endif ?>
                </section>
            <?php endif ?>
        </div>
  
        <?php require 'view/aside.php'; ?>
                    
    </div>         
    
</section>
