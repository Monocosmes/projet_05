<?php

namespace classes;

use \model\UserManager;
use \model\TestimonyManager;
use \model\NewsManager;
use \model\ViewPMManager;

class TemplateData
{
	protected $userNumber;
	protected $testimonyNumber;
	protected $newsNumber;
    protected $messageNumber;
    protected $lastSignupMember;
    protected $last24hConnected;

    public function __construct()
    {
        $this->setUserNumber();
        $this->setTestimonyNumber();
        $this->setNewsNumber();
        $this->setMessageNumber();
        $this->setLastSignupMember();
        $this->setLast24hConnected();
    }

    public function userNumber(){return $this->userNumber;}
    public function testimonyNumber(){return $this->testimonyNumber;}
    public function newsNumber(){return $this->newsNumber;}
    public function messageNumber(){return $this->messageNumber;}
    public function lastSignupMember(){return $this->lastSignupMember;}
    public function last24hConnected(){return $this->last24hConnected;}

    public function setUserNumber()
    {
    	$userManager = new UserManager();
    	$this->userNumber = $userManager->count();
    }

    public function setTestimonyNumber()
    {
    	$testimonyManager = new TestimonyManager();

        $addWhere['champ'][] = 'published';
        $addWhere['value'][] = '1';

    	$this->testimonyNumber = $testimonyManager->count($addWhere);
    }

    public function setNewsNumber()
    {
    	$newsManager = new NewsManager();

        $addWhere['champ'][] = 'published';
        $addWhere['value'][] = '1';

    	$this->newsNumber = $newsManager->count($addWhere);
    }

    public function setMessageNumber()
    {
        $viewPMManager = new ViewPMManager();
        $this->messageNumber = $viewPMManager->count($_SESSION['id']);
    }

    public function setLastSignupMember()
    {
        $userManager = new UserManager();

        $addWhere = [];
        $addOrder = ' ORDER BY suscribeDate DESC';
        $addLimit = ' LIMIT 0, 1';

        $users = $userManager->getAll($addWhere, $addOrder, $addLimit);
        foreach($users AS $user)
        {
            $this->lastSignupMember = $user;
        }
    }

    public function setLast24hConnected()
    {
        $userManager = new UserManager();

        $addWhere = ' WHERE NOW() < DATE_ADD(lastLogin, INTERVAL 1 DAY)';

        $this->last24hConnected = $userManager->count($addWhere);
    }
}

