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

    public function __construct()
    {
        $this->setUserNumber();
        $this->setTestimonyNumber();
        $this->setNewsNumber();
        $this->setMessageNumber();
    }

    public function userNumber(){return $this->userNumber;}
    public function testimonyNumber(){return $this->testimonyNumber;}
    public function newsNumber(){return $this->newsNumber;}
    public function messageNumber(){return $this->messageNumber;}

    public function setUserNumber()
    {
    	$userManager = new UserManager();
    	$this->userNumber = $userManager->count();
    }

    public function setTestimonyNumber()
    {
    	$testimonyManager = new TestimonyManager();
    	$this->testimonyNumber = $testimonyManager->count();
    }

    public function setNewsNumber()
    {
    	$newsManager = new NewsManager();
    	$this->newsNumber = $newsManager->count();
    }

    public function setMessageNumber()
    {
        $viewPMManager = new ViewPMManager();
        $this->messageNumber = $viewPMManager->count($_SESSION['id']);
    }
}