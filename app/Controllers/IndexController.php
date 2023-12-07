<?php

namespace App\Controllers;

use App\Core\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return $this->render('home');
    }
}
