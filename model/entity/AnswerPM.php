<?php

namespace model\entity;

use \classes\Messages;

class AnswerPM extends Messages
{
	protected $privateMessageId;
	protected $content;
    protected $editDate;
    protected $edited;

	// getters
	public function privateMessageId(){return $this->privateMessageId;}
	public function content(){return $this->content;}
    public function editDate(){return $this->editDate;}
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

    public function setEditDate($editDate)
    {
    	if(is_string($editDate))
    	{
    		$this->editDate = $editDate;
    	}
    }

    public function setEdited($edited)
    {
    	$this->edited = (int) $edited;
    }    
}