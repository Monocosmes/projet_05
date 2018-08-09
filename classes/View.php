<?php

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
        unset($_SESSION['yourLogin']);
        unset($_SESSION['yourName']);
        unset($_SESSION['yourLastname']);
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
            return '<form id="shapeForm" method="post" action="'.HOST.'addTestimony" class="col-md-8 padding_rule">
                    <legend>Nouveau Témoignage</legend>';
        }
        else
        {
            return '<form id="shapeForm" method="post" action="'.HOST.'addNews" class="col-md-8 padding_rule">
                    <legend>Nouvel Article</legend>';
        }
    }

    public function displayEditArticleFormLine($article)
    {
        if($_SESSION['article'] === 'testimony')
        {
            return '<form id="shapeForm" method="post" action="'.HOST.'editTestimony/testimonyId/'.$article->id().'" class="col-md-8 padding_rule">
                    <legend>Modifier le témoignage</legend>';
        }
        else
        {
            return '<form id="shapeForm" method="post" action="'.HOST.'editNews/newsId/'.$article->id().'" class="col-md-8 padding_rule">
                    <legend>Modifier l\'article</legend>';
        }
    }

    public function displayCategoryName($article)
    {
        if(method_exists($article, 'categoryId'))
        {
            return '<p>Catégorie : '.htmlspecialchars($article->categoryName()).'</p>';
        }
    }

    public function displayCommentNumber($article)
    {
        if(method_exists($article, 'commentNumber'))
        {
            return '<p>Cet article a été commenté '.$article->commentNumber().' fois.</p>';
        }
    }

    public function displayDashboardLink()
    {
        if($_SESSION['rank'] >= 4)
        {
            return '<li class="nav-item"><a class="nav-link" href="'.HOST.'dashboard.html">Tableau de bord</a></li>';
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

    public function displayHighlightLink($news)
    {
        if($_SESSION['rank'] >= 4 AND method_exists($news, 'highlight'))
        {
            return (!$news->highlight())?'<a class="button" href="'.HOST.'highlight/newsId/'.$news->id().'">Mettre en lumière</a>':'';
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

    public function displaySignLinks()
    {
        if($_SESSION['isLogged'])
        {        
            return '<li class="nav-item"><a id="login" class="nav-link" href="'.HOST.'profile/userId/'.$_SESSION['id'].'">'.$_SESSION['login'].'</a></li>
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
        return '<div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
