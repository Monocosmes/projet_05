<?php

namespace controller\backend;

use \controller\Controller;
use \model\entity\PrivateMessage;
use \model\entity\AnswerPM;
use \model\entity\ViewPM;
use \model\UserManager;
use \model\ViewPMManager;
use \classes\View;

class UserController extends Controller
{
    public function changeRank($params)
	{
		extract($params);

		$userManager = new UserManager();
		$myView = new View();

		if(isset($login) AND isset($rank))
		{
			if($userManager->exists($login))
			{
				$login = strtoupper($login);

				$admin =
				[
					'ADMIN' => 1,
					'CFDT' => 1,
					'CFDT-INTERCO77' => 1
				];

				if(key_exists($login, $admin) OR $rank >= $_SESSION['rank'])
				{
					$_SESSION['errors'][] = 'Vous n\'avez pas les droits pour changer le rang du compte '.$login;
				}
				elseif($login === $_SESSION['login'])
				{
					$_SESSION['errors'][] = 'Vous ne pouvez pas modifier votre propre rang';
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

	public function lockAccount($params)
    {
        extract($params);

        $userManager = new UserManager();
        $user = $userManager->get((int) $userId);

        $user->setAccountLocked((int) $lock);

        $userManager->update($user);

        $myView = new View();
        $myView->redirect('profile/userId/'.$userId);
    }

    public function validateUsers($params)
	{
		extract($params);

		$userManager = new UserManager();
		$myView = new View();

		if(isset($ids) AND isset($rank))
		{
			foreach($ids AS $index => $id)
			{
				if($userManager->exists((int) $id))
				{
					$user = $userManager->get((int) $id);

					if($isAccepted[$index])
					{							
						$user->setRank($rank);							

						$title = 'Passage au rang de Membre Validé accepté';
						$content = 'Nous vous informons que votre demande à passer en Membre Validé à été acceptée.';
					}
					else
					{
						$title = 'Passage au rang de Membre Validé refusé';
						$content = 'Nous vous informons que votre demande à passer en Membre Validé à été refusée.';
						$content .= "\n";
						$content .= 'Veuillez contacter un membre du bureau si vous souhaitez en connaitre la raison.';
					}

					$user->setAskVerification(0);
					
					$userManager->update($user);

					$privateMessage = new PrivateMessage
    				([
    					'authorId' => (int) 0,
    					'receiverId' => $id,
    					'title' => $title,
    					'messageCount' => 1,
               		    'authorIsOn' => (int) 0,
               		    'receiverIsOn' => 1
    				]);
					
    				$answerPM = new AnswerPM
    				([
    					'authorId' => (int) 0,
    					'content' => $content
    				]);

    				$params =
                   	[
                   	    'privateMessage' => $privateMessage,
                   	    'answerPM' => $answerPM
                   	];

                   	$data = $this->sendPrivateMessage($params);

                   	extract($data);

                   	$viewPMReceiver = new ViewPM
    				([
    					'receiverId' => $id,
    					'titleId' => $privateMessageId,
    					'contentId' => $answerId,
    					'lastPMView' => (int) 0,
    					'isRead' => (int) 0
    				]);

    				$viewPMManager = new ViewPMManager();
					
    				$viewPMManager->add($viewPMReceiver);
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
}