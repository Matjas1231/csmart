<div>
    <?php include_once(__DIR__ . '/../shared/homePageButton.php'); ?>

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
            <?php include(__DIR__ . '/partial/invoiceTableRow.php'); ?>
        </tbod>
    </table>

    <hr>
    <h1>Produkty</h1>

    <table class="table table-sm table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Ilość</th>
                <th>Cena netto</th>
                <th>Vat</th>
                <th>Cena brutto</th>
                <th>Suma Brutto</th>
            </tr>
        </thead>
        <tbod>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><?= $product['id']; ?></td>
                    <td><?= $product['product_name']; ?></td>
                    <td><?= $product['quantity']; ?></td>
                    <td><?= $product['price_netto']; ?></td>
                    <td><?= $product['vat']; ?></td>
                    <td><?= $product['price_brutto']; ?></td>
                    <td><?= $product['total']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbod>
    </table>
</div>