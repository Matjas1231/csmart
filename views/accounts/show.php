<div>
    <?php include_once(__DIR__ . '/../shared/homePageButton.php'); ?>

    <table class="table table-sm table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Ulica</th>
                <th>Miasto</th>
                <th>Kod Pocztowy</th>
                <th>Kraj</th>
                <th>Numer telefonu</th>
                <th>Akcja</th>
            </tr>
        </thead>
        <tbod>
            <?php include_once(__DIR__ . '/partial/accountTableRow.php'); ?>
        </tbod>
    </table>

    <hr>

    <h1>Faktury</h1>

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
                    <?php include(__DIR__ . '/../invoices/partial/invoiceTableRow.php'); ?>
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