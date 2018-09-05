<?php

namespace controller\frontend;

use \controller\Controller;
use \model\TestimonyManager;
use \model\UserManager;

class AjaxRequest extends Controller
{
    public function checkEmail($params)
    {
    	extract($params);

    	$email = $query;

    	$userManager = new UserManager();

    	if(!$userManager->exists($email)) {
    		$output = '&nbsp;&nbsp;<span class="fas fa-check text-success"></span>';
    	} else {
    		$output = '&nbsp;&nbsp;<span id="wrongEmail" class="textRed font-weight-bold">Cet email n\'est pas disponible</span>';
    	}

    	echo $output;
    }

    public function checkLogin($params)
    {
    	extract($params);

    	$login = $query;

    	$userManager = new UserManager();

    	if(!$userManager->exists($login)) {
    		$output = '&nbsp;&nbsp;<span class="fas fa-check text-success"></span>';
    	} else {
    		$output = '&nbsp;&nbsp;<span id="wrongLogin" class="textRed font-weight-bold">Cet identifiant n\'est pas disponible</span>';
    	}

    	echo $output;
    }

    public function checkMatricule($params)
    {
    	extract($params);

    	$matricule = $query;

    	$userManager = new UserManager();

    	if(!$userManager->exists($matricule)) {
    		$output = '&nbsp;&nbsp;<span class="fas fa-check text-success"></span>';
    	} else {
    		$output = '&nbsp;&nbsp;<span id="wrongLogin" class="textRed font-weight-bold">Ce matricule est déjà enregistré. Vérifié qu\'il s\'agit bien du vôtre</span>';
    	}

    	echo $output;
    }

    public function getTestimonies($params)
    {
        extract($params);

        $category = $query;

        if ($category == 0) {
        	$addWhere = '';
        } else {
        	$addWhere = ' WHERE categoryId = '.$category.' ';
        }        	

        $testimonyManager = new TestimonyManager();
        $articles = $testimonyManager->getAll($addWhere);

        $output = '';

        if ($articles) {
        	$addPadding = ($_SESSION['rank'] > 3) ? 'addPadding' : '';

        	foreach($articles AS $article) {
        		if($_SESSION['rank'] > 3 OR $article->published()) {
                    $edited = ($article->edited()) ? '<span title="Modifié le '.$article->formatDateAndHour($article->editDate()).'"> - Article modifié</span>' : '';

        			$output .= 	'<div class="col-lg-6 col-sm-12 marginRule borders paddingRule '.$addPadding.' testimony-'.$article->categoryId().' testimonies" >';
	
        			if($_SESSION['rank'] > 3) {
        				$output .=	'<div class="deleteButton deleteTestimony" title="Supprimer cet article"><span id="testimony-'.$article->id().'" class="far fa-times-circle"></span></div>';
        			}
	
        			$output .=	'<p>Catégorie : '.htmlspecialchars($article->categoryName()).'</p>';
        			$output .=	'<p class="col-11">Par <a href="'.HOST.'profile/userId/'.htmlspecialchars($article->authorId()).'">'.htmlspecialchars($article->authorName()).'</a> le <span title="Le '.$article->formatDateAndHour($article->addDate()).'">'. htmlspecialchars($article->formatDate($article->addDate())).'</span>'.$edited.'</p>';
        			$output .=	'<p class="newsTitle"><a href="'.HOST.'testimony/testimonyId/'.$article->id().'">'.htmlspecialchars($article->title()).'</a></p>';
        			$output .=	'<div class="articles center paddingRule">'.substr($article->content(), 0, 500).'...'.'</div><br>';
        			$output .=	'<p><a href="'.HOST.'testimony/testimonyId/'.$article->id().'">Lire la suite...</a></p>';
        			$output .=	'<p>Cet article a été commenté '.$article->commentCount().' fois.</p>';
	
        			if($_SESSION['rank'] > 3) {
        				$output .=	'<div class="buttons">';
        				$output .=	'<a class="button" href="'.HOST.'editArticle/testimonyId/'.$article->id().'">Modifier</a>';
        				$output .=	($article->published())?'<a class="button" href="'.HOST.'publish/testimonyId/'.$article->id().'/publish/0">Dépublier</a>':'<a class="button" href="'.HOST.'publish/'.$articleId.'/'.$article->id().'/publish/1">Publier</a>';
        				$output .=	'</div>';
        			}
        			$output .=	'</div>';
        		}
        	}

        } else {
        	$output = '<p id="noTestimony" class="text-center marginRule">Cette catégorie ne comporte aucun témoignage pour le moment</p>';
        }

        echo $output;
    }

    public function getUsers($params)
    {
        extract($params);

        $login = '%'.$query.'%';

        $userManager = new UserManager();
        $users = $userManager->search($login);

        $output = '<ul>';

        if($users) {
            foreach ($users as $user) {
               $output .= '<li class="userName">'.$user->login().'</li>';    
            }
        } else {
            $output .= '<li>L\'identifiant recherché n\'existe pas</li>';
        }

        $output .= '</ul>';

        echo $output;
    }
}