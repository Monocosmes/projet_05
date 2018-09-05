<?php

namespace controller\frontend;

use \controller\Controller;
use \model\entity\User;
use \model\UserManager;
use \classes\View;

/**
 * This class is a frontend controller. It handles sign in, sign up, sign off
 */
class Entry extends Controller
{    
    public function signin($params)
	{
		extract($params);

		$userManager = new UserManager();

		$user = new User(['login' => $login]);

		$_SESSION['yourLogin'] = $login;

		$myView = new View();
	
		if($userManager->exists($user->login()))
		{
			$user = $userManager->get($login);

			if(!$user->accountLocked())
			{
				if($user->isPasswordValid($password))
				{
					$userManager->lastLogin($user);

					$_SESSION['id'] = $user->id();
					$_SESSION['login'] = $user->login();
					$_SESSION['name'] = $user->name();
					$_SESSION['lastname'] = $user->lastname();
					$_SESSION['email'] = $user->email();
					$_SESSION['rank'] = $user->rank();
					$_SESSION['isLogged'] = session_id();
	
					(preg_match('#signup | signin#', $_SERVER['HTTP_REFERER']))? $myView->redirect('home.html') : $myView->redirect($_SERVER['HTTP_REFERER']);
				}
				else
				{
					$_SESSION['errors'][] = 'Login ou mot de passe incorrect';
					$myView->redirect('signin.html');
				}
			}
			else
			{
				$_SESSION['errors'][] = 'Ce compte est bloqué.<br />Contactez l\'administrateur si vous pensez que c\'est une erreur';
				$myView->redirect('signin.html');
			}
		}
		else
		{
			$_SESSION['errors'][] = 'Login ou mot de passe incorrect';
			$myView->redirect('signin.html');
		}
	}
	
	public function signoff($params)
	{
		session_destroy();
		setcookie('PHPSESSID', $_COOKIE['PHPSESSID'], time() - 1600, '/');
	
		$myView = new View();
		$myView->redirect('home.html');
	}
	
	public function signup($params)
	{
		extract($params);

		$myView = new View();

		$isMatriculeExist = true;

		$employee = (isset($employee)) ? (int) 1 : (int) 0;
		$name = (isset($name)) ? $name : null;
		$lastname = (isset($lastname)) ? $lastname : null;
		$matricule = (isset($matricule)) ? $matricule : null;
		$askVerification = ($employee) ? (int) 1 : (int) 0;
		
		$user = new User
		([
			'name' => $name,
			'lastname' => $lastname,
			'matricule' => $matricule,
			'login' => $login,
			'email' => $email,
			'password' => $password,
			'employee' => $employee,
			'askVerification' => $askVerification
		]);

		$_SESSION['yourName'] = $name;
		$_SESSION['yourLastname'] = $lastname;
		$_SESSION['yourMatricule'] = $matricule;
		$_SESSION['yourLogin'] = $login;
		$_SESSION['yourEmail'] = $email;

		if($user->login() AND $user->email() AND $user->password() AND $user->isValid($matchPassword) AND $user->isValid($termOfService))
		{		
			$isLoginLengthOk = $user->isLengthValid($user->login(), 4, 30, 'identifiant');
			$isLoginValid = $user->isLoginValid();
			$isPasswordLengthOk = $user->isLengthValid($user->password(), 6, 50, 'mot de passe');
			$isPasswordsMatch = $user->isPasswordsMatch($matchPassword);
			$isEmailValid = $user->isEmailValid();

			if(!empty($user->matricule()))
            {
                $isMatriculeExist = $user->isMatriculeExist();
            }

			if($isLoginLengthOk AND $isLoginValid AND $isPasswordLengthOk AND $isPasswordsMatch AND $isEmailValid AND $isMatriculeExist)
			{			
				$user->encryptPassword();

				$userManager = new UserManager();
				$userManager->add($user);

				$_SESSION['message'] = 'Bienvenue camarade ! Connecte-toi sans plus tarder !';
			
				$myView->redirect('signin.html');					
			}
			else
			{
				$myView->redirect('signup.html');
			}
		}
		else
		{
			$myView->redirect('signup.html');
		}
	}

	public function showSigninPage($params)
	{
		if($_SESSION['id'] > 0)
		{
			$myView = new View();
			$myView->redirect('home.html');
		}
		else
		{
			$elements = ['templateData' => $this->templateData];

			$myView = new View('entry/signin');
			$myView->render($elements);
		}
	}
	
	public function showSignupPage($params)
	{
		if($_SESSION['id'] > 0)
		{
			$myView = new View();
			$myView->redirect('home.html');
		}
		else
		{
			$elements = ['templateData' => $this->templateData];

			$myView = new View('entry/signup');
			$myView->render($elements);
		}
	}
}