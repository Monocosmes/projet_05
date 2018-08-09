<?php


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

    public function __construct(array $data = [])
    {
        if(!empty($data))
        {
        	$this->hydrate($data);
        }
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
    
    // Setters
    public function setId($id)
    {
        $id = (int) $id;

        $this->id = $id;
    }
    
    public function setAuthorId($authorId)
    {
       $authorId = (int) $authorId;
    
       $this->authorId = $authorId;
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
        $edited = (int) $edited;

        $this->edited = $edited;
    }

    public function setPublished($published)
    {
        $published = (int) $published;

        $this->published = $published;
    }    
}