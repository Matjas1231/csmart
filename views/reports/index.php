<div>
    <?php include_once(__DIR__ . '/../shared/homePageButton.php'); ?>

    <table class="table table-sm table-hover table-striped">
        <thead>
            <tr>
                <th>Id Konta</th>
                <th>Nazwa Konta</th>
                <th>Ilość faktur</th>
                <th>Suma kwot z faktur</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($summaryAccountData as $data) : ?>
                <tr>
                    <td><?= $data['account']['id']; ?></td>
                    <td><?= $data['account']['name']; ?></td>
                    <td><?= $data['invoice']['count']; ?></td>
                    <td><?= $data['invoice']['total']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <h1>Faktury</h1>

    <?php if (!empty($invoices)) : ?>
        <label for="filterDate">Filtruj według daty:</label>
        <input type="date" id="filter_date" onchange="filterInvoicesByDate()">

        <table class="table table-sm table-hover table-striped" id="invoices_table">
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

<script>
    const filterInvoicesByDate = () => {
        const inputDate = document.querySelector('#filter_date').value;

        if (isValidDate(inputDate)) {
            const invoiceRows = document.querySelectorAll('#invoices_table tbody tr');

            invoiceRows.forEach((row) => {
                const date = row.querySelector('.invoice_date').textContent;

                if (date !== inputDate) {
                    row.style.display = 'none';
                } else {
                    row.style.display = '';
                }
            })
        }

        if (!inputDate) {
            const invoiceRows = document.querySelectorAll('#invoices_table tbody tr');

            invoiceRows.forEach((row) => {
                row.style.display = '';
            })
        }
    }

    const isValidDate = (dateString) => {
        var regex = /^\d{4}-\d{2}-\d{2}$/;
        return regex.test(dateString);
    }
</script>