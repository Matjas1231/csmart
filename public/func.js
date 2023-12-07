export const updateSum = () => {
    const totalInputs = document.querySelectorAll('.total');
    const totalInput = document.querySelector('#total');
    let total = 0;

    totalInputs.forEach((input) => {

        const inputValue = parseFloat(input.value) || 0;
        total += inputValue;
    });

    totalInput.value = total.toFixed(2);
}

export const updateSumProduct = (event) => {
    const id = event.target.parentElement.parentElement.parentElement.id.match(/\d/)[0]

    const productDiv = document.querySelector(`#invoice_product_${id}`);
    const vat = parseFloat(productDiv.querySelector('#vat').value)
    const netto = parseFloat(productDiv.querySelector('#price_netto').value);
    const quantity = parseFloat(productDiv.querySelector('#quantity').value);
    const total = productDiv.querySelector('#total');

    const price_brutto = parseFloat((netto * (1 + vat / 100)))
    const sum_brutto = parseFloat((netto * (1 + vat / 100)) * quantity);

    const brutto = productDiv.querySelector('#price_brutto')

    if (price_brutto) {
        brutto.value = price_brutto.toFixed(2);
        total.value = sum_brutto;
    } else {
        brutto.value = 0
        total.value = 0
    }
}

export const updateSumHandler = (event) => {
        updateSumProduct(event);
        updateSum();
    };

export const addProduct = (i) => {
    const productsDiv = document.querySelector('#products');
    const productTemplate = document.createElement('div');
    const addProductButton = document.querySelector('#add_product');
    const removeProductButton = document.querySelector('#remove_product');

    productTemplate.innerHTML = `
        <div id="invoice_product_${i}">
            <div class="row">
                <div class="col">
                    <label for="product_name" class="form-label">Nazwa produktu</label>
                    <input type="text" id="product_name" name="product_name" placeholder="Nazwa produktu" class="form-control" maxlength="255" required>
                
                </div>
                <div class="col">
                    <label for="quantity" class="form-label">Ilość</label>
                    <input type="number" id="quantity" name="quantity" placeholder="Ilość" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="price_netto" class="form-label">Cena netto</label>
                    <input type="text" id="price_netto" name="price_netto" placeholder="Cena netto" class="form-control price_netto" required>
                </div>

                <div class="col">
                    <label for="vat" class="form-label">VAT</label>
                    <input type="number" id="vat" name="vat" placeholder="VAT" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="price_brutto" class="form-label">Cena brutto</label>
                    <input type="text" id="price_brutto" name="price_brutto" placeholder="Cena brutto" class="form-control price_brutto" readonly required>
                </div>
                <div class="col">
                    <label for="total" class="form-label">Suma brutto</label>
                    <input type="text" id="total" name="total" placeholder="Suma brutto" class="form-control total" readonly required>
                </div>
            </div>
         </div>
         <hr id="invoice_product_${i}_line">
         `

    productsDiv.appendChild(productTemplate);

    if (i >= 4) {
        addProductButton.disabled = true;
    }

    if (i === 0) {
        removeProductButton.disabled = true;
    } else {
        removeProductButton.disabled = false;
    }

    const newPriceNettoInput = productTemplate.querySelector('.price_netto');
    const vat = productTemplate.querySelector('#vat')
    const quantity = productTemplate.querySelector('#quantity')

    newPriceNettoInput.addEventListener('input', updateSumHandler);
    vat.addEventListener('input', updateSumHandler);
    quantity.addEventListener('input', updateSumHandler);
}