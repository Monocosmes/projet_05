<?php

/**
 * summary
 */
class Home extends Controller
{
	public function showHomePage($params)
	{	
	   	$newsManager = new NewsManager();
	   	$testimonyManager = new TestimonyManager();
	
	   	$news = $newsManager->getHighlight();
	   	$testimony = $testimonyManager->getLast();

	   	$news->setArticleLink($news->title());
	   	$testimony->setArticleLink($testimony->title());
	
	   	$addWhere = ' WHERE published = 1 AND highlight = 0 ';
	   	$addLimit = ' LIMIT 0, 4';	
	   	$allNews = $newsManager->getAll($addWhere, $addLimit);	   	
	
	   	$elements = ['news' => $news, 'allNews' => $allNews, 'testimony' => $testimony, 'footer' => $this->footer];
	   
	   	$myView = new View('home');
		$myView->render($elements);
	}
	
	public function showArticlePage($params)
	{
		extract($params);

		$newsManager = new NewsManager();
		$postsManager = new PostsManager();
	
		$news = $newsManager->get($newsId);
		$posts = $postsManager->getAll($newsId);

		$addWhere = ' WHERE published = 1 ';
		$addLimit = 'LIMIT 0, 5';
	
		$allNews = $newsManager->getAll($addWhere, $addLimit);		

		$elements = ['article' => $news, 'allNews' => $allNews, 'news' => $news, 'posts' => $posts, 'footer' => $this->footer];
	
		$myView = new View('article');
		$myView->render($elements);
	}
	
	public function showAllArticlesPage($params)
	{
		$newsManager = new NewsManager();
	
		$allNews = $newsManager->getAll();
	
		$elements = ['allNews' => $allNews, 'articles' => $allNews, 'footer' => $this->footer];

		$myView = new View('articles');
		$myView->render($elements);
	}
	
	public function showTestimoniesPage($params)
	{
		$testimonyManager = new TestimonyManager();
	
		$testimonies = $testimonyManager->getAll();

		$elements = ['testimonies' => $testimonies, 'articles' => $testimonies, 'footer' => $this->footer];
	
		$myView = new View('articles');
		$myView->render($elements);
	}
	
	public function showTestimonyPage($params)
	{
		extract($params);

		$testimonyManager = new TestimonyManager();
	
		$testimony = $testimonyManager->get($testimonyId);
	
		$elements = ['article' => $testimony, 'footer' => $this->footer];
	
		$myView = new View('article');
		$myView->render($elements);
	}

	public function show404Page($params)
	{
		$elements = ['footer' => $this->footer];
	
		$myView = new View('404');
		$myView->render($elements);
	}
	
	public function addPost($params)
	{
		extract($params);

		$post = new Post
		([
			'newsId' => $newsId,
			'authorId' => $_POST['authorId'],
			'content' => $_POST['content']
		]);

		$myView = new View();

		if($post->isValid($post->newsId()) AND $post->isValid($post->authorId()) AND $post->isValid($post->content()))
		{
			$newsManager = new NewsManager();
			$postsManager = new PostsManager();
		
			$postId = $postsManager->addPost($post);
			$newsManager->updateCommentNumber($newsId);

			$redirect = '#post-'.$postId;
		}
		else
		{
			$_SESSION['content'] = $post->content();
			$redirect = null;
		}

		$myView->redirect($_SERVER['HTTP_REFERER'].$redirect);
	}

	public function editPost($params)
	{
		extract($params);

		$post = new Post
		([
			'id' => $_POST['id'],
			'newsId' => $_POST['newsId'],
			'authorId' => $_POST['authorId'],
			'content' => $_POST['content']
		]);

		$myView = new View();

		if($post->isValid($post->id()) AND $post->isValid($post->newsId()) AND $post->isValid($post->authorId()) AND $post->isValid($post->content()))
		{
			$postsManager = new PostsManager();
		
			$postId = $postsManager->editPost($post);

			$redirect = '#post-'.$postId;

			$_SESSION['message'] = 'Le commentaire a bien été modifié';
		}
		else
		{
			$_SESSION['content'] = $post->content();
			$redirect = null;
		}

		$myView->redirect($_SERVER['HTTP_REFERER'].$redirect);
	}
}
