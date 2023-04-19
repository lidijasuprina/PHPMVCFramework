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
    public Request $request;
    public Response $response;
    public Router $router;
    public static Application $app;

    public function __construct($rootPath) 
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run() 
    {
        echo $this->router->resolve();
    }

}