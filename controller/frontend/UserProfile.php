<?php

namespace controller\frontend;

use \controller\Controller;
use \model\entity\User;
use \model\entity\PrivateMessage;
use \model\entity\AnswerPM;
use \model\entity\ViewPM;
use \model\UserManager;
use \model\PrivateMessageManager;
use \model\AnswerPMManager;
use \model\ViewPMManager;
use \classes\View;

class UserProfile extends Controller
{
    public function showEditProfile($params)
	{
		
	}

	public function showInboxPage($params)
	{
		if($_SESSION['isLogged'])
        {
            $privateMessageManager = new PrivateMessageManager();
		    $messages = $privateMessageManager->getAll($_SESSION['id']);

		    $elements = ['messages' => $messages, 'templateData' => $this->templateData];

		    $myView = new View('user/inbox');
    	    $myView->render($elements);
        }
        else
        {
            $_SESSION['errors'][] = 'Vous devez être connecté pour accéder à cette page';

            $myView = new View();
            $myView->redirect('home.html');
        }
	}

    public function showNewMessagePage($params)
    {
    	if($_SESSION['isLogged'])
        {
           $elements = ['templateData' => $this->templateData];
    
    	   if(!empty($params))
    	   {
    	   	extract($params);
    
    	   	$userManager = new UserManager();
    	   	$user = $userManager->get((int) $userId);
    
    	   	$_SESSION['addressee'] = $user->login();
    
    	   	$elements = ['templateData' => $this->templateData];
    	   }
    
    	   $myView = new View('user/message');
    	   $myView->render($elements);
        }
        else
        {
            $_SESSION['errors'][] = 'Vous devez être connecté pour accéder à cette page';

            $myView = new View();
            $myView->redirect('home.html');
        }
    }

    public function showPrivateMessagePage($params)
    {
    	extract($params);

    	$privateMessageManager = new PrivateMessageManager();
    	$answerPMManager = new AnswerPMManager();
    	$viewPMManager = new ViewPMManager();

    	$privateMessage = $privateMessageManager->get($pmId);

        if($privateMessage->authorId() == $_SESSION['id'] OR $privateMessage->receiverId() == $_SESSION['id'])
        {
    	   $answers = $answerPMManager->getAll($pmId);
    
            $viewPM = new ViewPM
            ([
                'receiverId' => $_SESSION['id'],
                'titleId' => $privateMessage->id(),
                'lastPMView' => $privateMessage->lastPMId(),
            ]);
    
    	   $viewPMManager->isRead($viewPM);
    
    	   $elements = ['privateMessage' => $privateMessage, 'answers' => $answers, 'templateData' => $this->templateData];
    
    	   $myView = new View('user/privateMessage');
    	   $myView->render($elements);
        }
        else
        {
            $_SESSION['errors'][] = 'Vous n\'avez pas les droits pour accéder à cette page';

            $myView = new View();
            $myView->redirect('403.html');
        }
    }

	public function showProfilePage($params)
	{
		extract($params);

		$userManager = new UserManager();
		$user = $userManager->get((int) $userId);

		$elements = ['user' => $user, 'templateData' => $this->templateData];

		$myView = new View('user/profile');
		$myView->render($elements);
	}

    public function showProfileSettingsPage($params)
    {
        extract($params);

        if($userId == $_SESSION['id'])
        {
            $userManager = new UserManager();
            $user = $userManager->get((int) $userId);
    
            $elements = ['user' => $user, 'templateData' => $this->templateData];
    
            $myView = new View('user/profileSettings');
            $myView->render($elements);
        }
        else
        {
            $_SESSION['errors'][] = 'Vous n\'avez pas les droits pour accéder à cette page';

            $myView = new View();
            $myView->redirect('403.html');
        }
    }

