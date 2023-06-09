<?php

namespace app\core;

/**
* Class Application
*
* @author Lidija Šuprina <lidija.suprina7@gmail.com>
* @package app\core
*/

class Application 
{
    public static string $ROOT_DIR;
    public static Application $app;
    public string $userClass;
    public Request $request;
    public Response $response;
    public Router $router;
    public Session $session;
    public Controller $controller;
    public Database $db;
    public ?DbModel $user;

    public function __construct($rootPath, array $config) 
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        
        $this->db = new Database($config['db']);
        
        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run() 
    {
        echo $this->router->resolve();
    }

    public function getController()
    {
        return $this->controller;        
    }

    public function setController(\app\core\Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }
}