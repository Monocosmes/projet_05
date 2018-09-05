<?php

namespace classes;

use \classes\FormatDate;
use \classes\Hydrator;
use \classes\Validator;

/**
 * summary
 */
abstract class Messages
{
   	use FormatDate;
    use Hydrator;
    use Validator;

    protected $id;
    protected $authorId;
    protected $receiverId;
    protected $authorName;
    protected $creationDate;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }

    // getters
    public function id(){return $this->id;}
    public function authorId(){return $this->authorId;}
    public function receiverId(){return $this->receiverId;}
    public function authorName(){return $this->authorName;}
    public function creationDate(){return $this->creationDate;}    

    // setters
    public function setId($id)
    {
    	$this->id = (int) $id;
    }

    public function setAuthorId($authorId)
    {
    	$this->authorId = (int) $authorId;
    }

    public function setReceiverId($receiverId)
    {
        $this->receiverId = (int) $receiverId;
    }

    public function setAuthorName($authorName)
    {
    	if(is_string($authorName))
    	{
    		$this->authorName = $authorName;
    	}
    }

    public function setCreationDate($creationDate)
    {
    	if(is_string($creationDate))
    	{
    		$this->creationDate = $creationDate;
    	}
    }
}