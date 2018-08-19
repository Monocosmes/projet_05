<?php

namespace model\entity;

use \classes\Articles;

class Category extends Articles
{
    protected $name;
    
    public function name() {return $this->name;}
    
    public function setArticleLink(){}

    public function setName($name)
    {
        if(is_string($name))
        {
            $this->name = $name;
        }
    }
}
