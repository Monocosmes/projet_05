<?php

namespace model\entity;

use \classes\Messages;

class AnswerPM extends Messages
{
	protected $privateMessageId;
	protected $content;
    protected $editDateFr;
    protected $edited;

	// getters
	public function privateMessageId(){return $this->privateMessageId;}
	public function content(){return $this->content;}
    public function editDateFr(){return $this->editDateFr;}
    public function edited(){return $this->edited;}    

	// setters
    public function setPrivateMessageId($privateMessageId)
    {
    	$this->privateMessageId = (int) $privateMessageId;
    }

	public function setContent($content)
    {
    	if(is_string($content))
    	{
    		$this->content = $content;
    	}
    }

    public function setEditDateFr($editDateFr)
    {
    	if(is_string($editDateFr))
    	{
    		$this->editDateFr = $editDateFr;
    	}
    }

    public function setEdited($edited)
    {
    	$this->edited = (int) $edited;
    }    
}