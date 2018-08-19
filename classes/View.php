<?php

namespace classes;

/**
 * This class displays every views. It also displays some elements in it as button or links.
 */
class View
{
    private $page;

    public function __construct($page = [])
    {
        $this->page = $page;
    }

    public function render($elements = [])
    {
    	$page = $this->page;
    	extract($elements);
        
    	ob_start();
    	
		require_once VIEW.$page.'.php';

		$content = ob_get_clean();

		require_once VIEW.'_template.php';

        unset($_SESSION['errors']);
        unset($_SESSION['message']);
        unset($_SESSION['addressee']);
        unset($_SESSION['yourLogin']);
        unset($_SESSION['yourName']);
        unset($_SESSION['yourLastname']);
        unset($_SESSION['yourMatricule']);
        unset($_SESSION['yourEmail']);
        unset($_SESSION['article']);
        unset($_SESSION['title']);
        unset($_SESSION['content']);
    }

    public function redirect($route)
    {
        if(!preg_match('#http#', $route))
        {
            header('Location: ' .HOST.$route);
        }
        else
        {
            header('Location: ' .$route);
        }

        exit;
    }

    public function displayAddArticleFormLine()
    {
        if($_SESSION['article'] === 'testimony')
        {
            return '<form id="shapeForm" method="post" action="'.HOST.'addTestimony" class="paddingRule">';
        }
        else
        {
            return '<form id="shapeForm" method="post" action="'.HOST.'addNews" class="paddingRule">';
        }
    }

    public function displayEditArticleFormLine($article)
    {
        if($_SESSION['article'] === 'testimony')
        {
            return '<form id="shapeForm" method="post" action="'.HOST.'editTestimony/testimonyId/'.$article->id().'" class="paddingRule">';
        }
        else
        {
            return '<form id="shapeForm" method="post" action="'.HOST.'editNews/newsId/'.$article->id().'" class="paddingRule">';
        }
    }

    public function displayCancelButton($user)
    {
        return '<a class="button" href="'.$_SERVER['HTTP_REFERER'].'">Annuler</a>';
    }

    public function displayCategoryName($article)
    {
        if(method_exists($article, 'categoryId'))
        {
            return '<p>Catégorie : '.htmlspecialchars($article->categoryName()).'</p>';
        }
    }

    public function displayCommentCount($article)
    {
        if(method_exists($article, 'commentCount'))
        {
            return '<p>Cet article a été commenté '.$article->commentCount().' fois.</p>';
        }
    }

    public function displayDashboardLink()
    {
        if($_SESSION['rank'] >= 4)
        {
            return '<li class="nav-item"><a class="nav-link" href="'.HOST.'dashboard.html">Tableau&nbsp;de&nbsp;bord</a></li>';
        }
    }

    public function displayDeletePostButton($post, $articlePost)
    {
        if($_SESSION['rank'] > 3 OR $_SESSION['id'] === $post->authorId())
        {
            return '<div class="deleteArticle deletePost '.$articlePost.'" id="postId-'.$post->id().'" title="Supprimer ce commentaire">&#11199</div>';
        }
    }

    public function displayDeleteNewsButton($news)
    {
        if($_SESSION['rank'] > 3)
        {
            return '<div class="deleteArticle deleteNews"  id="news-'.$news->id().'" title="Supprimer cet article">&#11199</div>';
        }
    }

    public function displayDeleteTestimonyButton($testimony)
    {
        if($_SESSION['rank'] > 3)
        {
            return '<div class="deleteArticle deleteTestimony"  id="testimony-'.$testimony->id().'" title="Supprimer cet article">&#11199</div>';
        }
    }

    public function displayEditPostButton($post, $articlePost)
    {
        if($_SESSION['rank'] > 3 OR $_SESSION['id'] === $post->authorId())
        {
            return '<button class="button editPostButton '.$articlePost.'" type="submit" name="editPost" value="'.$post->id().'">Modifier</button>';
        }
    }

