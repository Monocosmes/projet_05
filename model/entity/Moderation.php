<?php

/**
 * summary
 */
namespace model\entity;

use \classes\Hydrator;
use \classes\Validator;

class Moderation
{
    use Hydrator;
    use Validator;

    protected $id;
    protected $moderationMessage;

    public function __construct(array $data = [])
    {
        if(!empty($data))
        {
            $this->hydrate($data);
        }
    }

    public function id() {return $this->id;}
    public function moderationMessage() {return $this->moderationMessage;}

    public function setId($id)
    {
        $id = (int) $id;

        $this->id = $id;
    }

    public function setModerationMessage($moderationMessage)
    {
    	if(is_string($moderationMessage))
    	{
    		$this->moderationMessage = $moderationMessage;
    	}
    }
}