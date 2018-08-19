<?php

namespace controller\frontend;

use \controller\Controller;
use \model\entity\PostArticle;
use \model\entity\PostTestimony;
use \model\PostsNewsManager;
use \model\PostsTestimonyManager;
use \model\NewsManager;
use \model\TestimonyManager;
use \classes\View;

class Home extends Controller
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

		$newsManager = new NewsManager();
		$postsNewsManager = new PostsNewsManager();
	
		$news = $newsManager->get($newsId);

		if($news)
		{
			$postsNews = $postsNewsManager->getAll($newsId);
	
			$addWhere = ' WHERE published = 1 ';
			$addLimit = 'LIMIT 0, 5';
		
			$allNews = $newsManager->getAll($addWhere, $addLimit);		
	
			$elements = ['article' => $news, 'allNews' => $allNews, 'news' => $news, 'posts' => $postsNews, 'templateData' => $this->templateData];
			
			$myView = new View('article');
			$myView->render($elements);
		}
		else
		{
			$_SESSION['errors'][] = 'L\'article que vous avez demandé n\'existe pas';

			$myView = new View();
			$myView->redirect($_SERVER['HTTP_REFERER'].$redirect);
		}
	}
	
	public function showAllArticlesPage($params)
	{
		$newsManager = new NewsManager();
	
		$allNews = $newsManager->getAll();
	
		$elements = ['allNews' => $allNews, 'articles' => $allNews, 'templateData' => $this->templateData];

		$myView = new View('articles');
		$myView->render($elements);
	}
	
	public function showTestimoniesPage($params)
	{
		$testimonyManager = new TestimonyManager();
	
		$testimonies = $testimonyManager->getAll();

		$elements = ['testimonies' => $testimonies, 'articles' => $testimonies, 'templateData' => $this->templateData];
	
		$myView = new View('articles');
		$myView->render($elements);
	}
	
	public function showTestimonyPage($params)
	{
		extract($params);

		$testimonyManager = new TestimonyManager();
		$postsTestimonyManager = new PostsTestimonyManager();
	
		$testimony = $testimonyManager->get($testimonyId);

		if($testimony)
		{
			$postsTestimonies = $postsTestimonyManager->getAll($testimonyId);

			$elements = ['article' => $testimony, 'posts' => $postsTestimonies, 'templateData' => $this->templateData];
	
			$myView = new View('article');
			$myView->render($elements);
		}
		else
		{
			$_SESSION['errors'][] = 'Le témoignage que vous avez demandé n\'existe pas';

			$myView = new View();
			$myView->redirect($_SERVER['HTTP_REFERER'].$redirect);
		}
	}

	public function show404Page($params)
	{
		$elements = ['templateData' => $this->templateData];
	
		$myView = new View('404');
		$myView->render($elements);
	}
	
	public function addPost($params)
	{
		extract($params);

		if(isset($newsId))
		{
			$manager = '\model\NewsManager';
			$postManager = '\model\PostsNewsManager';
			$articleId = $newsId;			
		}
		else if(isset($testimonyId))
		{
			$manager = '\model\TestimonyManager';
			$postManager = '\model\PostsTestimonyManager';
			$articleId = $testimonyId;
		}

		$post = new PostArticle
		([
			'articleId' => $articleId,
			'authorId' => $authorId,
			'content' => $content
		]);

		$myView = new View();

		if($post->isValid($post->articleId()) AND $post->isValid($post->authorId()) AND $post->isValid($post->content()))
		{
			$articleManager = new $manager;
			$postArticleManager = new $postManager;
		
			$postId = $postArticleManager->addPost($post);

			$article = $articleManager->get($articleId);
			$article->changeCommentCount(1);
			$articleManager->updateCommentCount($article);

			$redirect = '#post-'.$postId;
		}
		else
		{
			$_SESSION['content'] = $post->content();
			$redirect = null;
		}

		$myView->redirect($_SERVER['HTTP_REFERER'].$redirect);
	}

	public function deletePost($params)
	{
		extract($params);

		if(isset($newsPost))
		{
			$manager = '\model\NewsManager';
			$postManager = '\model\PostsNewsManager';
			$postId = str_replace('postId-', '', $newsPost);
		}
		else if(isset($testimonyPost))
		{
			$manager = '\model\TestimonyManager';
			$postManager = '\model\PostsTestimonyManager';
			$postId = str_replace('post-', '', $testimonyPost);
		}

		$myView = new View();

		$articleManager = new $manager;
		$postArticleManager = new $postManager;

		$post = $postArticleManager->get($postId);
		$postArticleManager->delete($postId);

		$article = $articleManager->get($post->articleId());
		$article->changeCommentCount(-1);
		$articleManager->updateCommentCount($article);

		$_SESSION['message'] = 'Le commentaire a bien été supprimé';

		$myView->redirect($_SERVER['HTTP_REFERER']);
	}

	public function editPost($params)
	{
		extract($params);

		if(isset($newsId))
		{
			$manager = '\model\NewsManager';
			$postManager = '\model\PostsNewsManager';
			$articleId = $newsId;
		}
		else if(isset($testimonyId))
		{
			$manager = '\model\TestimonyManager';
			$postManager = '\model\PostsTestimonyManager';
			$articleId = $testimonyId;
		}

		$post = new PostArticle
		([
			'id' => $id,
			'articleId' => $articleId,
			'authorId' => $authorId,
			'content' => $content
		]);

		$myView = new View();

		if($post->isValid($post->id()) AND $post->isValid($post->articleId()) AND $post->isValid($post->authorId()) AND $post->isValid($post->content()))
		{
			$postArticleManager = new $postManager();
			$oldPost = $postArticleManager->get($id);

			$oldPost->setContent($post->content());
			$oldPost->setEdited(1);

			$postArticleManager->editPost($oldPost);

			$redirect = '#post-'.$post->id();

			$_SESSION['message'] = 'Le commentaire a bien été modifié';
		}
		else
		{
			$_SESSION['content'] = $post->content();
			$redirect = null;
		}

		$myView->redirect($_SERVER['HTTP_REFERER'].$redirect);
	}

	public function reportPost($params)
	{
		extract($params);

		if(isset($newsPostId))
		{
			$postManager = '\model\PostsNewsManager';
			$postId = $newsPostId;
		}
		else if(isset($testimonyPostId))
		{
			$postManager = '\model\PostsTestimonyManager';
			$postId = $testimonyPostId;
		}

		$postArticleManager = new $postManager;
		$post = $postArticleManager->get($postId);

		$myView = new View();

		if($post)
		{
			$post->setReported(1);
			$postArticleManager->editPost($post);
		}
		else
		{
			$_SESSION['errors'][] = 'Ce commentaire n\'existe pas ou a été supprimé';
		}
		
		$myView->redirect($_SERVER['HTTP_REFERER'].'#post-'.$postId);
	}
}
