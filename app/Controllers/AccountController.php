<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;

use App\Core\Request;
use App\Core\Response;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = $this->db->get_all('accounts')->fetch_all(MYSQLI_ASSOC);

        return $this->render('accounts/index', ['accounts' => $accounts]);
    }

    public function show(Request $request, Response $response)
    {
        $id = (int) $request->getBody()['id'];

        if ($id === 0) {
            Application::$app->session->setFlash('error', 'Złe ID konta');
            Application::$app->response->redirect('/');
        }

        $account = $this->db->get_row('accounts', $id);
        $invoices = $this->db->get_all_where('invoices', 'account_id = ' . $id)->fetch_all(MYSQLI_ASSOC);

        return $this->render('accounts/show', [
            'account' => $account,
            'invoices' => $invoices
        ]);
    }

    public function edit(Request $request, Response  $response)
    {
        $id = (int) $request->getBody()['id'];

        if ($id === 0) {
            Application::$app->session->setFlash('error', 'Złe ID konta');
            Application::$app->response->redirect('/');
        }

        $row = $this->db->get_row('accounts', $id);

        return $this->render('accounts/edit', ['account' => $row]);
    }

    public function update(Request $request, Response $response)
    {
        $data = $request->getContent();

        $fields = ['id', 'city', 'country', 'name', 'phone', 'postal_code', 'street'];
        $errors = [];

        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $errors[$field] = $field . ' is missing or empty.';
            }
        }

        if (!empty($errors)) {
            $response->json(['errors' => $errors]);
        } else {
            $id = $data['id'];
            unset($data['id']);

            $response->json(['success' => 'success']);
            $this->db->update('accounts', $data, $id);
        }

        return $response;
    }

    public function create()
    {
        return $this->render('accounts/create');
    }

    public function store(Request $request, Response $response)
    {
        $data = $request->getContent();

        $fields = ['city', 'country', 'name', 'phone', 'postal_code', 'street'];
        $errors = [];

        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $errors[$field] = $field . ' is missing or empty.';
            }
        }

        if (!empty($errors)) {
            $response->json(['errors' => $errors]);
        } else {
            $response->json(['success' => 'success']);
            $this->db->insert('accounts', $data);
        }

        return $response;
    }
}
