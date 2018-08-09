<?php

abstract class Controller
{
	private $_footer;

	public function __construct()
	{
		$this->setFooter();
	}

	public function setFooter()
	{
		$this->footer = new Footer();
	}
}