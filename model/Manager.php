<?php

namespace model;

abstract class Manager
{
    protected $db;
    protected $dbName;

    public function __construct($dbName = null)
  	{
  		$this->db = new \PDO('mysql:host='.DBHOST.';dbname='.DBNAME.';charset=utf8', LOGIN, PASSWORD);
  		$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

  		if(!empty($dbName))
  		{
  			$this->setDbName($dbName);
  		}
  	}

  	public function setDbName($dbName)
  	{
  		$this->dbName = $dbName;
  	}
}
