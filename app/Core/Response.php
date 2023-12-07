<?php

namespace App\Core;

class Response
{
    private $jsonData;

    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function json($data)
    {
        $this->setHeader('Content-Type: application/json');
        $this->jsonData = json_encode($data);
    }

    protected function setHeader(string $header)
    {
        header($header);
    }

    public function __toString()
    {
        return $this->jsonData;
    }
}
