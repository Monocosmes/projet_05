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
        //echo VIEW.$page; exit;
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
        if(!preg_match('#http|https#', $route))
        {
            header('Location: ' .HOST.$route);
        }
        else
        {
            header('Location: ' .$route);
        }

        exit;
    }

    public function displayAddArticleButton($allNews)
    {
        if($_SESSION['rank'] > 3) {
            if ($allNews) {
                return '<div class="d-flex justify-content-center mb-4"><a class="button" href="'.HOST.'newArticle.html">Ajouter un nouvel article</a></div>';
            } else {
                return '<div class="d-flex justify-content-center mb-4"><a class="button" href="'.HOST.'newTestimony.html">Ajouter un nouveau témoignage</a></div>';
            }
        }
    }

    public function displayAddArticleFormLine()
    {
        if($_SESSION['article'] === 'testimony')
        {
            return '<form method="post" action="'.HOST.'addTestimony" class="col-12 paddingRule shapeForm">';
        }
        else
        {
            return '<form method="post" action="'.HOST.'addNews" class="col-12 paddingRule shapeForm">';
        }
    }

    public function displayEditArticleFormLine($article)
    {
        if($_SESSION['article'] === 'testimony')
        {
            return '<form method="post" action="'.HOST.'editTestimony/testimonyId/'.$article->id().'" class="col-12 paddingRule shapeForm">';
        }
        else
        {
            return '<form method="post" action="'.HOST.'editNews/newsId/'.$article->id().'" class="col-12 paddingRule shapeForm">';
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
        return '<p>Cet article a été commenté '.$article->commentCount().' fois.</p>';
    }

    public function displayDashboardLink()
    {
        if($_SESSION['rank'] > 3 AND $_SESSION['isLogged'] === session_id())
        {
            return '<li class="nav-item"><a class="nav-link" href="'.HOST.'dashboard.html">Tableau&nbsp;de&nbsp;bord</a></li>';
        }
    }

    public function displayDeleteAccountButton($user)
    {
        if(($user->id() === $_SESSION['id'] OR $_SESSION['rank'] > 4) AND $user->rank() < 5)
        {
            return '<button class="button" id="deleteAccount" value="'.$user->id().'">Supprimer le compte</button>';
        }
    }

    public function displayDeletePostButton($post, $articlePost)
    {
        if($_SESSION['rank'] > 3 OR $_SESSION['id'] === $post->authorId())
        {
            return '<div class="deleteButton deletePost" title="Supprimer ce commentaire"><span id="postId-'.$post->id().'" class="far fa-times-circle '.$articlePost.'"></span></div>';
        }
    }

    public function displayDeleteMessageButton($answer)
    {
        if($_SESSION['id'] === $answer->authorId())
        {
            return '<div class="deleteButton deleteMessage" title="Supprimer le message"><span id="message-'.$answer->id().'" class="far fa-times-circle"></span></div>';
        }
    }    

    public function displayDeleteNewsButton($news)
    {
        if($_SESSION['rank'] > 4)
        {
            return '<div class="deleteButton deleteNews" title="Supprimer cet article"><span id="news-'.$news->id().'" class="far fa-times-circle"></span></div>';
        }
    }

    public function displayDeleteTestimonyButton($testimony)
    {
        if($_SESSION['rank'] > 4)
        {
            return '<div class="deleteButton deleteTestimony" title="Supprimer cet article"><span id="testimony-'.$testimony->id().'" class="far fa-times-circle"></span></div>';
        }
    }

    public function displayEditMessageButton($answer)
    {
        if($_SESSION['id'] === $answer->authorId())
        {
            return '<button class="button editConversation" value="'.$answer->id().'" id="message-'.$answer->id().'" >Modifier</button>';            
        }
    }

    public function displayEditPostButton($post, $articlePost)
    {
        if($_SESSION['rank'] > 3 OR $_SESSION['id'] === $post->authorId())
        {
            return '<button class="button editPostButton '.$articlePost.'" value="'.$post->id().'">Modifier</button>';
        }
    }

    public function displayEditLink($article)
    {
        if(($_SESSION['rank'] > 3 AND !$article->published()) OR $_SESSION['rank'] > 4)
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
        if($user->id() === $_SESSION['id'] OR ($_SESSION['rank'] > 3 AND $user->rank() < 5 ))
        {
            return '<a class="button" href="'.HOST.'editProfile/userId/'.$user->id().'">Modifier</a>';
        }
    }

    public function displayHighlightLink($news)
    {
        if($_SESSION['rank'] > 3 AND method_exists($news, 'highlight') AND $news->published())
        {
            return (!$news->highlight())?'<a class="button" href="'.HOST.'highlight/newsId/'.$news->id().'">Mettre en lumière</a>':'';
        }
    }

    public function displayLeaveConversationButton($message, $class)
    {
        if($_SESSION['id'] === $message->authorId() OR $_SESSION['id'] === $message->receiverId())
        {
            if($class === 'deleteButton')
            {
                return '<div class="'.$class.' leaveConversation" title="Quitter la conversation"><span id="message-'.$message->id().'" class="far fa-times-circle"></span></div>';
            }
            else
            {
                return '<button class="'.$class.' leaveConversation" id="message-'.$message->id().'" title="Quitter la conversation">Quitter la conversation</button>';
            }
        }
    }

    public function displayLockAccountButton($user)
    {
        if($_SESSION['rank'] > 3 AND $user->rank() < $_SESSION['rank'] AND $user->id() != $_SESSION['id'])
        {
            if($user->accountLocked())
            {
                return '<a class="button" href="'.HOST.'lockAccount/userId/'.$user->id().'/lock/0">Dévérouiller le compte</a>';
            }
            else
            {
                return '<a class="button" href="'.HOST.'lockAccount/userId/'.$user->id().'/lock/1">Vérouiller le compte</a>';
            }            
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

    public function displayPost($post)
    {
        if($post->moderated())
        {
            if($_SESSION['rank'] > 3 OR $_SESSION['id'] === $post->authorId())
            {
                return '<span class="textRed">'.htmlspecialchars($post->moderationMessage()).'</span><br><div class="comments col-12 marginRule">'.nl2br(htmlspecialchars($post->content())).'</div>';
            }
            else
            {
                return '<span class="textRed">'.htmlspecialchars($post->moderationMessage()).'</span>';
            }
        }
        else
        {
            return '<div class="comments col-12 marginRule">'.nl2br(htmlspecialchars($post->content())).'</div>';
        }
    }

    public function displayPusblishLinks($article)
    {
        $articleId = (method_exists($article, 'categoryId'))?'testimonyId':'newsId';

        if($_SESSION['rank'] > 4)
        {
            return ($article->published())?'<a class="button" href="'.HOST.'publish/'.$articleId.'/'.$article->id().'/publish/0">Dépublier</a>':'<a class="button" href="'.HOST.'publish/'.$articleId.'/'.$article->id().'/publish/1">Publier</a>';
        }
    }

    public function displayReportPostButton($post, $articlePost)
    {
        $articlePostId = ($articlePost === 'newsPost') ? 'newsPostId' : 'testimonyPostId';

        if(!$post->moderated())
        {
            if(($post->reported() === 1 AND $_SESSION['rank'] < 4) OR !$post->reported())
            {
                return '<a class="button" href="'.HOST.'reportPost/'.$articlePostId.'/'.$post->id().'">Signaler</a>';
            }
            else
            {
                return '<a class="button" href="'.HOST.'unreportPost/'.$articlePostId.'/'.$post->id().'">Conforme</a>';
            }
        }
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
        if($_SESSION['isLogged'] === session_id())
        {        
            $message = ($templateData->messageNumber() > 1) ? 'Messages' : 'Message';
            $number = ($templateData->messageNumber() > 0) ? '&nbsp;-&nbsp;'.$templateData->messageNumber() : '';

            return '<li class="nav-item"><a class="nav-link" href="'.HOST.'inbox/'.$_SESSION['login'].'">'.$message.$number.'</a></li>
                    <li class="nav-item"><a id="login" class="nav-link" href="'.HOST.'profile/userId/'.$_SESSION['id'].'">'.$_SESSION['login'].'</a></li>
                    <li class="nav-item"><a class="nav-link" href="'.HOST.'signoff">Deconnexion</a></li>';
        }
        else
        {
            return '<li class="nav-item"> <a class="nav-link loginPopup" href="'.HOST.'signin.html">Se connecter</a></li>
                    <li class="nav-item marginSign"> <a class="nav-link" href="'.HOST.'signup.html">S\'inscrire</a></li>';
        }
    }
}
