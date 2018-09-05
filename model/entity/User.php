<?php

namespace model\entity;

use \classes\FormatDate;
use \classes\Hydrator;
use \classes\Validator;
use \model\UserManager;

class User
{
    use FormatDate;
    use Hydrator;
    use Validator;
    
    protected $id;
    protected $email;
    protected $login;
    protected $avatar;
    protected $name;
    protected $lastname;
    protected $matricule;
    protected $phoneNumber;
    protected $password;
    protected $employee;
    protected $suscribeDate;
    protected $lastLogin;
    protected $rank;
    protected $role;
    protected $onContact;
    protected $askVerification;
    protected $accountLocked;
    protected $seeEmail;
    protected $seePhoneNumber;
    protected $seeName;
    protected $seeLastName;
    
    public function __construct(array $data)
    {
       $this->hydrate($data);
    }

    public function encryptPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function isEmailValid()
    {
        if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $this->email))
        {
            $userManager = new UserManager();

            if(!$userManager->exists($this->email))
            {
                return true;
            }
            else
            {
                $_SESSION['errors'][] = 'Cet email est deja pris. Veuillez en choisir un autre';
                return false;
            }
        }
        else
        {
            $_SESSION['errors'][] = 'L\'email propose n\'a pas une forme valide';
            return false;
        }
    }

    public function isLoginValid()
    {
        if(preg_match('#^[a-zA-Z0-9éèàçêâûîïüÿëäôöù@_-]#i', $this->login))
        {                        
            $userManager = new UserManager();
    
            if(!$userManager->exists($this->login))
            {
                return true;
            }
            else
            {
                $_SESSION['errors'][] = 'Cet identifiant est deja pris. Veuillez en choisir un autre';
                return false;
            }
        }
        else
        {
            $_SESSION['errors'][] = 'Les caractères spéciaux autorisés pour l\'identifiant sont _ et -';
            return false;
        }
    }

    public function isMatriculeExist()
    {
        $userManager = new UserManager();
    
        if(!$userManager->exists($this->matricule))
        {
            return true;
        }
        else
        {
            $_SESSION['errors'][] = 'Ce matricule est deja dans notre base. Verifiez qu\'il s\'agit bien du votre et re-essayez';
            return false;
        }
    }

    public function isLengthValid($data, $minLength, $maxLength, $text)
    {
        if(strlen($data) >= $minLength AND strlen($data) <= $maxLength)
        {
            return true;
        }
        else
        {
            $_SESSION['errors'][] = 'Votre '.$text.' doit comporter entre '.$minLength.' et '.$maxLength.' caracteres';
            return false;
        }
    }

    public function isPasswordsMatch($passwordMatch)
    {
        if(!empty($this->password) OR !empty($passwordMatch))
        {
            if($this->password === $passwordMatch)
            {
                return true;
            }
            else
            {
                $_SESSION['errors'][] = 'Les mots de passe ne correspondent pas';
                return false;
            }
        }
    }

    public function isPasswordValid($password)
    {
        if(password_verify($password, $this->password))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    //getters
    public function id(){return $this->id;}
    public function email(){return $this->email;}
    public function login(){return $this->login;}
    public function avatar(){return $this->avatar;}
    public function name(){return $this->name;}
    public function lastname(){return $this->lastname;}
    public function matricule(){return $this->matricule;}
    public function phoneNumber(){return $this->phoneNumber;}
    public function password(){return $this->password;}
    public function employee(){return $this->employee;}
    public function suscribeDate(){return $this->suscribeDate;}
    public function lastLogin(){return $this->lastLogin;}
    public function rank(){return $this->rank;}
    public function role(){return $this->role;}
    public function onContact(){return $this->onContact;}
    public function askVerification(){return $this->askVerification;}
    public function accountLocked(){return $this->accountLocked;}
    public function seeEmail(){return $this->seeEmail;}
    public function seePhoneNumber(){return $this->seePhoneNumber;}
    public function seeName(){return $this->seeName;}
    public function seeLastName(){return $this->seeLastName;}
    
    //setters
    public function setId($id)
    {
        $this->id = (int) $id;
    }
    
    public function setEmail($email)
    {
        if(is_string($email))
        {
            if(!empty($email))
            {
                $this->email = strtolower($email);
            }
            else
            {
                $this->email = null;
                $_SESSION['errors'][] = 'Le champ "Email" est vide';
            }
        }
    }
    
    public function setLogin($login)
    {
        if(is_string($login))
        {
            if(!empty($login))
            {
                $this->login = $login;
            }
            else
            {
                $this->login = null;
                $_SESSION['errors'][] = 'Le champ "Identifiant" est vide';
            }

        }
    }

    public function setAvatar($avatar)
    {
        if(is_string($avatar)) {
            $this->avatar = $avatar;
        }
    }
    
    public function setName($name)
    {    
        if(!empty($name))
        {
            $this->name = $name;
        }
        else
        {
            $this->name = null;
        }
    }
    
    public function setLastname($lastname)
    {   
        if(!empty($lastname))
        {
            $this->lastname = $lastname;
        }
        else
        {
            $this->lastname = null;
        }
    }

    public function setMatricule($matricule)
    {
        if(preg_match('#^[0-9]{3,5}$#', $matricule) OR $matricule === null)
        {
            $this->matricule = $matricule;
        }
        else
        {
            if(!empty($matricule))
            {
                $_SESSION['errors'][] = 'Votre matricule doit etre compose uniquement de chiffres';
            }            
        }
    }

    public function setPhoneNumber($phoneNumber)
    {
        if(preg_match('#^0[1-8][0-9]{8}$#', $phoneNumber) OR $phoneNumber === null)
        {
            $this->phoneNumber = $phoneNumber;
        }
        else
        {
            if(!empty($phoneNumber))
            {
                $_SESSION['errors'][] = 'Votre numero de telephone doit etre compose uniquement de chiffres et avoir un format valide';
            }            
        }
    }
    
    public function setPassword($password)
    {
        if(is_string($password))
        {
            if(!empty($password))
            {
                $this->password = $password;
            }
            else
            {
                $this->password = null;
                $_SESSION['errors'][] = 'Le champ "Mot de passe" est vide';
            }
        }       
    }

    public function setEmployee($employee)
    {
        $this->employee = (int) $employee;
    }
    
    public function setSuscribeDate($suscribeDate)
    {
        $this->suscribeDate = $suscribeDate;
    }
    
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    public function setRank($rank)
    {
        $this->rank = (int) $rank;

        switch ($this->rank)
        {
            case 1:
                $this->role = "Visiteur";
                break;
            case 2:
                $this->role = "Membre Basic";
                break;
            case 3:
                $this->role = "Membre Validé";
                break;
            case 4:
                $this->role = "Membre du Bureau";
                break;
            case 5:
                $this->role = "Administrateur";
                break;          
            default:
                $this->role = "Non Valide";
                break;
        }
    }

    public function setOnContact($onContact)
    {
        $this->onContact = (int) $onContact;
    }

    public function setAskVerification($askVerification)
    {
        $this->askVerification = (int) $askVerification;
    }

    public function setAccountLocked($accountLocked)
    {
        $this->accountLocked = (int) $accountLocked;
    }

    public function setSeeEmail($seeEmail)
    {
        $this->seeEmail = (int) $seeEmail;
    }

    public function setSeePhoneNumber($seePhoneNumber)
    {
        $this->seePhoneNumber = (int) $seePhoneNumber;
    }

    public function setSeeName($seeName)
    {
        $this->seeName = (int) $seeName;
    }

    public function setSeeLastName($seeLastName)
    {
        $this->seeLastName = (int) $seeLastName;
    }
}