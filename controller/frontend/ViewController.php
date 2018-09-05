<?php

namespace controller\frontend;

use \controller\Controller;
use \model\ModerationManager;
use \model\PostManager;
use \model\NewsManager;
use \model\CategoryManager;
use \model\TestimonyManager;
use \model\UserManager;
use \classes\View;

class ViewController extends Controller
{
    public function showHomePage($params)
	{	
	   	$newsManager = new NewsManager();
	   	$testimonyManager = new TestimonyManager();
	
	   	$news = $newsManager->getHighlight();
	   	$testimony = $testimonyManager->getLast();

	   	$news->setArticleLink($news->title());

	   	if($testimony) {$testimony->setArticleLink($testimony->title());}
	
	   	$addWhere = ' WHERE published = 1 AND highlight = 0 ';
	   	$addLimit = ' LIMIT 0, 4';	
	   	$allNews = $newsManager->getAll($addWhere, $addLimit);
	
	   	$elements = ['news' => $news, 'allNews' => $allNews, 'testimony' => $testimony, 'templateData' => $this->templateData];

	   	$myView = new View('home');
		$myView->render($elements);
	}

	public function showArticlePage($params)
	{
		extract($params);

		if(preg_match('#news#', $_GET['r']))
		{
			$manager = new NewsManager();
			$postsManager = new PostManager('postsnews');

			$articleId = $newsId;
			$news = true;
		}
		elseif(preg_match('#testimony#', $_GET['r']))
		{
			$manager = new TestimonyManager();
			$postsManager = new PostManager('poststestimony');

			$articleId = $testimonyId;
			$news = false;
		}
	
		$article = $manager->get($articleId);

		if($article)
		{
			$moderationManager = new ModerationManager();
			$moderations = $moderationManager->getAll();

			$addWhere['champ'][] = 'articleId';
			$addWhere['value'][] = $articleId;

			$postsNews = $postsManager->getAll($addWhere);
	
			$elements = ['article' => $article, 'news' => $news, 'posts' => $postsNews, 'moderations' => $moderations, 'templateData' => $this->templateData];
			
			$myView = new View('article');
			$myView->render($elements);
		}
		else
		{
			$_SESSION['errors'][] = (preg_match('#news#', $_GET['r'])) ? 'L\'article que vous avez demandé n\'existe pas' : 'Le témoignage que vous avez demandé n\'existe pas';

			$myView = new View();
			$myView->redirect('404.html');
		}
	}
	
	public function showArticlesPage($params)
	{
		$page = str_replace('.html', '', $_GET['r']);

		if($page === 'allNews')
		{
			$manager = new NewsManager();
			$allNews = true;
			$categories = null;
		}
		else
		{
			$categoryManager = new CategoryManager();
			$manager = new TestimonyManager();
			$allNews = false;
			$categories = $categoryManager->getAll();
		}
	
		$articles = $manager->getAll();
	
		$elements = ['allNews' => $allNews, 'articles' => $articles, 'categories' => $categories, 'templateData' => $this->templateData];

		$myView = new View('articles');
		$myView->render($elements);
	}

	public function showContactPage($params)
	{
		$addWhere['champ'][] = 'onContact';
		$addWhere['value'][] = 1;

		$userManager = new UserManager();
		$users = $userManager->getAll($addWhere);

		$elements = ['users' => $users, 'templateData' => $this->templateData];

		$myView = new View('contact');
		$myView->render($elements);
	}

	public function showRolesPage($params)
	{
		$elements = ['templateData' => $this->templateData];

		$myView = new View('roles');
		$myView->render($elements);
	}

	public function showSearchPage($params)
	{
		if(!empty($_GET['search']))
		{
			$search = '%'.htmlspecialchars($_GET['search']).'%';
	
			$newsManager = new NewsManager();
			$testimonyManager = new TestimonyManager();
	
			$results = $newsManager->search($search);
			$resultsT = $testimonyManager->search($search);

			foreach($resultsT AS $resultT)
			{
				$results[] = $resultT;
			}
	
			$elements = ['results' => $results, 'templateData' => $this->templateData];
	
			$myView = new View('search');
			$myView->render($elements);
		}
		else
		{
			$_SESSION['errors'][] = 'Vous devez entrer un terme à rechercher';

			$myView = new View();
			$myView->redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function show404Page($params)
	{
		$elements = ['templateData' => $this->templateData];
	
		$myView = new View('404');
		$myView->render($elements);
	}
}