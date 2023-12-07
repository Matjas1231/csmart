<div>
    <?php include_once(__DIR__ . '/../shared/homePageButton.php'); ?>
    <?php include_once(__DIR__ . '/../shared/messageDiv.php'); ?>

    <div>
        <?php include_once(__DIR__ . '/partial/form.php'); ?>
    </div>

</div>

<script type="module">
    import {
        updateSum,
        updateSumProduct,
        updateSumHandler,
        addProduct
    } from '/func.js';


    const addProductButton = document.querySelector('#add_product');
    const removeProductButton = document.querySelector('#remove_product');

    const form = document.querySelector('#form');
    const actionUrl = form.action;

    let sum = 0;
    let i = document.querySelectorAll(`div[id^="invoice_product_"]`).length;

    addProductButton.addEventListener('click', (event) => {
        event.preventDefault();
        addProduct(i);
        i += 1;
    });

    const products = document.querySelectorAll(`div[id^="invoice_product_"]`);

    products.forEach((product) => {
        const quantity = product.querySelector('#quantity');
        const vat = product.querySelector('#vat');
        const priceNetto = product.querySelector('#price_netto');

        quantity.addEventListener('input', updateSumHandler);
        vat.addEventListener('input', updateSumHandler);
        priceNetto.addEventListener('input', updateSumHandler);

    });

    removeProductButton.addEventListener('click', (event) => {
        event.preventDefault();

        const product = document.querySelector(`#invoice_product_${i-1}`);
        const line = document.querySelector(`#invoice_product_${i-1}_line`);

        const parentElement = product.parentElement;
        parentElement.removeChild(product)
        parentElement.removeChild(line)

        i -= 1;

        if (i === 1) {
            removeProductButton.disabled = true;
        }

        if (i < 5) {
            addProductButton.disabled = false;
        }
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const body = {
            products: []
        };
        const invoiceInputs = form.querySelector('#invoice').querySelectorAll('input');
        const select = form.querySelector('#account_id')

        invoiceInputs.forEach((input) => {
            body[input.name] = input.value;
        });

        body.account_id = select.value;

        const invoiceProducts = form.querySelectorAll('div[id^="invoice_product_"]');

        for (const product of invoiceProducts) {
            const productData = {
                fieldId: product.id
            }

            const inputs = product.querySelectorAll('input');

            inputs.forEach((input) => {
                productData[input.name] = input.value;
            });

            body.products.push(productData);
        }


        fetch(actionUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(body)
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.errors) {
                    let errorList = '';

                    for (const [id, error] of Object.entries(data.errors)) {
                        if (id === 'products') {
                            for (const [productId, productError] of Object.entries(error)) {
                                for (const [fieldName, errorProduct] of Object.entries(productError)) {
                                    errorList += `
                                            <li>${errorProduct}</li>
                                        `
                                    const productSection = document.querySelector(`#${productId}`);
                                    const input = productSection.querySelector(`#${fieldName}`);
                                    input.classList.add('is-invalid');
                                }
                            }

                        } else {
                            errorList += `
                                        <li>${error}</li>
                                    `

                            const input = document.querySelector(`#${id}`);
                            input.classList.add('is-invalid');
                        }
                    }

                    messageDiv.innerHTML = `<ul>${errorList}</ul>`;
                    messageDiv.classList.add('alert-danger');
                    messageDiv.style.display = '';
                } else {
                    sessionStorage.setItem('success', 'Zapisano');
                    window.location = '/';
                }
            })
    });
</script>