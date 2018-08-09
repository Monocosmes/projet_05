<?php

class User
{
    use Hydrator;
    use Validator;
    
    protected $id;
    protected $email;
    protected $login;
    protected $name;
    protected $lastname;
    protected $password;
    protected $suscribeDate;
    protected $lastLogin;
    protected $rank;
    protected $accountLocked;
    
    public function __construct(array $data)
    {
       $this->hydrate($data);
    }

    public function getCryptedPassword()
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function isEmailValid($email)
    {
        if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email))
        {
            return true;
        }
        else
        {
            $_SESSION['errors'][] = 'L\'email propose n\'a pas une forme valide';
            return false;
        }
    }

    public function isLenghtValid($data, $minLenght, $maxLenght, $text)
    {
        if(strlen($data) >= $minLenght AND strlen($data) <= $maxLenght)
        {
            return true;
        }
        else
        {
            $_SESSION['errors'][] = 'Votre '.$text.' doit comporter entre '.$minLenght.' et '.$maxLenght.' caracteres';
            return false;
        }
    }

    public function isLoginExists()
    {
        $userManager = new UserManager();

        if($userManager->exists($this->login))
        {
            return true;
        }
        else
        {
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
    
    public function id(){return $this->id;}
    public function email(){return $this->email;}
    public function login(){return $this->login;}
    public function name(){return $this->name;}
    public function lastname(){return $this->lastname;}
    public function password(){return $this->password;}
    public function suscribeDate(){return $this->suscribeDate;}
    public function lastLogin(){return $this->lastLogin;}
    public function rank(){return $this->rank;}
    public function accountLocked(){return $this->accountLocked;}
    
    public function setId($id)
    {
       $this->id = (int) $id;
    }
    
    public function setEmail($email)
    {
        if(is_string($email))
        {
            $this->email = strtolower($email);
        }
    }
    
    public function setLogin($login)
    {
        if(is_string($login))
        {                          
            if(preg_match('#^[a-zA-Z0-9_-]#', $login))
            {                        
                $this->login = $login;
            }
            else
            {
                $_SESSION['errors'][] = 'Les caractères spéciaux autorisés pour l\'identifiant sont _ et -';
            }            
        }
    }
    
    public function setName($name)
    {
       if(!is_string($name) OR empty($name))
       {
          throw new Exception('Le nom doit être une chaîne de caractères valide');
       }
    
       $this->name = $name;
    }
    
    public function setLastname($lastname)
    {
       if(!is_string($lastname) OR empty($lastname))
       {
          throw new Exception('L\'email doit être une chaîne de caractères valide');
       }
    
       $this->lastname = $lastname;
    }
    
    public function setPassword($password)
    {
       if(is_string($password))
       {
          $this->password = $password;
       }       
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
   }

   public function setAccountLocked($accountLocked)
   {
      $this->accountLocked = (int) $accountLocked;
   }
}