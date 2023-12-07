<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\Controller;

use App\Core\Request;
use App\Core\Response;

class ReportController extends Controller
{
    public function index()
    {
        $accounts = $this->db->get_all('accounts')->fetch_all(MYSQLI_ASSOC);

        $summaryAccountData = [];

        $invoices = $this->db->get_all('invoices')->fetch_all(MYSQLI_ASSOC);

        foreach ($accounts as $account) {
            $total = 0;
            $numRows = 0;

            foreach ($invoices as $invoice) {
                if ($invoice['account_id'] == $account['id']) {
                    $total += $invoice['total'];
                    $numRows += 1;
                }
            }

            $tmpArr = [
                'account' => $account,
                'invoice' => [
                    'count' => $numRows,
                    'total' => $total
                ]
            ];

            $summaryAccountData[] = $tmpArr;
        }

        return $this->render('reports/index', [
            'summaryAccountData' => $summaryAccountData,
            'invoices' => $invoices
        ]);
    }
}
