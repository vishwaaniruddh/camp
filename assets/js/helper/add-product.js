document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("#addProductForm").addEventListener("submit", function (e) {
     console.log('sa')
        e.preventDefault();
        addProduct();
    });
});

function generateSKU() {
    const skuField = document.querySelector("input[name='sku']");
    skuField.value = 'SKU-' + Math.random().toString(36).substr(2, 9).toUpperCase();
}

function generateBarcode() {
    const barcodeField = document.querySelector("input[name='barcode']");
    barcodeField.value = 'BAR-' + Math.random().toString(36).substr(2, 9).toUpperCase();
}

function addProduct() {
    const form = document.querySelector("#addProductForm");
    const formData = new FormData(form);

    fetch('./api/products/add-product.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('Product added successfully');
                form.reset();
            } else {
                alertify.error('Failed to add product');
            }
        })
        .catch(error => {
            console.error('Error adding product:', error);
            alertify.error('An unexpected error occurred.');
        });
}







