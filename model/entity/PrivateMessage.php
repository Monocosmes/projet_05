<?php

namespace model\entity;

use \classes\Messages;

class PrivateMessage extends Messages
{
    protected $title;
    protected $receiverName;
    protected $messageCount;
    protected $lastPMId;
    protected $isRead;
    protected $receiverIdView;
    protected $authorIsOn;
    protected $receiverIsOn;
    
    public function changeMessageCount($number)
    {
        $this->messageCount += ((int) $number);
    }

    // getters
    public function title(){return $this->title;}    
    public function receiverName(){return $this->receiverName;}
    public function messageCount(){return $this->messageCount;}
    public function lastPMId(){return $this->lastPMId;}
    public function isRead(){return $this->isRead;}
    public function receiverIdView(){return $this->receiverIdView;}
    public function authorIsOn(){return $this->authorIsOn;}
    public function receiverIsOn(){return $this->receiverIsOn;}

    // setters
    public function setTitle($title)
    {
        if(!is_string($title) OR empty($title))
        {
            $_SESSION['errors'][] = 'Le titre n\'a pas un format conforme';
        }
        else
        {
            if(strlen($title) < 255)
            {
                $this->title = $title;
            }
            else
            {
                $_SESSION['errors'][] = 'Le titre ne peut pas dépasser 255 caractères';
            }
        }
    }    

    public function setReceiverName($receiverName)
    {
        if(is_string($receiverName))
        {
            $this->receiverName = $receiverName;
        }
    }

    public function setMessageCount($messageCount)
    {
        $this->messageCount = (int) $messageCount;
    }

    public function setLastPMId($lastPMId)
    {
    	$this->lastPMId = (int) $lastPMId;
    }

    public function setIsRead($isRead)
    {
        $this->isRead = (int) $isRead;
    }

    public function setReceiverIdView($receiverIdView)
    {
        $this->receiverIdView = (int) $receiverIdView;
    }

    public function setAuthorIsOn($authorIsOn)
    {
        $this->authorIsOn = (int) $authorIsOn;
    }

    public function setReceiverIsOn($receiverIsOn)
    {
        $this->receiverIsOn = (int) $receiverIsOn;
    }
}
