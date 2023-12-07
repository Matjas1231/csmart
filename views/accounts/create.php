<div>
    <?php include_once(__DIR__ . '/../shared/homePageButton.php'); ?>
    <?php include_once(__DIR__ . '/../shared/messageDiv.php'); ?>

    <div>
        <?php include_once(__DIR__ . '/partial/form.php'); ?>
    </div>
</div>

<script>
    const form = document.querySelector('#form');
    const actionUrl = form.action;
    const messageDiv = document.querySelector('#messageDiv');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const inputs = form.querySelectorAll('input');
        const body = {}

        inputs.forEach((input) => {
            body[input.name] = input.value;
        })

        fetch(actionUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(body)
            })
            .then((response) => response.json())
            .then((data) => {

                if (data.errors) {
                    const errors = Object.entries(data.errors);
                    let errorList = '';
                    for (const [fieldName, error] of errors) {
                        errorList += `
                        <li>${error}</li>
                        `

                        const input = document.querySelector(`#${fieldName}`);
                        input.classList.add('is-invalid');
                    }

                    messageDiv.innerHTML = `<ul>${errorList}</ul>`;
                    messageDiv.classList.add('alert-danger');
                    messageDiv.style.display = '';
                } else {
                    sessionStorage.setItem('success', 'Dodano konto');
                    window.location = '/';
                }

            })


    })
</script>