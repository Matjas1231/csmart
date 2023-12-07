<div>
    <?php include_once(__DIR__ . '/../shared/homePageButton.php'); ?>

    <?php if (!empty($invoices)) : ?>
        <table class="table table-sm table-hover table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Numer dokumentu</th>
                    <th>Id Konta</th>
                    <th>Data</th>
                    <th>Suma</th>
                    <th>Akcja</th>
                </tr>
            </thead>
            <tbod>
                <?php foreach ($invoices as $invoice) : ?>
                    <?php include(__DIR__ . '/partial/invoiceTableRow.php'); ?>

                <?php endforeach; ?>
            </tbod>
        </table>
    <?php else : ?>
        <div>
            Brak faktur
        </div>
        <div>
            <a href="/invoices/create" class="btn btn-sm btn-primary">Dodaj fakturę</a>
        </div>
    <?php endif; ?>
</div>