<div>
    <?php include_once('../views/shared/messageDiv.php'); ?>

    <?php if (App\Core\Application::$app->session->getFlash('error')) : ?>
        <div class="alert alert-danger" id="messageDiv">
            <?= App\Core\Application::$app->session->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <ul>
        <li><a href="/accounts/create">Dodaj Konto</a></li>
        <li><a href="/invoices/create">Dodaj fakturę</a></li>
        <li><a href="/accounts">Wyświetl konta</a></li>
        <li><a href="/invoices">Wyświetl faktury</a></li>
        <li><a href="/reports">Raporty</a></li>
    </ul>
</div>

<script>
    if (sessionStorage.success) {
        const messageDiv = document.querySelector('#messageDiv');

        messageDiv.innerHTML = sessionStorage.success;
        messageDiv.classList.add('alert-success');
        messageDiv.style.display = '';

        sessionStorage.removeItem('success');
    }
</script>