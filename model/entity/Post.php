<?php

namespace model\entity;

use \classes\Articles;

class Post extends Articles
{
    protected $articleId;
    protected $reported;
    protected $moderated;
    protected $moderationId;
    protected $moderationMessage;
    protected $avatar;
    
    public function articleId() {return $this->articleId;}
    public function reported() {return $this->reported;}
    public function moderated() {return $this->moderated;}
    public function moderationId() {return $this->moderationId;}
    public function moderationMessage() {return $this->moderationMessage;}
    public function avatar() {return $this->avatar;}

    public function setArticleLink(){}

    public function setArticleId($articleId)
    {
        $this->articleId = (int) $articleId;
    }

    public function setReported($reported)
    {
        $this->reported = (int) $reported;
    }

    public function setModerated($moderated)
    {
        $this->moderated = (int) $moderated;
    }

    public function setModerationId($moderationId)
    {
        $this->moderationId = (int) $moderationId;
    }

    public function setModerationMessage($moderationMessage)
    {
        if(is_string($moderationMessage)) {
            $this->moderationMessage = $moderationMessage;
        }
    }

    public function setAvatar($avatar)
    {
        if(is_string($avatar)) {
            $this->avatar = $avatar;
        }
    }
}