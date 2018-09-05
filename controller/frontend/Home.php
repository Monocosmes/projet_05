<?php

namespace controller\frontend;

use \controller\Controller;
use \model\entity\Post;
use \model\ModerationManager;
use \model\PostManager;
use \model\NewsManager;
use \model\TestimonyManager;
use \model\UserManager;
use \classes\View;

class Home extends Controller
{
	public function addPost($params)
	{
		extract($params);

		if(isset($newsId))
		{
			$manager = '\model\NewsManager';
			$postManager = 'postsnews';
			$articleId = $newsId;			
		}
		else if(isset($testimonyId))
		{
			$manager = '\model\TestimonyManager';
			$postManager = 'poststestimony';
			$articleId = $testimonyId;
		}

		$post = new Post
		([
			'articleId' => $articleId,
			'authorId' => $authorId,
			'content' => $content
		]);

		$myView = new View();

		if($post->isValid($post->articleId()) AND $post->isValid($post->authorId()) AND $post->isValid($post->content()))
		{
			$articleManager = new $manager;
			$postArticleManager = new PostManager($postManager);
		
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
			$postManager = 'postsnews';
			$postId = str_replace('postId-', '', $newsPost);
		}
		else if(isset($testimonyPost))
		{
			$manager = '\model\TestimonyManager';
			$postManager = 'poststestimony';
			$postId = str_replace('post-', '', $testimonyPost);
		}

		$addWhere['champ'][] = 'id';
        $addWhere['value'][] = $postId;

		$myView = new View();

		$articleManager = new $manager;
		$postArticleManager = new PostManager($postManager);

		$post = $postArticleManager->get($postId);
		$postArticleManager->delete($addWhere);

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
			$postManager = 'postsnews';
			$articleId = $newsId;
		}
		else if(isset($testimonyId))
		{
			$manager = '\model\TestimonyManager';
			$postManager = 'poststestimony';
			$articleId = $testimonyId;
		}

		$post = new Post
		([
			'id' => $id,
			'articleId' => $articleId,
			'authorId' => $authorId,
			'content' => $content
		]);

		$myView = new View();

		if($post->isValid($post->id()) AND $post->isValid($post->articleId()) AND $post->isValid($post->authorId()) AND $post->isValid($post->content()))
		{
			$postArticleManager = new PostManager($postManager);
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
			$postManager = 'postsnews';
			$postId = $newsPostId;
		}
		else if(isset($testimonyPostId))
		{
			$postManager = 'poststestimony';
			$postId = $testimonyPostId;
		}

		$postArticleManager = new PostManager($postManager);
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
