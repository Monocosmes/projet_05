<?php

namespace classes;

use \classes\FormatDate;
use \classes\Hydrator;
use \classes\Validator;

abstract class Articles
{
    use FormatDate;
    use Hydrator;
    use Validator;

    protected $id;
    protected $articleLink;
    protected $authorId;
    protected $authorName;
    protected $title;
    protected $content;
    protected $addDate;
    protected $editDate;
    protected $edited;
    protected $published;
    protected $commentCount;

    public function __construct(array $data = [])
    {
        if(!empty($data))
        {
        	$this->hydrate($data);
        }
    }

    public function changeCommentCount($num)
    {
        $this->commentCount += (int) $num;
    }

    // Getters
    public function id() {return $this->id;}
    public function articleLink() {return $this->articleLink;}
    public function authorId() {return $this->authorId;}
    public function authorName() {return $this->authorName;}
    public function title() {return $this->title;}
    public function content() {return $this->content;}
    public function addDate() {return $this->addDate;}
    public function editDate() {return $this->editDate;}
    public function edited() {return $this->edited;}
    public function published() {return $this->published;}
    public function commentCount() {return $this->commentCount;}
    
    // Setters
    public function setId($id)
    {
        $this->id = (int) $id;
    }
    
    public function setAuthorId($authorId)
    {
        $this->authorId = (int) $authorId;
    }

    public function setAuthorName($authorName)
    {
        if(!is_string($authorName) OR empty($authorName))
        {
            $_SESSION['errors'][] = 'Le nom de l\'auteur n\'a pas un format conforme';
        }
    
        $this->authorName = $authorName;
    }
    
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
    
    public function setContent($content)
    {
        if(!is_string($content) OR empty($content))
        {
            $_SESSION['errors'][] = 'Le contenu n\'a pas un format conforme';
        }
    
        $this->content = $content;
    }
    
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;
    }
    
    public function setEditDate($editDate)
    {
        $this->editDate = $editDate;
    }

    public function setEdited($edited)
    {
        $this->edited = (int) $edited;
    }

    public function setPublished($published)
    {
        $this->published = (int) $published;
    }

    public function setCommentCount($commentCount)
    {
        $this->commentCount = (int) $commentCount;
    }
}