    public function displayEditLink($article)
    {
        if($_SESSION['rank'] >= 4)
        {
            if(method_exists($article, 'categoryId'))
            {
                return '<a class="button" href="'.HOST.'editArticle/testimonyId/'.$article->id().'">Modifier</a>';
            }
            else
            {
                return '<a class="button" href="'.HOST.'editArticle/newsId/'.$article->id().'">Modifier</a>';
            }
        }
    }

    public function displayEditProfileButton($user)
    {
        if($user->id() === $_SESSION['id'] OR $_SESSION['rank'] > 3)
        {
            return '<a class="button" href="'.HOST.'editProfile/userId/'.$user->id().'">Modifier</a>';
        }
    }

    public function displayHighlightLink($news)
    {
        if($_SESSION['rank'] >= 4 AND method_exists($news, 'highlight'))
        {
            return (!$news->highlight())?'<a class="button" href="'.HOST.'highlight/newsId/'.$news->id().'">Mettre en lumière</a>':'';
        }
    }

    public function displayMessageButton($user)
    {
        if($user->id() != $_SESSION['id'] AND $_SESSION['id'] > 0)
        {
            return '<a class="button" href="'.HOST.'newMessage/userId/'.$user->id().'">Message</a>';
        }
    }

    public function displayNewMessageButton()
    {
        if($_SESSION['id'] > 0)
        {
            return '<a class="button" href="'.HOST.'newMessage">Nouveau Message</a>';
        }
    }

    public function displayPusblishLinks($article)
    {
        $articleId = (method_exists($article, 'categoryId'))?'testimonyId':'newsId';

        if($_SESSION['rank'] >= 4)
        {
            return ($article->published())?'<a class="button" href="'.HOST.'publish/'.$articleId.'/'.$article->id().'/publish/0">Dépublier</a>':'<a class="button" href="'.HOST.'publish/'.$articleId.'/'.$article->id().'/publish/1">Publier</a>';
        }
    }

    public function displayReportPostButton($post, $articlePost)
    {
        $articlePostId = ($articlePost === 'newsPost') ? 'newsPostId' : 'testimonyPostId';
        
        return '<a class="button" href="'.HOST.'reportPost/'.$articlePostId.'/'.$post->id().'">Signaler</a>';
    }

    public function displaySettingProfileButton($user)
    {
        if($_SESSION['id'] === $user->id())
        {
            return '<a class="button" href="'.HOST.'profileSettings/userId/'.$user->id().'">Réglage du profil</a>';
        }
    }

    public function displaySignLinks($templateData = [])
    {
        if($_SESSION['isLogged'])
        {        
            $message = ($templateData->messageNumber() > 1) ? 'Messages' : 'Message';
            $number = ($templateData->messageNumber() > 0) ? '&nbsp;-&nbsp;'.$templateData->messageNumber() : '';

            return '<li class="nav-item"><a class="nav-link" href="'.HOST.'inbox/'.$_SESSION['login'].'">'.$message.$number.'</a></li>
                    <li class="nav-item"><a id="login" class="nav-link" href="'.HOST.'profile/userId/'.$_SESSION['id'].'">'.$_SESSION['login'].'</a></li>
                    <li class="nav-item"><a class="nav-link" href="'.HOST.'signoff">Deconnexion</a></li>';
        }
        else
        {
            return '<li class="nav-item"> <a id="loginPopup" class="nav-link" href="'.HOST.'signin.html">Se connecter</a></li>
                    <li class="nav-item"> <a class="nav-link" href="'.HOST.'signup.html">S\'inscrire</a></li>';
        }
    }

    public function displayTestimonyMenu()
    {
        return '<div class="content">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="testimonyMenu">
                        <div class="collapse navbar-collapse">
                            <ul class="navbar-nav nav-fill w-100">
                                <li class="nav-item testimonyLink" id="testimony-0"> Tous les témoignages</li>
                                <li class="nav-item testimonyLink" id="testimony-1">Harcèlement sexuel</li>
                                <li class="nav-item testimonyLink" id="testimony-2">Discrimination</li>
                                <li class="nav-item testimonyLink" id="testimony-3">Sexisme</li>
                                <li class="nav-item testimonyLink" id="testimony-4">Harcèlement moral</li>
                            </ul>
                        </div>
                    </nav>
                </div>';
    }
}
