<?php

/**
 * summary
 */
class Router
{
    private $request;
    private $routes =
    [
        'deleteAccount'         => ['controller' => 'Entry', 'method' => 'deleteAccount'],
        'signin'                => ['controller' => 'Entry', 'method' => 'signin'],
        'signin.html'           => ['controller' => 'Entry', 'method' => 'showSigninPage'],
        'signup'                => ['controller' => 'Entry', 'method' => 'signup'],
        'signup.html'           => ['controller' => 'Entry', 'method' => 'showSignupPage'],
        'signoff'               => ['controller' => 'Entry', 'method' => 'signoff'],

        'addPost'               => ['controller' => 'Home', 'method' => 'addPost'],
        'allNews.html'          => ['controller' => 'Home', 'method' => 'showAllArticlesPage'],
        'allTestimonies.html'   => ['controller' => 'Home', 'method' => 'showTestimoniesPage'],
        'contact.html'          => ['controller' => 'Home', 'method' => 'showContact'],
        'deletePost'            => ['controller' => 'Home', 'method' => 'deletePost'],
        'editPost'              => ['controller' => 'Home', 'method' => 'editPost'],
        'home.html'             => ['controller' => 'Home', 'method' => 'showHomePage'],
        'news'                  => ['controller' => 'Home', 'method' => 'showArticlePage'],
        'testimony'             => ['controller' => 'Home', 'method' => 'showTestimonyPage'],

        'addNews'               => ['controller' => 'Admin', 'method' => 'addNews'],
        'addTestimony'          => ['controller' => 'Admin', 'method' => 'addTestimony'],
        'dashboard.html'        => ['controller' => 'Admin', 'method' => 'showDashboardPage'],
        'editArticle'           => ['controller' => 'Admin', 'method' => 'showEditPage'],
        'editNews'              => ['controller' => 'Admin', 'method' => 'editNews'],
        'editTestimony'         => ['controller' => 'Admin', 'method' => 'editTestimony'],
        'highlight'             => ['controller' => 'Admin', 'method' => 'highlightNews'],
        'newArticle.html'       => ['controller' => 'Admin', 'method' => 'showNewArticlePage'],
        'newTestimony.html'     => ['controller' => 'Admin', 'method' => 'showNewTestimonyPage'],
        'publish'               => ['controller' => 'Admin', 'method' => 'publishArticle'],




        /*

        'editProfile'           => ['controller' => 'Home', 'method' => 'showEditProfile'],
        
        'profile'               => ['controller' => 'Home', 'method' => 'showProfile'],
        'reportComment'         => ['controller' => 'Home', 'method' => 'reportComment'],
        'updateProfile'         => ['controller' => 'Home', 'method' => 'updateProfile'],        
        

        'addModerationMessage'  => ['controller' => 'Admin', 'method' => 'addModerationMessage'],
        
        'deleteChapter'         => ['controller' => 'Admin', 'method' => 'deleteChapter'],

        'lockAccount'           => ['controller' => 'Admin', 'method' => 'lockAccount'],
        'moderate'              => ['controller' => 'Admin', 'method' => 'moderate'],
        
        'reportedComments.html' => ['controller' => 'Admin', 'method' => 'showReportedComments'],
        'savedPages.html'       => ['controller' => 'Admin', 'method' => 'showSavedPages'],
        'unlockAccount'         => ['controller' => 'Admin', 'method' => 'unlockAccount'],
        'unreportComment'       => ['controller' => 'Admin', 'method' => 'unreportComment'],
        */
        
    ];

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function getParams()
    {
        $elements = explode('/', $this->request);
        unset($elements[0]);

        for($i = 1; $i < count($elements); $i++)
        {
            $params[$elements[$i]] = $elements[$i + 1];
            $i++;
        }

        if(!isset($params))
        {
            $params = null;
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

        if(isset($this->routes[$route]) AND $this->routes[$route]['controller'] === 'Admin' AND (!isset($_SESSION['rank']) OR $_SESSION['rank'] < 4))
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
            $home = new Home();
            $home->show404Page($params);
        }
    }
}