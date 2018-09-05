<?php

namespace controller\backend;

use \controller\Controller;
use \model\entity\Moderation;
use \model\entity\News;
use \model\entity\Post;
use \model\entity\Testimony;
use \model\PostManager;
use \model\UserManager;
use \model\CategoryManager;
use \model\ModerationManager;
use \model\NewsManager;
use \model\TestimonyManager;
use \classes\View;
use \classes\Upload;

class Admin extends Controller
{	
	public function addModerationMessage($params)
	{
		extract($params);

		$moderation = new Moderation(['moderationMessage' => $moderationMessage]);

        if($moderation->isValid($moderation->moderationMessage()))
        {
            $moderationManager = new ModerationManager();
            
            if(!$sentenceId)
            {
            	$moderationManager->add($moderation);

            	$_SESSION['message'] = 'Nouveau message de modération ajouté avec succés';
            }
            else
            {
            	$moderation->setId($sentenceId);

            	$moderationManager->update($moderation);
            	$_SESSION['message'] = 'Message de modération modifié avec succés';
            }
        }
        
        $myView = new View();
        $myView->redirect('dashboard.html');
	}

	public function addNews($params)
	{
		extract($params);

		$news = new News
		([
			'authorId' => $authorId,
			'title' => $title,
			'content' => $content,
			'highlight' => (isset($highlight) AND isset($published)) ? $highlight : 0,
			'published' => $published
		]);

		$myView = new View();

		if($news->isValid($news->authorId()) AND $news->isValid($news->title()) AND $news->isValid($news->content()) AND $news->isValid($news->highlight()) AND $news->isValid($news->published()))
        {
        	$newsManager = new NewsManager();

        	if($news->highlight() AND $news->published())
        	{
        		$newsManager->resetHighlight();
        	}
        	elseif($news->highlight() AND !$news->published())
        	{
        		$_SESSION['errors'][] = 'Vous ne pouvez pas mettre en lumière un article que vous enregistrez';
        	}
            
            $newsId = $newsManager->addNews($news);

            $_SESSION['message'] = 'L\'article a bien été ajouté';

            $myView->redirect('news/newsId/'.$newsId);
        }
        else
        {
            $_SESSION['title'] = $title;
            $_SESSION['content'] = $content;            

            $myView->redirect('newArticle.html');
        }
	}

	public function addTestimony($params)
	{
		extract($params);

		$testimony = new Testimony
		([
			'categoryId' => $categoryId,
			'authorId' => $authorId,
			'title' => $title,
			'content' => $content,
			'published' => $published
		]);

		$myView = new View();

		if($testimony->isValid($testimony->categoryId()) AND $testimony->isValid($testimony->authorId()) AND $testimony->isValid($testimony->title()) AND $testimony->isValid($testimony->content()) AND $testimony->isValid($testimony->published()))
        {
        	$testimonyManager = new TestimonyManager();
        	$categoryManager = new CategoryManager();
            
            $testimonyId = $testimonyManager->addTestimony($testimony);

            $category = $categoryManager->get($categoryId);

            $_SESSION['message'] = 'Le témoignage a bien été ajouté à la catégorie '.$category->name();

            $myView->redirect('testimony/testimonyId/'.$testimonyId);
        }
        else
        {
            $_SESSION['title'] = $title;
            $_SESSION['content'] = $content;            

            $myView->redirect('newTestimony.html');
        }
	}

	

	public function deleteNews($params)
	{
		extract($params);

		$newsId = str_replace('news-', '', $newsId);

		$newsManager = new NewsManager();

		$newsManager->delete($newsId);

		$_SESSION['message'] = 'L\'article a bien été supprimé';

		$myView = new View();

		if(preg_match('#newsId#', $_SERVER['HTTP_REFERER']))
		{
			$myView->redirect('home.html');
		}
		else
		{
			$myView->redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function deleteTestimony($params)
	{
		extract($params);

		$testimonyId = str_replace('testimony-', '', $testimonyId);

		$testimonyManager = new TestimonyManager();

		$testimonyManager->delete($testimonyId);

		$_SESSION['message'] = 'Le témoignage a bien été supprimé';

		$myView = new View();

		if(preg_match('#testimonyId#', $_SERVER['HTTP_REFERER']))
		{
			$myView->redirect('home.html');
		}
		else
		{
			$myView->redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function editNews($params)
	{
		extract($params);

		$news = new News
		([
			'id' => $newsId,
			'authorId' => $authorId,
			'title' => $title,
			'content' => $content,
			'highlight' => isset($highlight) ? $highlight : 0,
			'published' => $published
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
            $_SESSION['title'] = $title;
            $_SESSION['content'] = $content;            

            $myView->redirect('editArticle/newsId/'.$news->id());
        }		
	}
	
	public function editTestimony($params)
	{
		extract($params);

		$testimony = new Testimony
		([
			'id' => $testimonyId,
			'authorId' => $authorId,
			'categoryId' => $categoryId,
			'title' => $title,
			'content' => $content,
			'published' => $published
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
            $_SESSION['title'] = $title;
            $_SESSION['content'] = $content;            

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

	public function moderatePost($params)
    {
        extract($params);

        $post = new Post
        ([
            'id' => $id,
            'articleId' => $articleId,
            'moderationId' => (int) $moderationId,
        ]);

        $myView = new View();

        if($post->isValid($post->id()) AND $post->isValid($post->articleId()) AND $post->isValid($post->moderationId()))
        {
            $postManager = new PostManager($dbName);
            $oldPost = $postManager->get($id);
            $oldPost->setModerationId($post->moderationId());
            $oldPost->setModerated(1);
            $oldPost->setReported(0);

            if($post->moderationId() == -1)
            {
                $oldPost->setModerated(0);
                $oldPost->setModerationId(0);
            }

            $postManager->editPost($oldPost);

            $myView->redirect($_SERVER['HTTP_REFERER'].'#post-'.$post->id());
        }
        else
        {            
            $myView->redirect($_SERVER['HTTP_REFERER']);
        }
    }

	public function unreportPost($params)
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
			$post->setReported(0);
			$postArticleManager->editPost($post);
		}
		else
		{
			$_SESSION['errors'][] = 'Ce commentaire n\'existe pas ou a été supprimé';
		}

		$myView->redirect($_SERVER['HTTP_REFERER'].'#post-'.$postId);
	}

	public function uploadImage($params)
	{
		$upload = new Upload();

		$upload->uploadImageArticle($params, 'articles');
	}
}
