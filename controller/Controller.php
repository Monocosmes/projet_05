<?php

namespace controller;

use \classes\TemplateData;
use \model\PrivateMessageManager;
use \model\AnswerPMManager;
use \model\ViewPMManager;

abstract class Controller
{
	protected $templateData;

	public function __construct()
	{
		$this->setTemplateData();
	}

	public function sendPrivateMessage($params)
    {
        extract($params);

        $privateMessageManager = new PrivateMessageManager();
        $answerPMManager = new AnswerPMManager();
        
        $privateMessageId = $privateMessageManager->add($privateMessage);
        $answerPM->setPrivateMessageId($privateMessageId);
        
        $answerId = $answerPMManager->add($answerPM);

        $privateMessage->setId($privateMessageId);
        $privateMessage->setLastPMId($answerId);

        $privateMessageManager->update($privateMessage);

        $data =
        [
            'privateMessageId' => $privateMessageId,
            'answerId' => $answerId
        ];

        return $data;
    }

	public function templateData() {return $this->templateData;}

	public function setTemplateData()
	{
		$this->templateData = new TemplateData();
	}
}