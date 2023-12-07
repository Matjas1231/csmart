<?php

use App\Controllers\AccountController;
use App\Controllers\IndexController;
use App\Controllers\InvoiceController;
use App\Controllers\ReportController;
use App\Core\Application;

require_once '../vendor/autoload.php';

function dump($data)
{
    echo ('</br><div style="
            display: inline-block;
            border: 1px dashed gray;
            padding: 5px;
            background:lightgray;">
            <pre>');

    print_r($data);

    echo ('</pre> </div> </br>');
}
function dd($data)
{
    echo ('</br><div style="
            display: inline-block;
            border: 1px dashed gray;
            padding: 5px;
            background:lightgray;">
            <pre>');

    print_r($data);

    echo ('</pre> </div> </br>');
    exit('STOP');
}

$app = new Application(dirname(__DIR__));

$app->router->get('/', [IndexController::class, 'index']);

// Accounts routes
$app->router->get('/accounts', [AccountController::class, 'index']);
$app->router->get('/accounts/show', [AccountController::class, 'show']);
$app->router->get('/accounts/create', [AccountController::class, 'create']);
$app->router->get('/accounts/edit', [AccountController::class, 'edit']);
$app->router->patch('/accounts/update', [AccountController::class, 'update']);
$app->router->post('/accounts/store', [AccountController::class, 'store']);

// Invoices Rotues
$app->router->get('/invoices', [InvoiceController::class, 'index']);
$app->router->get('/invoices/show', [InvoiceController::class, 'show']);
$app->router->get('/invoices/edit', [InvoiceController::class, 'edit']);
$app->router->patch('/invoices/update', [InvoiceController::class, 'update']);
$app->router->get('/invoices/create', [InvoiceController::class, 'create']);
$app->router->post('/invoices/store', [InvoiceController::class, 'store']);

// Report Routes
$app->router->get('/reports', [ReportController::class, 'index']);

$app->run();
