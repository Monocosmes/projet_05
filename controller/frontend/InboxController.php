<?php 

namespace controller\frontend;

use \controller\Controller;
use \model\entity\PrivateMessage;
use \model\entity\AnswerPM;
use \model\entity\ViewPM;
use \model\UserManager;
use \model\PrivateMessageManager;
use \model\AnswerPMManager;
use \model\ViewPMManager;
use \classes\View;

class InboxController extends Controller
{
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
    				'messageCount' => 1,
                    'authorIsOn' => 1,
                    'receiverIsOn' => 1
    			]);
	
    			$answerPM = new AnswerPM
    			([
    				'authorId' => $authorId,
    				'content' => $content
    			]);
	
    			if($privateMessage->isValid($privateMessage->authorId()) AND $privateMessage->isValid($privateMessage->receiverId()) AND $privateMessage->isValid($privateMessage->title()) AND	 $answerPM->isValid($answerPM->content()))
    			{
    				$params =
                    [
                        'privateMessage' => $privateMessage,
                        'answerPM' => $answerPM
                    ];

                    $data = $this->sendPrivateMessage($params);

                    extract($data);

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
    					'lastPMView' => (int) 0,
    					'isRead' => (int) 0
    				]);

                    $viewPMManager = new ViewPMManager();

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

        $userManager = new UserManager();

        if(!$userManager->exists((int) $addresseeId))
        {
            $_SESSION['errors'][] = 'L\'envoie a été annulé car le compte de votre correspondant n\'existe pas';

            $myView->redirect($_SERVER['HTTP_REFERER']);
        }

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

            $viewPMReceiver = $viewPMManager->getLastPMView($viewPM);
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

    public function deleteMessage($params)
    {
        extract($params);

        $messageId = str_replace('message-', '', $messageId);

        $privateMessageManager = new PrivateMessageManager();
        $answerPMManager = new AnswerPMManager();
        $viewPMManager = new ViewPMManager();

        $myView = new View();

        $answer = $answerPMManager->get($messageId);

        if($answer)
        {
            $privateMessage = $privateMessageManager->get($answer->privateMessageId());

            $viewPM = $viewPMManager->get($_SESSION['id'], $answer->id());

            $addWhereA['champ'][] = 'id';
            $addWhereA['value'][] = $messageId;

            $answerPMManager->delete($addWhereA);

            $addWhereV['champ'][] = 'receiverId';
            $addWhereV['value'][] = $_SESSION['id'];
            $addWhereV['champ'][] = 'contentId';
            $addWhereV['value'][] = $messageId;

            $viewPMManager->delete($addWhereV, 'AND');

            $privateMessage->changeMessageCount(-1);
            $privateMessageManager->update($privateMessage);

            $_SESSION['message'] = 'Votre message a bien été effacé';
        }
        else
        {
            $_SESSION['errors'][] = 'Le message que vous voulez effacer n\'existe pas';
        }

        $myView->redirect($_SERVER['HTTP_REFERER']);
    }

    public function editMessage($params)
    {
        extract($params);

        $messageId = str_replace('message-', '', $id);

        $answerPMManager = new AnswerPMManager();

        $myView = new View();

        $answerPM = $answerPMManager->get($messageId);

        if($answerPM)
        {
            $answerPM->setContent($content);
    
            if($answerPM->isValid($answerPM->content()))
            {
                $answerPM->setEdited(1);
                $answerPMManager->update($answerPM);

                $_SESSION['message'] = 'Le message a bien été modifié';
            }
        }
        else
        {
            $_SESSION['errors'][] = 'Le message que vous souhaitez modifier n\'existe pas';
        }

        $myView->redirect(HOST.'privateMessage/pmId/'.$answerPM->privateMessageId());

    }

    public function leaveConversation($params)
    {
        extract($params);

        $messageId = str_replace('message-', '', $messageId);

        $privateMessageManager = new PrivateMessageManager();
        $answerPMManager = new answerPMManager();
        $viewPMManager = new ViewPMManager();

        $privateMessage = $privateMessageManager->get($messageId);

        ($privateMessage->authorId() == $_SESSION['id']) ? $privateMessage->setAuthorIsOn((int) 0) : '';
        ($privateMessage->receiverId() == $_SESSION['id']) ? $privateMessage->setReceiverIsOn((int) 0) : '';

        $privateMessageManager->update($privateMessage);

        $myView = new View();

        if(!$privateMessage->authorIsOn() AND !$privateMessage->receiverIsOn()) {
            $addWhereP['champ'][] = 'id';
            $addWhereP['value'][] = $messageId;

            $privateMessageManager->delete($addWhereP);

            $addWhereA['champ'][] = 'privateMessageId';
            $addWhereA['value'][] = $messageId;

            $answerPMManager->delete($addWhereA);

            $addWhereV['champ'][] = 'titleId';
            $addWhereV['value'][] = $messageId;

            $viewPMManager->delete($addWhereV);

            $_SESSION['message'] = 'Vous avez quitté la conversation et tous les messages ont été effacés';
        } else {
            if(isset($deleteMessages)) {
                $addWhereA['champ'][] = 'authorId';
                $addWhereA['value'][] = $_SESSION['id'];
                $addWhereA['champ'][] = 'privateMessageId';
                $addWhereA['value'][] = $messageId;

                $answerPMManager->delete($addWhereA, 'AND');

                $addWhereV['champ'][] = 'receiverId';
                $addWhereV['value'][] = $_SESSION['id'];
                $addWhereV['champ'][] = 'titleId';
                $addWhereV['value'][] = $messageId;

                $viewPMManager->delete($addWhereV, 'AND');

                $_SESSION['message'] = 'Vous avez quitté la conversation et vos messages ont été effacés';
            } else {
                $_SESSION['message'] = 'Vous avez quitté la conversation';
            }
        }

        $myView->redirect('inbox/'.$_SESSION['login']);
    }
}