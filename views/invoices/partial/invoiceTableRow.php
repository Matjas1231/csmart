<tr>
    <td><?= $invoice['id']; ?></td>
    <td><?= $invoice['document_no']; ?></td>
    <td><?= $invoice['account_id']; ?></td>
    <td class="invoice_date"><?= $invoice['date']; ?></td>
    <td><?= $invoice['total']; ?></td>
    <td>
        <a href="/invoices/edit?id=<?= $invoice['id']; ?>">Edytuj</a>

        <?php if (App\Core\Application::$app->request->getPath() !== '/invoices/show') : ?>
            <a href="/invoices/show?id=<?= $invoice['id']; ?>">Szczegóły</a>
        <?php endif; ?>
    </td>
</tr>