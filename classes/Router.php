<?php

namespace classes;

use \classes\View;
use \controller\frontend\Home;
use \controller\frontend\UserProfile;
use \controller\frontend\Entry;
use \controller\backend\Admin;

class Router
{
    private $request;
    private $routes =
    [
        'signin'                => ['controller' => '\controller\frontend\Entry', 'method' => 'signin'],
        'signin.html'           => ['controller' => '\controller\frontend\Entry', 'method' => 'showSigninPage'],
        'signup'                => ['controller' => '\controller\frontend\Entry', 'method' => 'signup'],
        'signup.html'           => ['controller' => '\controller\frontend\Entry', 'method' => 'showSignupPage'],
        'signoff'               => ['controller' => '\controller\frontend\Entry', 'method' => 'signoff'],

        'addNewMessage'         => ['controller' => '\controller\frontend\UserProfile', 'method' => 'addNewMessage'],
        'answerPrivateMessage'  => ['controller' => '\controller\frontend\UserProfile', 'method' => 'answerPrivateMessage'],
        'deleteAccount'         => ['controller' => '\controller\frontend\UserProfile', 'method' => 'deleteAccount'],
        'editProfile'           => ['controller' => '\controller\frontend\UserProfile', 'method' => 'showEditProfilePage'],
        'getUsers'              => ['controller' => '\controller\frontend\UserProfile', 'method' => 'getUsers'],
        'inbox'                 => ['controller' => '\controller\frontend\UserProfile', 'method' => 'showInboxPage'],
        'newMessage'            => ['controller' => '\controller\frontend\UserProfile', 'method' => 'showNewMessagePage'],
        'privateMessage'        => ['controller' => '\controller\frontend\UserProfile', 'method' => 'showPrivateMessagePage'],
        'profile'               => ['controller' => '\controller\frontend\UserProfile', 'method' => 'showProfilePage'],
        'profileSettings'       => ['controller' => '\controller\frontend\UserProfile', 'method' => 'showProfileSettingsPage'],
        'saveSettings'          => ['controller' => '\controller\frontend\UserProfile', 'method' => 'saveSettings'],
        'updateProfile'         => ['controller' => '\controller\frontend\UserProfile', 'method' => 'editProfile'],

        '403.html'              => ['controller' => '\controller\frontend\Home', 'method' => 'showHomePage'],
        'addPost'               => ['controller' => '\controller\frontend\Home', 'method' => 'addPost'],
        'allNews.html'          => ['controller' => '\controller\frontend\Home', 'method' => 'showAllArticlesPage'],
        'allTestimonies.html'   => ['controller' => '\controller\frontend\Home', 'method' => 'showTestimoniesPage'],
        'contact.html'          => ['controller' => '\controller\frontend\Home', 'method' => 'showContactPage'],
        'deletePost'            => ['controller' => '\controller\frontend\Home', 'method' => 'deletePost'],
        'editPost'              => ['controller' => '\controller\frontend\Home', 'method' => 'editPost'],
        'home.html'             => ['controller' => '\controller\frontend\Home', 'method' => 'showHomePage'],
        'news'                  => ['controller' => '\controller\frontend\Home', 'method' => 'showArticlePage'],
        'reportPost'            => ['controller' => '\controller\frontend\Home', 'method' => 'reportPost'],
        'testimony'             => ['controller' => '\controller\frontend\Home', 'method' => 'showTestimonyPage'],

        'addModerationMessage'  => ['controller' => '\controller\backend\Admin', 'method' => 'addModerationMessage'],
        'addNews'               => ['controller' => '\controller\backend\Admin', 'method' => 'addNews'],
        'addTestimony'          => ['controller' => '\controller\backend\Admin', 'method' => 'addTestimony'],
        'changeRank'            => ['controller' => '\controller\backend\Admin', 'method' => 'changeRank'],
        'dashboard.html'        => ['controller' => '\controller\backend\Admin', 'method' => 'showDashboardPage'],
        'deleteNews'            => ['controller' => '\controller\backend\Admin', 'method' => 'deleteNews'],
        'deleteTestimony'       => ['controller' => '\controller\backend\Admin', 'method' => 'deleteTestimony'],
        'editArticle'           => ['controller' => '\controller\backend\Admin', 'method' => 'showEditPage'],
        'editNews'              => ['controller' => '\controller\backend\Admin', 'method' => 'editNews'],
        'editTestimony'         => ['controller' => '\controller\backend\Admin', 'method' => 'editTestimony'],
        'highlight'             => ['controller' => '\controller\backend\Admin', 'method' => 'highlightNews'],
        'moderatePost'          => ['controller' => '\controller\backend\Admin', 'method' => 'moderatePost'],
        'newArticle.html'       => ['controller' => '\controller\backend\Admin', 'method' => 'showNewArticlePage'],
        'newTestimony.html'     => ['controller' => '\controller\backend\Admin', 'method' => 'showNewTestimonyPage'],
        'publish'               => ['controller' => '\controller\backend\Admin', 'method' => 'publishArticle'],
        'reportedPosts.html'    => ['controller' => '\controller\backend\Admin', 'method' => 'showReportedPostsPage'],
        'unreportPost'          => ['controller' => '\controller\backend\Admin', 'method' => 'unreportPost'],

        /*        
        'updateProfile'         => ['controller' => '\controller\frontend\Home', 'method' => 'updateProfile'],        
        

        

        'lockAccount'           => ['controller' => '\controller\backend\Admin', 'method' => 'lockAccount'],
        
        
        
        'savedPages.html'       => ['controller' => '\controller\backend\Admin', 'method' => 'showSavedPages'],
        'unlockAccount'         => ['controller' => '\controller\backend\Admin', 'method' => 'unlockAccount'],
        
        */
        
    ];

    public function __construct($request)
    {
        $this->request = $request;
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

        if(isset($this->routes[$route]) AND $this->routes[$route]['controller'] === '\controller\backend\Admin' AND $_SESSION['rank'] < 4 AND !$_SESSION['id'])
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