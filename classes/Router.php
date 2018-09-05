<?php

namespace classes;

use \classes\View;
use \controller\frontend\ViewController;
use \controller\frontend\UserProfile;
use \controller\frontend\Entry;
use \controller\backend\Admin;

class Router
{
    private $request;
    private $routes = [];

    public function __construct($request)
    {
        $this->request = $request;

        $this->setRoutes('frontend');
        $this->setRoutes('backend');
    }

    public function getParams()
    {
        $params = null;

        $elements = explode('/', $this->request);
        unset($elements[0]);

        for($i = 1; $i < count($elements); $i++)
        {
            $params[$elements[$i]] = $elements[$i + 1];
            $i++;
        }

        if($_POST)
        {
            foreach($_POST as $key => $val)
            {
                $params[$key] = $val;
            }
        }       

        return $params;
    }

    public function getRoute()
    {
        $elements = explode('/', $this->request);

        return $elements[0];
    }

    public function renderController()
    {
        $route = $this->getRoute();
        $params = $this->getParams();

        if(isset($this->routes[$route]) AND preg_match('#backend#', $this->routes[$route]['controller']) AND $_SESSION['rank'] < 4 AND !$_SESSION['id'])
        {
            $myView = new View();
            $myView->redirect('home.html');
            //exit;
        }
        
        if(key_exists($route, $this->routes))
        {
            $controller = $this->routes[$route]['controller'];
            $method = $this->routes[$route]['method'];

            $currentController = new $controller();
            $currentController->$method($params);
        }
        else
        {
            $home = new ViewController();
            $home->show404Page($params);
        }
    }

    public function setRoutes($controller)
    {
        $xml = new \DOMDocument;
        
        $xml->load(ROOT.'controller/'.$controller.'/config/routes.xml');
    
        $routes = $xml->getElementsByTagName('route');

        foreach ($routes as $route) {
            $this->routes[$route->getAttribute('url')] = ['controller' => $route->getAttribute('controller'), 'method' => $route->getAttribute('method')];
        }
    }
}