<?php

namespace model\entity;

use \classes\Articles;

class News extends Articles
{
    protected $highlight;
    
    public function highlight() {return $this->highlight;}

    public function setArticleLink($text, $class = null)
    {
        $this->articleLink = '<a '.$class.' href="'.HOST.'news/newsId/'.$this->id().'">'.htmlspecialchars($text).'</a>';
    }

    public function setHighlight($highlight)
    {
        $highlight = (int) $highlight;

        $this->highlight = $highlight;
    }
}