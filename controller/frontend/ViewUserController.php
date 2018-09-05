<?php

namespace controller\frontend;

use \controller\Controller;
use \model\entity\ViewPM;
use \model\UserManager;
use \model\NewsManager;
use \model\TestimonyManager;
use \model\PostManager;
use \model\PrivateMessageManager;
use \model\AnswerPMManager;
use \model\ViewPMManager;
use \classes\View;

class ViewUserController extends Controller
{
    public function showEditProfilePage($params)
	{
        extract($params);

        if($userId == $_SESSION['id'] OR $_SESSION['rank'] > 3)
        {
            $userManager = new UserManager();
            $user = $userManager->get((int) $userId);

            $elements = ['user' => $user, 'templateData' => $this->templateData];
		
            $myView = new View('user/editProfile');
            $myView->render($elements);
        }
        else
        {
            $_SESSION['errors'][] = 'Vous n\'avez pas les droits pour accéder à cette page';

            $myView = new View();
            $myView->redirect('403.html');
        }
	}

	public function showInboxPage($params)
	{
		if($_SESSION['isLogged'] === session_id())
        {
            $privateMessageManager = new PrivateMessageManager();
            $answerPMManager = new AnswerPMManager();

            $lastPMs = [];

            $addWhere = ' WHERE (authorId = :userId AND authorIsOn = 1) OR (privatemessage.receiverId = :userId AND receiverIsOn = 1) ';

		    $messages = $privateMessageManager->getAll($_SESSION['id'], $addWhere);

            if($messages)
            {
                foreach($messages AS $message)
                {
                    $lastPMs[] = $answerPMManager->get($message->lastPMId());
                }
            }

		    $elements = ['messages' => $messages, 'lastPMs' => $lastPMs, 'templateData' => $this->templateData];

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
    	if($_SESSION['isLogged'] === session_id())
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

        if($user)
        {
            $elements = ['user' => $user, 'templateData' => $this->templateData];

            $myView = new View('user/profile');
            $myView->render($elements);
        }
        else
        {
            $_SESSION['errors'][] = 'Désolé, le profil que vous voulez voir n\'existe pas';

            $myView = new View();
            $myView->redirect('404.html');
        }		
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
}