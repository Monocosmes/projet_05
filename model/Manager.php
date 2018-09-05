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

    public function createQuery($addWhere, $query, $condition = null)
    {
        for($i = 0; $i < count($addWhere['champ']); $i++)
        {
            $query .= $addWhere['champ'][$i].' = :value'.$i;

            if(count($addWhere['champ']) > 1 AND $i < (count($addWhere['champ']) - 1))
            {
                $query .= ' '.$condition.' ';
            }
        }

        return $query; 
    }

  	public function setDbName($dbName)
  	{
  		$this->dbName = $dbName;
  	}
}
