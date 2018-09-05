<?php

namespace controller\backend;

use \controller\Controller;

use \model\PostManager;
use \model\UserManager;
use \model\CategoryManager;
use \model\ModerationManager;
use \model\NewsManager;
use \model\TestimonyManager;
use \classes\View;

class ViewController extends Controller
{
    public function showDashboardPage($params)
	{
	   	if($_SESSION['rank'] < 4 || $_SESSION['id'] === 0){$myView = new View(); $myView->redirect('home.html');}

	   	$addWhere['champ'][] = 'reported';
	   	$addWhere['value'][] = '1';
	   	
	   	$postNewsManager = new PostManager('postsnews');
	   	$postTestimonyManager = new PostManager('poststestimony');
	   	$moderationManager = new ModerationManager();
	   	$newsManager = new NewsManager();
	   	$testimonyManager = new TestimonyManager();

	   	$sentences = $moderationManager->getAll();

	   	$countPNReported = $postNewsManager->count($addWhere);
	   	$countPTReported = $postTestimonyManager->count($addWhere);

	   	$addWhere['champ'][0] = 'askVerification';

	   	$userManager = new UserManager();
	   	$users = $userManager->getAll($addWhere);

	   	$addWhere['champ'][0] = 'published';
	   	$addWhere['value'][0] = '0';

	   	$newsNotPublished = $newsManager->count($addWhere);
	   	$testimoniesNotPublished = $testimonyManager->count($addWhere);

	   	$elements = [	'countPNReported' 			=> $countPNReported,
	   					'countPTReported' 			=> $countPTReported,
	   					'sentences' 				=> $sentences,
	   					'newsNotPublished' 			=> $newsNotPublished,
	   					'testimoniesNotPublished' 	=> $testimoniesNotPublished,
	   					'users' 					=> $users,
	   					'templateData' 				=> $this->templateData
	   				];
	   
	   	$myView = new View('admin/dashboard');
		$myView->render($elements);
	}

	public function showEditPage($params)
	{
		extract($params);

		$elements = [];

		if(isset($newsId))
		{
			$_SESSION['article'] = 'news';

			$newsManager = new NewsManager();
			$article = $newsManager->get($newsId);
		}
		else
		{
			$_SESSION['article'] = 'testimony';

			$testimonyManager = new TestimonyManager();
			$article = $testimonyManager->get($testimonyId);

			$categoryManager = new CategoryManager();
			$categories = $categoryManager->getAll();

			$elements['categories'] = $categories;
		}

		if($article->published() AND $_SESSION['rank'] < 5) {
			$_SESSION['errors'][] = 'Vous n\'avez pas les droits pour accéder à cette page';

            $myView = new View();
            $myView->redirect('403.html');
		}

		$userManager = new UserManager();
		$user = $userManager->get($article->authorId());

		$article->setArticleLink('Annuler', 'class="button"');

		$elements['article'] = $article;
		$elements['user'] = $user;
		$elements['templateData'] = $this->templateData;

		$myView = new View('admin/editArticle');
		$myView->render($elements);
	}
	
	public function showNewArticlePage($params)
	{
		$userManager = new UserManager();
		$user = $userManager->get($_SESSION['id']);

		$elements = ['user' => $user, 'templateData' => $this->templateData];

		$_SESSION['article'] = 'news';
		
		$myView = new View('admin/newArticle');
		$myView->render($elements);
	}

	public function showNotPublishedPage($params)
	{
		$page = str_replace('NotPublished.html', '', $_GET['r']);

		if($page === 'news')
		{
			$manager = new NewsManager();
			$allNews = true;
		}
		else
		{
			$manager = new TestimonyManager();
			$allNews = false;
		}

		$admin = true;

		$addWhere = ' WHERE published = 0 ';

		$articles = $manager->getAll($addWhere);

		$elements = ['allNews' => $allNews, 'articles' => $articles, 'admin' => $admin, 'templateData' => $this->templateData];

		$myView = new View('articles');
		$myView->render($elements);
	}
	
	public function showNewTestimonyPage($params)
	{
		$userManager = new UserManager();
		$user = $userManager->get($_SESSION['id']);

		$categoryManager = new CategoryManager();
		$categories = $categoryManager->getAll();

		$elements = ['categories' => $categories, 'user' => $user, 'templateData' => $this->templateData];

		$_SESSION['article'] = 'testimony';

		$myView = new View('admin/newArticle');
		$myView->render($elements);
	}	

	public function showReportedPostsPage($params)
	{
	   	$postNewsManager = new PostManager('postsnews');
	   	$postTestimonyManager = new PostManager('poststestimony');

	   	$postsNReported = $postNewsManager->getReported();
	   	$postsTReported = $postTestimonyManager->getReported();

	   	$elements = ['postsNReported' => $postsNReported, 'postsTReported' => $postsTReported, 'templateData' => $this->templateData];
	   
	   	$myView = new View('admin/reportedPosts');
		$myView->render($elements);
	}
}