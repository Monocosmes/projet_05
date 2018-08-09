<?php

class Post extends Articles
{
    protected $newsId;
    
    public function newsId() {return $this->newsId;}

    public function setArticleLink(){}

    public function setNewsId($newsId)
    {
        $newsId = (int) $newsId;

        $this->newsId = $newsId;
    }
}