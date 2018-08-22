<?php

namespace controller\backend;

use \controller\Controller;
use \model\entity\News;
use \model\entity\Post;
use \model\entity\Testimony;
use \model\PostManager;
use \model\UserManager;
use \model\CategoryManager;
use \model\NewsManager;
use \model\TestimonyManager;
use \classes\View;

class Admin extends Controller
{
	public function showDashboardPage($params)
	{
	   	if($_SESSION['rank'] < 4 || $_SESSION['id'] === 0){$myView = new View(); $myView->redirect('home.html');}

	   	$addWhere = ' WHERE reported = 1';

	   	$postNewsManager = new PostManager('postsnews');
	   	$postTestimonyManager = new PostManager('poststestimony');

	   	$countPNReported = $postNewsManager->count($addWhere);
	   	$countPTReported = $postTestimonyManager->count($addWhere);

	   	$addWhere = ' WHERE askVerification = 1';

	   	$userManager = new UserManager();
	   	$users = $userManager->getAll($addWhere);

	   	$elements = ['countPNReported' => $countPNReported, 'countPTReported' => $countPTReported, 'users' => $users, 'templateData' => $this->templateData];
	   
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
	
	public function addModerationMessage($params)
	{
		$moderation = new Moderation(['moderationMessage' => $moderationMessage]);

        if($moderation->isValid($moderation->moderationMessage()))
        {
            $moderationManager = new ModerationManager();
            $moderationManager->add($moderation);
    
            $_SESSION['message'] = 'Nouveau message de modération ajouté avec succés';    
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
			'highlight' => isset($highlight) ? $highlight : 0,
			'published' => $published
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

            $myView->redirect('newArticle.html');
        }
	}

	public function changeRank($params)
	{
		extract($params);

		$userManager = new UserManager();
		$myView = new View();

		if((isset($logins) OR isset($login)) AND isset($rank))
		{
			if(isset($logins))
			{
				foreach($logins AS $login)
				{
					if($userManager->exists($login))
					{
						$user = $userManager->get($login);
						$user->setRank($rank);
						$user->setAskVerification(0);
	
						$userManager->update($user);
					}
					else
					{
						$_SESSION['errors'][] = 'L\'utilisateur '.$login.' n\'existe pas ou a été supprimé';
					}
				}
			}
			else
			{
				if($userManager->exists($login))
				{
					$login = strtoupper($login);

					if($login === 'ADMIN' OR $login === 'CFDT' OR $rank >= $_SESSION['rank'])
					{
						$_SESSION['errors'][] = 'Vous n\'avez pas les droits pour changer le rang du compte '.$login;
					}
					else
					{
						$user = $userManager->get($login);						
						
						if($rank > '2')
						{
							$user->setAskVerification(0);
						}
						elseif($rank === '0')
						{
							$user->setAccountLocked(1);
						}
						elseif($rank === '1')
						{
							$user->setAccountLocked(0);
						}
						
						($rank > 1) ? $user->setRank($rank) : '';

						$userManager->update($user);
					}
				}
				else
				{
					$_SESSION['errors'][] = 'L\'utilisateur '.$login.' n\'existe pas ou a été supprimé';
				}
			}
		}
		else
		{
			$_SESSION['errors'][] = 'Un ou plusieurs champs sont manquants';
		}

		if(!isset($_SESSION['errors']))
		{
			$_SESSION['message'] = 'Le changement de rang a bien été effectué';
		}

		$myView->redirect('dashboard.html');
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

	public function deleteNews($params)
	{
		extract($params);

		$newsId = str_replace('news-', '', $newsId);

		$newsManager = new NewsManager();

		$newsManager->delete($newsId);

		$_SESSION['message'] = 'L\'article a bien été supprimé';

		$myView = new View();
		$myView->redirect($_SERVER['HTTP_REFERER']);
	}

	public function deleteTestimony($params)
	{
		extract($params);

		$testimonyId = str_replace('testimony-', '', $testimonyId);

		$testimonyManager = new TestimonyManager();

		$testimonyManager->delete($testimonyId);

		$_SESSION['message'] = 'Le témoignage a bien été supprimé';

		$myView = new View();
		$myView->redirect($_SERVER['HTTP_REFERER']);
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
}
