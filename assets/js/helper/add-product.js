
fetchCategories();
fetchUnits();
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


function fetchCategories() {
    return fetch('./api/category/fetch-categories.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateCategoryOptions(data.categories);
            } else {
                alertify.error('Failed to fetch categories');
            }
        })
        .catch(error => {
            console.error('Error fetching categories:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function populateCategoryOptions(categories) {
    const categorySelect = document.querySelector("#category");
    if (!categorySelect) {
        console.error('Category select element not found');
        return;
    }
    categorySelect.innerHTML = "";
    if (categories.length === 0) {
        categorySelect.innerHTML = `<option value="">No categories available</option>`;
    } else {
        categories.forEach(category => {
            const option = document.createElement("option");
            option.value = category.name;
            option.textContent = category.name;
            categorySelect.appendChild(option);
        });
    }
}

function fetchUnits() {
    return fetch('./api/units/fetch-units.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateUnitOptions(data.units);
            } else {
                alertify.error('Failed to fetch units');
            }
        })
        .catch(error => {
            console.error('Error fetching units:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function populateUnitOptions(units) {
    const unitsSelect = document.querySelector("#units");
    if (!unitsSelect) {
        console.error('Units select element not found');
        return;
    }
    unitsSelect.innerHTML = "";
    if (units.length === 0) {
        unitsSelect.innerHTML = `<option value="">No units available</option>`;
    } else {
        units.forEach(unit => {
            const option = document.createElement("option");
            option.value = unit.unitname;
            option.textContent = unit.unitname;
            unitsSelect.appendChild(option);
        });
    }
}





