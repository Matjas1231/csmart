<?php
if (App\Core\Application::$app->request->getPath() !== '/invoices/create') {
    $input = '<input type="hidden" id="id" name="id" value="' . $invoice['id'] . '" required>';
    $action = '/invoices/update';
} else {
    $action = '/invoices/store';
}
?>

<form method="POST" action="<?= $action; ?>" id="form">
    <div id="invoice">
        <?= $input ?? null; ?>

        <label for="document_no" class="form-label">Numer dokumentu</label>
        <input type="text" id="document_no" name="document_no" placeholder="Numer Dokumentu" class="form-control" value="<?= $invoice['document_no'] ?? null; ?>" required>

        <label for="nip" class="form-label">NIP</label>
        <input type="text" id="nip" name="nip" placeholder="NIP" class="form-control" value="<?= $invoice['nip'] ?? null; ?>" required>

        <label for="account_id" class="form-label">Konto</label>

        <select id="account_id" class="form-select" required>
            <?php foreach ($accounts as $account) :
                if (App\Core\Application::$app->request->getPath() !== '/invoices/create') : ?>

                    <option value="<?= $account['id'] ?? null; ?>" <?= ($invoice['account_id'] === $account['id'] ? 'selected' : '') ?>><?= $account['name']; ?></option>
                <?php else : ?>
                    <option value="<?= $account['id'] ?? null; ?>"><?= $account['name']; ?></option>

            <?php endif;
            endforeach; ?>
        </select>

        <label for="date" class="form-label">Data</label>
        <input type="date" id="date" name="date" placeholder="Data" class="form-control" value="<?= $invoice['date'] ?? null; ?>" required>

        <label for="total" class="form-label">Suma brutto</label>
        <input type="number" id="total" name="total" placeholder="Suma" class="form-control" readonly value="<?= $invoice['total'] ?? null; ?>">
    </div>

    <hr class="mt-3 mb-2">

    <div id="products">
        <?php if (isset($products)) :
            for ($i = 0; $i < count($products); $i++) : ?>
                <div id="<?= 'invoice_product_' . $i ?>">
                    <input type="hidden" value="<?= $products[$i]['id']; ?>" name="id" id="product_id">

                    <div class="row">
                        <div class="col">
                            <label for="product_name" class="form-label">Nazwa produktu</label>
                            <input type="text" id="product_name" name="product_name" placeholder="Nazwa produktu" class="form-control" value="<?= $products[$i]['product_name'] ?>" required>

                        </div>
                        <div class="col">
                            <label for="quantity" class="form-label">Ilość</label>
                            <input type="number" id="quantity" name="quantity" placeholder="Ilość" class="form-control" value="<?= $products[$i]['quantity'] ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="price_netto" class="form-label">Cena netto</label>
                            <input type="text" id="price_netto" name="price_netto" placeholder="Cena netto" class="form-control price_netto" value="<?= $products[$i]['price_netto'] ?>" required>
                        </div>

                        <div class="col">
                            <label for="vat" class="form-label">VAT</label>
                            <input type="number" id="vat" name="vat" placeholder="VAT" class="form-control" value="<?= $products[$i]['vat'] ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="price_brutto" class="form-label">Cena brutto</label>
                            <input type="text" id="price_brutto" name="price_brutto" placeholder="Cena brutto" class="form-control price_brutto" readonly value="<?= $products[$i]['price_brutto'] ?>" required>
                        </div>
                        <div class="col">
                            <label for="total" class="form-label">Suma brutto</label>
                            <input type="text" id="total" name="total" placeholder="Suma brutto" class="form-control total" readonly value="<?= $products[$i]['total'] ?>" required>
                        </div>
                    </div>
                </div>
                <hr id="<?= 'invoice_product_' . $i . '_line' ?>">

        <?php endfor;
        endif; ?>
    </div>

    <button id="add_product" class="btn btn-sm btn-success">Dodaj kolejny produkt</button>
    <button id="remove_product" class="btn btn-sm btn-danger">Usuń ostatni produkt</button>

    <div>
        <button type="submit" class="mt-3 btn btn-sm btn-primary">Zapisz</button>
    </div>
</form>