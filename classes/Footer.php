<?php

/**
 * summary
 */
class Footer
{
	private $_userNumber;
	private $_commentNumber;
	private $_chapterNumber;

    public function __construct()
    {
        /*$this->setUserNumber();
        $this->setCommentNumber();
        $this->setChapterNumber();*/
    }

    public function getUserNumber()
    {
    	return $this->_userNumber;
    }

    public function getCommentNumber()
    {
    	return $this->_commentNumber;
    }

    public function getChapterNumber()
    {
    	return $this->_chapterNumber;
    }

    /*public function setUserNumber()
    {
    	$userManager = new UserManager();
    	$this->_userNumber = $userManager->count();
    }

    public function setCommentNumber()
    {
    	$commentManager = new CommentManager();
    	$this->_commentNumber = $commentManager->count();
    }

    public function setChapterNumber()
    {
    	$chapterManager = new ChapterManager();
    	$this->_chapterNumber = $chapterManager->count();
    }*/
}