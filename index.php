<?php

use \classes\Router;

require_once 'classes/_config.php';
	
\classes\MyAutoload::start();
	
$request = (isset($_GET['r']))?$_GET['r']:'home.html';
	
$router = new Router($request);
$router->renderController();
