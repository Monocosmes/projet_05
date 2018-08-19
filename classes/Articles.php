<?php

namespace classes;

use \classes\Hydrator;
use \classes\Validator;

abstract class Articles
{
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
    public function addDateFr() {return $this->addDateFr;}
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
            $_SESSION['errors'][] = 'Erreur à propos du nom de l\'auteur';
        }
    
        $this->authorName = $authorName;
    }
    
    public function setTitle($title)
    {
        if(!is_string($title) OR empty($title))
        {
            $_SESSION['errors'][] = 'Erreur à propos du titre';
        }
    
        $this->title = $title;
    }
    
    public function setContent($content)
    {
        if(!is_string($content) OR empty($content))
        {
            $_SESSION['errors'][] = 'Erreur à propos du contenu';
        }
    
        $this->content = $content;
    }
    
    public function setAddDateFr($addDateFr)
    {
        $this->addDateFr = $addDateFr;
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