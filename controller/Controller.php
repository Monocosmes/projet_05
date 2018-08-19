<?php

namespace controller;

use \classes\TemplateData;

abstract class Controller
{
	protected $templateData;

	public function __construct()
	{
		$this->setTemplateData();
	}

	public function templateData()
	{
		return $this->templateData;
	}

	public function setTemplateData()
	{
		$this->templateData = new TemplateData();
	}
}