<?php

require_once '_config.php';

MyAutoload::start();

$request = (isset($_GET['r']))?$_GET['r']:'home.html';

$router = new Router($request);
$router->renderController();
