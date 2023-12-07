<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;

use App\Core\Request;
use App\Core\Response;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = $this->db->get_all('invoices')->fetch_all(MYSQLI_ASSOC);

        return $this->render('invoices/index', ['invoices' => $invoices]);
    }

    public function show(Request $request, Response $response)
    {
        $id = (int) $request->getBody()['id'];

        if ($id === 0) {
            Application::$app->session->setFlash('error', 'Złe ID faktury');
            Application::$app->response->redirect('/');
        }

        $invoice = $this->db->get_row('invoices', $id);
        $products = $this->db->get_all_where('invoices_products', 'invoice_id = ' . $id)->fetch_all(MYSQLI_ASSOC);

        return $this->render('invoices/show', [
            'invoice' => $invoice,
            'products' => $products
        ]);
    }

    public function edit(Request $request, Response  $response)
    {
        $id = (int) $request->getBody()['id'];

        if ($id === 0) {
            Application::$app->session->setFlash('error', 'Złe ID konta');
            Application::$app->response->redirect('/');
        }

        $accounts = $this->db->get_all('accounts')->fetch_all(MYSQLI_ASSOC);

        if (count($accounts) === 0) {
            Application::$app->session->setFlash('error', 'Brak dostępnych kont w bazie. Najpierw dodaj konto');
            Application::$app->response->redirect('/');
        }

        $row = $this->db->get_row('invoices', $id);
        $products = $this->db->get_all_where('invoices_products', 'invoice_id = ' . $id)->fetch_all(MYSQLI_ASSOC);

        return $this->render('invoices/edit', [
            'invoice' => $row,
            'products' => $products,
            'accounts' => $accounts
        ]);
    }

    public function update(Request $request, Response  $response)
    {
        $data = $request->getContent();
        $invoiceProductsData = $data['products'];

        unset($data['products']);

        $invoiceData = $data;

        $invoiceFields = ['document_no', 'nip', 'date', 'account_id'];
        $invoiceProductFields = ['product_name', 'quantity', 'price_netto', 'vat'];

        $errors = [];

        foreach ($invoiceFields as $field) {
            if (!isset($invoiceData[$field]) || empty($invoiceData[$field])) {
                $errors[$field] = $field . ' is missing or empty.';
            }
        }

        foreach ($invoiceProductsData as $product) {
            foreach ($invoiceProductFields as $field) {
                if (!isset($product[$field]) || empty($product[$field])) {
                    $errors['products'][$product['fieldId']][$field] =
                        $field . ' is missing or empty.';
                }
            }
        }

        if (!empty($errors)) {
            $response->json(['errors' => $errors]);
            return $response;
        }

        $this->db->update('invoices', $invoiceData, $invoiceData['id']);

        $products = $this->db->get_all_where('invoices_products', 'invoice_id = ' . $invoiceData['id'])->fetch_all(MYSQLI_ASSOC);

        $idArray1 = array_column($invoiceProductsData, 'id');
        $idArray2 = array_column($products, 'id');

        $diff1 = array_diff($idArray1, $idArray2);
        $diff2 = array_diff($idArray2, $idArray1);

        $allDifferences = array_merge($diff1, $diff2);

        $productToDelete = array_unique($allDifferences);

        foreach ($invoiceProductsData as $product) {
            unset($product['fieldId']);
            $product['invoice_id'] = $invoiceData['id'];

            if (array_key_exists('id', $product)) {
                $this->db->update('invoices_products', $product, $product['id']);
            } else {
                $this->db->insert('invoices_products', $product);
            }
        }

        foreach ($productToDelete as $id) {
            $this->db->delete('invoices_products', $id);
        }


        $response->json(['success' => 'success']);
        return $response;
    }

    public function create()
    {
        $accounts = $this->db->get_all('accounts')->fetch_all(MYSQLI_ASSOC);

        if (count($accounts) === 0) {
            Application::$app->session->setFlash('error', 'Brak dostępnych kont w bazie. Najpierw dodaj konto');
            Application::$app->response->redirect('/');
        }

        return $this->render('invoices/create', ['accounts' => $accounts]);
    }

    public function store(Request $request, Response $response)
    {
        $data = $request->getContent();
        $invoiceProductsData = $data['products'];

        unset($data['products']);

        $invoiceData = $data;

        $invoiceFields = ['document_no', 'nip', 'date', 'account_id'];
        $invoiceProductFields = ['product_name', 'quantity', 'price_netto', 'vat'];

        $errors = [];

        foreach ($invoiceFields as $field) {
            if (!isset($invoiceData[$field]) || empty($invoiceData[$field])) {
                $errors[$field] = $field . ' is missing or empty.';
            }
        }

        foreach ($invoiceProductsData as $product) {
            foreach ($invoiceProductFields as $field) {
                if (!isset($product[$field]) || empty($product[$field])) {
                    $errors['products'][$product['fieldId']][$field] =
                        $field . ' is missing or empty.';
                }
            }
        }

        if (!empty($errors)) {
            $response->json(['errors' => $errors]);
            return $response;
        }

        $this->db->insert('invoices', $invoiceData);

        $rows = $this->db->get_all('invoices')->fetch_all(MYSQLI_ASSOC);
        $id = $rows[array_key_last($rows)]['id'];

        foreach ($invoiceProductsData as $product) {
            unset($product['fieldId']);
            $product['invoice_id'] = $id;
            $this->db->insert('invoices_products', $product);
        }

        $response->json(['success' => 'success']);

        return $response;
    }
}
