<?php
if (App\Core\Application::$app->request->getPath() !== '/accounts/create') {
    $input = '<input type="hidden" id="id" name="id" value="' . $account['id'] . '" required>';
    $action = '/accounts/update';
} else {
    $action = '/accounts/store';
}
?>

<form method="POST" action="<?= $action; ?>" id="form">
    <div>
        <?= $input ?? null; ?>
        <label for="name" class="form-label">Nazwa</label>
        <input type="text" id="name" name="name" placeholder="Nazwa" class="form-control" value="<?= $account['name'] ?? null; ?>" maxlength="255" required>

        <label for="street" class="form-label">ulica</label>
        <input type="text" id="street" name="street" placeholder="Ulica" class="form-control" value="<?= $account['street'] ?? null; ?>" maxlength="255" required>

        <label for="city" class="form-label">Miasto</label>
        <input type="text" id="city" name="city" placeholder="Miasto" class="form-control" value="<?= $account['city'] ?? null; ?>" maxlength="255" required>

        <label for="postal_code" class="form-label">Kod Pocztowy</label>
        <input type="text" id="postal_code" name="postal_code" placeholder="Kod Pocztowy" class="form-control" value="<?= $account['postal_code'] ?? null; ?>" maxlength="255" required>

        <label for="country" class="form-label">Kraj</label>
        <input type="text" id="country" name="country" placeholder="Kraj" class="form-control" value="<?= $account['country'] ?? null; ?>" maxlength="255" required>

        <label for="phone" class="form-label">Numer Telefonu</label>
        <input type="text" id="phone" name="phone" placeholder="Numer Telefonu" class="form-control" value="<?= $account['phone'] ?? null; ?>" maxlength="20" required>
    </div>

    <button type="submit" class="mt-3 btn btn-sm btn-primary">Zapisz</button>
</form>