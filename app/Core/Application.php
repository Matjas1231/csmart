<?php

namespace App\Core;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;

    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Controller $controller;
    public View $view;

    public function __construct($rootPath, array $config = [])
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();

        $this->view = new View();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
