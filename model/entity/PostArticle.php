<?php

namespace model\entity;

use \classes\Articles;

class PostArticle extends Articles
{
    protected $articleId;
    protected $reported;
    
    public function articleId() {return $this->articleId;}
    public function reported() {return $this->reported;}

    public function setArticleLink(){}

    public function setArticleId($articleId)
    {
        $this->articleId = (int) $articleId;
    }

    public function setReported($reported)
    {
        $this->reported = (int) $reported;
    }
}