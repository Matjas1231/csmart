<div>
    <?php include_once(__DIR__ . '/../shared/homePageButton.php'); ?>

    <?php if (!empty($accounts)) : ?>
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
                <?php foreach ($accounts as $account) : ?>
                    <?php include(__DIR__ . '/partial/accountTableRow.php'); ?>
                <?php endforeach; ?>
            </tbod>
        </table>
    <?php else : ?>
        <div>
            Brak Kont
        </div>
        <div>
            <a href="/accounts/create" class="btn btn-sm btn-primary">Dodaj konto</a>
        </div>
    <?php endif; ?>
</div>