    public function addNewMessage($params)
    {
    	extract($params);

    	$myView = new View();

    	$userManager = new UserManager();

    	$_SESSION['addressee'] = $addressee;
    	$_SESSION['title'] = $title;
    	$_SESSION['content'] = $content;

    	if($userManager->exists($addressee))
    	{
    		if($addressee != $_SESSION['login'])
    		{
    			$user = $userManager->get($addressee);
	
    			$privateMessage = new PrivateMessage
    			([
    				'authorId' => $authorId,
    				'receiverId' => $user->id(),
    				'title' => $title,
    				'messageCount' => 1
    			]);
	
    			$answerPM = new AnswerPM
    			([
    				'authorId' => $authorId,
    				'content' => $content
    			]);
	
    			if($privateMessage->isValid($privateMessage->authorId()) AND $privateMessage->isValid($privateMessage->receiverId()) AND $privateMessage->isValid($privateMessage->title()) AND	 $answerPM->isValid($answerPM->content()))
    			{
    				$privateMessageManager = new PrivateMessageManager();
    				$answerPMManager = new AnswerPMManager();
    				$viewPMManager = new ViewPMManager();
	
    				$privateMessageId = $privateMessageManager->add($privateMessage);
    				$answerPM->setPrivateMessageId($privateMessageId);
	
    				$answerId = $answerPMManager->add($answerPM);

    				$privateMessage->setId($privateMessageId);
    				$privateMessage->setLastPMId($answerId);

    				$privateMessageManager->update($privateMessage);

    				$viewPMSender = new ViewPM
    				([
    					'receiverId' => $_SESSION['id'],
    					'titleId' => $privateMessageId,
    					'contentId' => $answerId,
    					'lastPMView' => $answerId,
    					'isRead' => 1
    				]);

    				$viewPMReceiver = new ViewPM
    				([
    					'receiverId' => $user->id(),
    					'titleId' => $privateMessageId,
    					'contentId' => $answerId,
    					'lastPMView' => 0,
    					'isRead' => (int) 0
    				]);

    				$viewPMManager->add($viewPMSender);
    				$viewPMManager->add($viewPMReceiver);
	
    				$myView->redirect('privateMessage/pmId/'.$privateMessageId);
    			}
    		}
    		else
    		{
    			$_SESSION['errors'][] = 'Vous ne pouvez pas vous envoyez de message privé à vous-même';

    			$myView->redirect('newMessage');
    		}
    	}
    	else
    	{
    		$_SESSION['errors'][] = 'Le destinataire demandé n\'existe pas. Vérifiez l\'orthographe et recommencez';

    		$myView->redirect('newMessage');
    	}
    }

    public function answerPrivateMessage($params)
    {
    	extract($params);

        $myView = new View();

        $answerPM = new AnswerPM
        ([
            'privateMessageId' => $pmId,
            'authorId' => $authorId,
            'content' => $content
        ]);

        $viewPM = new ViewPM (['receiverId' => $addresseeId]);

        if($answerPM->isValid($answerPM->content()) AND $answerPM->isValid($answerPM->authorId()) AND $answerPM->isValid($answerPM->privateMessageId()) AND $viewPM->isValid($viewPM->receiverId()))
        {
            $privateMessageManager = new PrivateMessageManager();
            $privateMessage = $privateMessageManager->get($pmId);

            $viewPM->setContentId($privateMessage->lastPMId());
            $viewPM->setTitleId($pmId);

            $answerPMManager = new AnswerPMManager();
            $answerId = $answerPMManager->add($answerPM);

            $viewPMManager = new ViewPMManager();

            $viewPMReceiver = $viewPMManager->get($viewPM);
            $viewPMReceiver->setIsRead(0);
            $viewPMReceiver->setContentId($answerId);
    
            $viewPMSender = new ViewPM
            ([
                'receiverId' => $_SESSION['id'],
                'contentId' => $answerId,
                'titleId' => $pmId,
                'lastPMView' => $answerId,
                'isRead' => 1,
            ]);

            $viewPMManager->add($viewPMReceiver);
            $viewPMManager->add($viewPMSender);

            $privateMessage->changeMessageCount(1);
            $privateMessage->setLastPMId($answerId);

            $privateMessageManager->update($privateMessage);
    
            $myView->redirect('privateMessage/pmId/'.$pmId.'#'.$answerId);
        }
        else
        {
            $myView->redirect($_SERVER['HTTP_REFERER']);
        }        
    }

    public function saveSettings($params)
    {
        extract($params);

        $myView = new View();

        $user = new User
        ([
            'id' => $userId,
            'seeEmail' => $seeEmail,
            'seePhoneNumber' => $seePhoneNumber,
            'seeName' => $seeName,
            'seeLastName' => $seeLastName
        ]);

        if($user->isValid($user->seeEmail()) AND $user->isValid($user->seePhoneNumber()) AND $user->isValid($user->seeName()) AND $user->isValid($user->seeLastName()))
        {
            $userManager = new UserManager();
            $userManager->updateSettings($user);

            $myView->redirect(HOST.'profile/userId/'.$userId);
        }
        else
        {
            $myView->redirect(HOST.'profileSettings/userId/'.$userId);
        }

    }
}