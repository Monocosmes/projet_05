<?php

class Admin extends Controller
{
	public function showDashboardPage($params)
	{
	   	if($_SESSION['rank'] < 4 || $_SESSION['id'] === 0){$myView = new View(); $myView->redirect('home.html');}

	   	$newsManager = new NewsManager();
	
	   	$news = $newsManager->getHighlight();	
	
	   	$allNews = $newsManager->getAll();

	   	$elements = ['news' => $news, 'allNews' => $allNews, 'footer' => $this->footer];
	   
	   	$myView = new View('admin/dashboard');
		$myView->render($elements);
	}
	
	public function showNewArticlePage($params)
	{
		$userManager = new UserManager();
		$user = $userManager->get($_SESSION['id']);

		$elements = ['user' => $user, 'footer' => $this->footer];

		$_SESSION['article'] = 'news';

		$myView = new View('admin/newArticle');
		$myView->render($elements);
	}
	
	public function showNewTestimonyPage($params)
	{
		$userManager = new UserManager();
		$user = $userManager->get($_SESSION['id']);

		$categoryManager = new CategoryManager();
		$categories = $categoryManager->getAll();

		$elements = ['categories' => $categories, 'user' => $user, 'footer' => $this->footer];

		$_SESSION['article'] = 'testimony';

		$myView = new View('admin/newArticle');
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

		$userManager = new UserManager();
		$user = $userManager->get($article->authorId());

		$article->setArticleLink('Annuler', 'class="buttons"');

		$elements['article'] = $article;
		$elements['user'] = $user;
		$elements['footer'] = $this->footer;

		$myView = new View('admin/editArticle');
		$myView->render($elements);
	}
	
	public function addNews($params)
	{
		$news = new News
		([
			'authorId' => $_POST['authorId'],
			'title' => $_POST['title'],
			'content' => $_POST['content'],
			'highlight' => isset($_POST['highlight'])?$_POST['highlight']:0,
			'published' => $_POST['published']
		]);

		$myView = new View();

		if($news->isValid($news->authorId()) AND $news->isValid($news->title()) AND $news->isValid($news->content()) AND $news->isValid($news->highlight()) AND $news->isValid($news->published()))
        {
        	$newsManager = new NewsManager();

        	if($news->highlight())
        	{
        		$newsManager->resetHighlight();
        	}
            
            $newsId = $newsManager->addNews($news);

            $_SESSION['message'] = 'L\'article a bien été ajouté';

            $myView->redirect('news/newsId/'.$newsId);
        }
        else
        {
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['content'] = $_POST['content'];            

            $myView->redirect('newArticle.html');
        }
	}

	public function addTestimony($params)
	{
		$testimony = new Testimony
		([
			'categoryId' => $_POST['categoryId'],
			'authorId' => $_POST['authorId'],
			'title' => $_POST['title'],
			'content' => $_POST['content'],
			'published' => $_POST['published']
		]);

		$myView = new View();

		if($testimony->isValid($testimony->categoryId()) AND $testimony->isValid($testimony->authorId()) AND $testimony->isValid($testimony->title()) AND $testimony->isValid($testimony->content()) AND $testimony->isValid($testimony->published()))
        {
        	$testimonyManager = new TestimonyManager();
        	$categoryManager = new CategoryManager();
            
            $testimonyId = $testimonyManager->addTestimony($testimony);

            $category = $categoryManager->get($_POST['categoryId']);

            $_SESSION['message'] = 'Le témoignage a bien été ajouté à la catégorie '.$category->name();

            $myView->redirect('testimony/testimonyId/'.$testimonyId);
        }
        else
        {
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['content'] = $_POST['content'];            

            $myView->redirect('newArticle.html');
        }
	}

	public function editNews($params)
	{
		extract($params);

		$news = new News
		([
			'id' => $newsId,
			'authorId' => $_POST['authorId'],
			'title' => $_POST['title'],
			'content' => $_POST['content'],
			'highlight' => isset($_POST['highlight'])?$_POST['highlight']:0,
			'published' => $_POST['published']
		]);

		$myView = new View();

		if($news->isValid($news->id()) AND $news->isValid($news->authorId()) AND $news->isValid($news->title()) AND $news->isValid($news->content()) AND $news->isValid($news->highlight()) AND $news->isValid($news->published()))
        {
        	$newsManager = new NewsManager();

        	if($news->highlight())
        	{
        		$newsManager->resetHighlight();
        	}
            
            $newsManager->editNews($news);

            $_SESSION['message'] = 'L\'article a bien été modifié';

            $myView->redirect('news/newsId/'.$news->id());
        }
        else
        {
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['content'] = $_POST['content'];            

            $myView->redirect('editArticle/newsId/'.$news->id());
        }		
	}
	
	public function editTestimony($params)
	{
		extract($params);

		$testimony = new Testimony
		([
			'id' => $testimonyId,
			'authorId' => $_POST['authorId'],
			'categoryId' => $_POST['categoryId'],
			'title' => $_POST['title'],
			'content' => $_POST['content'],
			'published' => $_POST['published']
		]);

		$myView = new View();

		if($testimony->isValid($testimony->id()) AND $testimony->isValid($testimony->authorId()) AND $testimony->isValid($testimony->categoryId()) AND $testimony->isValid($testimony->title()) AND $testimony->isValid($testimony->content()) AND $testimony->isValid($testimony->published()))
        {
        	$testimonyManager = new TestimonyManager();
            
            $testimonyManager->editTestimony($testimony);

            $_SESSION['message'] = 'L\'article a bien été modifié';

            $myView->redirect('testimony/testimonyId/'.$testimony->id());
        }
        else
        {
            $_SESSION['title'] = $_POST['title'];
            $_SESSION['content'] = $_POST['content'];            

            $myView->redirect('editArticle/testimonyId/'.$testimony->id());
        }
	}
	
	public function publishArticle($params)
	{
		extract($params);

		$myView = new View();

		if(isset($newsId))
		{
			$newsManager = new NewsManager();
			$newsManager->publish($newsId, $publish);
		}
		else
		{
			$testimonyManager = new TestimonyManager();
			$testimonyManager->publish($testimonyId, $publish);			
		}

		$myView->redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function highlightNews($params)
	{
		extract($params);

		$newsManager = new NewsManager();	
		$newsManager->resetHighlight();	
		$newsManager->updateHighlight($newsId);
	
		$myView = new View();
		$myView->redirect($_SERVER['HTTP_REFERER']);
	}
}