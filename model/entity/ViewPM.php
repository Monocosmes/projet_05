<?php

namespace model\entity;

use \classes\Messages;

class ViewPM extends Messages
{
	protected $titleId;
	protected $contentId;
	protected $lastPMView;
	protected $isRead;

	public function titleId(){return $this->titleId;}
	public function contentId(){return $this->contentId;}
	public function lastPMView(){return $this->lastPMView;}
	public function isRead(){return $this->isRead;}

	public function setTitleId($titleId)
    {
    	$this->titleId = (int) $titleId;
    }

    public function setContentId($contentId)
    {
    	$this->contentId = (int) $contentId;
    }

    public function setLastPMView($lastPMView)
    {
    	$this->lastPMView = (int) $lastPMView;
    }

	public function setIsRead($isRead)
    {
    	$this->isRead = (int) $isRead;
    }
}