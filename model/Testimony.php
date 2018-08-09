<?php

class Testimony extends Articles
{
    protected $categoryId;
    protected $categoryName;
    
    public function categoryId() {return $this->categoryId;}
    public function categoryName() {return $this->categoryName;}
    
    public function setArticleLink($text, $class = null)
    {
        $this->articleLink = '<a '.$class.' href="'.HOST.'testimony/testimonyId/'.$this->id.'">'.htmlspecialchars($text).'</a>';
    }

    public function setCategoryId($categoryId)
    {
        if($categoryId != 0)
        {
            $this->categoryId = (int) $categoryId;
        }
        else
        {
            $_SESSION['errors'][] = 'Vous devez choisir une catégorie';
        }
        
    }

    public function setCategoryName($categoryName)
    {
        if(is_string($categoryName))
        {
            $this->categoryName = $categoryName;
        }
    }
}
