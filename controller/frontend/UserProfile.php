<?php

namespace controller\frontend;

use \controller\Controller;
use \model\entity\User;
use \model\entity\PrivateMessage;
use \model\entity\AnswerPM;
use \model\entity\ViewPM;
use \model\UserManager;
use \model\NewsManager;
use \model\TestimonyManager;
use \model\PostManager;
use \model\PrivateMessageManager;
use \model\AnswerPMManager;
use \model\ViewPMManager;
use \classes\View;
use \classes\Upload;

class UserProfile extends Controller
{    
    public function deleteAccount($params)
    {
        extract($params);

        $postNManager = new PostManager('postsnews');
        $postTManager = new PostManager('poststestimony');
        $userManager = new UserManager();
        $newsManager = new NewsManager();
        $testimonyManager = new TestimonyManager();
        $privateMessageManager = new PrivateMessageManager();
        $answerPMManager = new AnswerPMManager();
        $viewPMManager = new ViewPMManager();

        $myView = new View();

        $user = $userManager->get((int) $userId);

        if(strtoupper($user->login()) === 'ADMIN' OR strtoupper($user->login()) === 'CFDT' OR strtoupper($user->login()) === 'CFDT-INTERCO77') {
            $_SESSION['errors'][] = 'Ce compte ne peut pas être supprimé';

            $myView->redirect('403.html');
        } elseif($user->id() != $userId OR $_SESSION['rank'] < 4) {
            $_SESSION['errors'][] = 'Vous n\'avez pas les droits suffisants pour supprimer ce compte';

            $myView->redirect('403.html');
        }

        $addWhere['champ'][] = 'authorId';
        $addWhere['value'][] = $userId;

        if(isset($deletePost)) {
            $postsN = $postNManager->getAll($addWhere);
            $postsT = $postTManager->getAll($addWhere);

            if($postsN) {
                foreach($postsN AS $postN) {
                    $news = $newsManager->get($postN->articleId());
                    $news->changeCommentCount(-1);
                    $newsManager->updateCommentCount($news);
                }
            }

            if($postsT) {                
                foreach($postsT AS $postT) {
                    $testimony = $testimonyManager->get($postT->articleId());
                    $testimony->changeCommentCount(-1);
                    $testimonyManager->updateCommentCount($testimony);
                }
            }
            
            $addSet['champ'] = 'receiverIsOn';
            $addSet['value'] = (int) 0;            
            $addWhere['champ'][0] = 'receiverId';
            $addWhere['value'][0] = $_SESSION['id'];

            $privateMessageManager->updateAll($addSet, $addWhere);

            $addSet['champ'] = 'authorIsOn';
            $addWhere['champ'][0] = 'authorId';

            $privateMessageManager->updateAll($addSet, $addWhere);

            $postNManager->delete($addWhere);
            $postTManager->delete($addWhere);

            $_SESSION['message'] = 'Le compte et les messages ont bien été supprimés';
        } else {
            $_SESSION['message'] = 'Le compte a bien été supprimé et les messages sont passés en invité';
        }

        $addWhere['champ'][0] = 'authorId';
        $addWhere['value'][0] = $_SESSION['id'];

        $answerPMManager->delete($addWhere);
        $userManager->delete($userId);

        $addWhere['champ'][0] = 'receiverId';
        $viewPMManager->delete($addWhere);

        if($userId == $_SESSION['id']) {
            $myView->redirect('signoff');
        } else {
            $myView->redirect('home.html');
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

        if($user->isValid($user->seeEmail()) AND $user->isValid($user->seePhoneNumber()) AND $user->isValid($user->seeName()) AND $user->isValid($user->seeLastName())) {
            $userManager = new UserManager();
            $oldUser = $userManager->get((int) $userId);

            $oldUser->setSeeEmail($user->seeEmail());
            $oldUser->setSeePhoneNumber($user->seePhoneNumber());
            $oldUser->setSeeName($user->seeName());
            $oldUser->setSeeLastName($user->seeLastName());
            $oldUser->setOnContact((int) 0);

            if(isset($contactInfo) AND $user->seeName() === 1 AND $user->seeLastName() === 1) {
                $oldUser->setOnContact((int) 1);
            } elseif(isset($contactInfo) AND $user->seeName() !== 1 AND $user->seeLastName() !== 1) {
                $_SESSION['errors'][] = 'Vos nom et prénom doivent être visibles de tous si vous souhaitez apparaître sur la page de contact.';

                $myView->redirect(HOST.'profileSettings/userId/'.$userId);
            }

            $userManager = new UserManager();
            $userManager->updateSettings($oldUser);

            $myView->redirect(HOST.'profile/userId/'.$userId);
        } else {
            $myView->redirect(HOST.'profileSettings/userId/'.$userId);
        }
    }    

    public function updateProfile($params)
    {
        extract($params);

        $isLoginValid = true;
        $isLoginLengthOk = true;
        $isOldPassValid = true;
        $isPasswordLengthOk = true;
        $isPasswordsMatch = true;
        $isEmailValid = true;
        $isMatriculeExist = true;

        $userManager = new UserManager();
        $user = $userManager->get((int) $id);

        $myView = new View();

        if(isset($login) AND $user->login() != $login) {
            $user->setLogin($login);
            $isLoginValid = $user->isLoginValid();
            $isLoginLengthOk = $user->isLengthValid($user->login(), 4, 30, 'identifiant');
        }

        if(isset($phoneNumber) AND $user->phoneNumber() != $phoneNumber) {
            if(!empty($phoneNumber)) {
                $user->setPhoneNumber($phoneNumber);
            } else {
                $user->setPhoneNumber(null);
            }
        }

        if(!empty($password) AND !empty($passwordMatch) AND !empty($oldPassword)) {
            $isOldPassValid = $user->isPasswordValid($oldPassword);
            $user->setPassword($password);
            $user->encryptPassword();
            $isPasswordLengthOk = $user->isLengthValid($user->password(), 6, 50, 'mot de passe');
            $isPasswordsMatch = $user->isPasswordsMatch($passwordMatch);
        }

        (isset($employee)) ? $user->setEmployee(1) : $user->setEmployee(0);

        $email = mb_strtolower($email);

        if(isset($email) AND $user->email() != $email) {
            $user->setEmail($email);
            $isEmailValid = $user->isEmailValid();            
        }

        if(isset($name) OR isset($lastname) OR isset($matricule))
        {   
            if($user->rank() > 2 AND $user->rank() < 5) {
                $user->setRank(2);
                $user->setEmployee(0);
                $user->setOnContact(0);
                $_SESSION['errors'][] = 'Le changement de votre prénom, votre nom ou de votre matricule vous a remis au rang de membre basic. Faites une demande de vérification pour accéder à votre ancien rang';
            }

            if(!empty($name)) {
                if($user->name() != $name) {$user->setName($name);}
            } else {
                $user->setName(null);
            }

            if(!empty($lastname)) {
                if($user->lastname() != $lastname) {
                    $user->setLastname($lastname);
                }
            } else {
                $user->setLastname(null);
            }
            
            if(!empty($matricule)) {
                if($user->matricule() != $matricule) {
                    $user->setMatricule($matricule);
                    $isMatriculeExist = $user->isMatriculeExist();
                }
            } else {
                $user->setMatricule(null);
            }
        }

        if(isset($askVerification) AND (is_null($user->name()) OR is_null($user->lastname()) OR is_null($user->matricule()))) {
            $_SESSION['errors'][] = 'Vous devez renseigner vos nom, prénom et matricule pour pouvoir passer en Membre Validé';
            $user->setAskVerification(0);
        } elseif(isset($askVerification) AND !is_null($user->name()) AND !is_null($user->lastname()) AND !is_null($user->matricule())) {
            $user->setAskVerification(1);
        }

        if($isLoginValid AND $isLoginLengthOk AND $isOldPassValid AND $isPasswordLengthOk AND $isPasswordsMatch AND $isEmailValid AND $isMatriculeExist) {
            $userManager->update($user);

            $_SESSION['message'] = 'Le profil a bien été modifié';

            $myView->redirect(HOST.'profile/userId/'.$user->id());
        } else {
            $myView->redirect(HOST.'editProfile/userId/'.$user->id());
        }
    }

    public function uploadAvatar($params)
    {
        $upload = new Upload();

        $newAvatar = $upload->uploadImageArticle($params, 'avatars', $_SESSION['id']);

        if($newAvatar) {
            $userManager = new UserManager();

            $user = $userManager->get((int) $_SESSION['id']);

            ($user->avatar() != '0.jpg') ? unlink(ROOT.'assets/images/avatars/'.$user->avatar()) : '';

            $user->setAvatar($newAvatar);

            $userManager->update($user);
        }
    }
}
