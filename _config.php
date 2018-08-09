<?php

class MyAutoload
{
    public static function start()
    {
    	session_start();

        if(!isset($_SESSION['isLogged']))
        {
            $_SESSION['isLogged'] = false;
        }

        if(!isset($_SESSION['id']))
        {
            $_SESSION['id'] = 0;
            $_SESSION['login'] = '';
            $_SESSION['rank'] = 1;
        }

    	spl_autoload_register(array(__CLASS__, 'autoload'));

    	$root = $_SERVER['DOCUMENT_ROOT'];
		$host = $_SERVER['HTTP_HOST'];
		$siteName = '/projet_05/';

		require_once '_params.php';
		
		define('HOST', 'http://'.$host.$siteName);
		define('ROOT', $root.$siteName);
		
		define('CONTROLLER', ROOT.'controller/');
        define('CONTROLLERFRONT', ROOT.'controller/frontend/');
		define('CONTROLLERBACK', ROOT.'controller/backend/');
		define('VIEW', ROOT.'view/');
		define('MODEL', ROOT.'model/');
		define('CLASSES', ROOT.'classes/');
		
		define('ASSETS', HOST.'assets/');
    }

    public static function autoload($class)
    {
    	if(file_exists(MODEL.$class.'.php'))
    	{
    		require_once MODEL.$class.'.php';
    	}
    	else if(file_exists(CLASSES.$class.'.php'))
    	{
    		require_once CLASSES.$class.'.php';
    	}
        else if(file_exists(CONTROLLER.$class.'.php'))
        {
            require_once CONTROLLER.$class.'.php';
        }
    	else if(file_exists(CONTROLLERFRONT.$class.'.php'))
    	{
    		require_once CONTROLLERFRONT.$class.'.php';
    	}
    	else if(file_exists(CONTROLLERBACK.$class.'.php'))
    	{
    		require_once CONTROLLERBACK.$class.'.php';
    	}
    }
}
