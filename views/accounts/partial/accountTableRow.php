<tr>
    <td><?= $account['id']; ?></td>
    <td><?= $account['name']; ?></td>
    <td><?= $account['street']; ?></td>
    <td><?= $account['city']; ?></td>
    <td><?= $account['postal_code']; ?></td>
    <td><?= $account['country']; ?></td>
    <td><?= $account['phone']; ?></td>
    <td>
        <a href="/accounts/edit?id=<?= $account['id']; ?>">Edytuj</a>

        <?php if (App\Core\Application::$app->request->getPath() !== '/accounts/show') : ?>
            <a href="/accounts/show?id=<?= $account['id']; ?>">Szczegóły</a>
        <?php endif; ?>
    </td>
</tr>