<?php

namespace classes;

trait Validator
{
	public function isValid($data)
    {
    	if(isset($data))
    	{
    		if(is_int($data) OR is_bool($data))
            {
                $data = ($data === 0)?1:$data;
            }
            
            if(!empty($data))
            {
                return true;
            }
            else
            {
                $_SESSION['errors'][] = 'Un ou plusieurs champs sont vides';
                return false;
            }            
    	}
    	else
    	{
    		$_SESSION['errors'][] = 'Un ou plusieurs champs sont vides';
    		return false;
    	}
    }
}