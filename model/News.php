<?php

class News extends Articles
{
    protected $highlight;
    protected $commentNumber;
    
    public function highlight() {return $this->highlight;}
    public function commentNumber() {return $this->commentNumber;}

    public function setArticleLink($text, $class = null)
    {
        $this->articleLink = '<a '.$class.' href="'.HOST.'news/newsId/'.$this->id().'">'.htmlspecialchars($text).'</a>';
    }

    public function setHighlight($highlight)
    {
        $highlight = (int) $highlight;

        $this->highlight = $highlight;
    }
    
    public function setCommentNumber($commentNumber)
    {
        $this->commentNumber = (int) $commentNumber;
    }
}