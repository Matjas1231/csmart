<?php

namespace App\Core;



abstract class Controller
{
    public string $layout = 'layout'; // Domyślna nazwa głównego layout
    protected Db $db;

    public function __construct()
    {
        $this->db = new Db();
        $this->db->connect();
    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    // Metoda do ustawiania innych layotów, niż standardowe
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}
