document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    const addProductForm = document.querySelector("#addProductForm");
    const editProductForm = document.querySelector("#editProductForm");
    const messageElement = document.querySelector("#message");

    if (productId && editProductForm) {
        Promise.all([fetchCategories(), fetchUnits()])
            .then(() => {
                fetchProductDetails(productId);
            })
            .catch(error => {
                console.error('Error fetching categories or units:', error);
                alertify.error('An unexpected error occurred.');
            });
    }

    if (addProductForm) {
        addProductForm.addEventListener("submit", function (e) {
            e.preventDefault();
            addOrUpdateProduct(productId);
        });
    }

    if (editProductForm) {
        editProductForm.addEventListener("submit", function (e) {
            e.preventDefault();
            addOrUpdateProduct(productId);
        });
    }

    if (document.querySelector("#productTableBody")) {
        fetchProducts();
    }    

});

function fetchProducts() {
    fetch('./api/products/fetch-products.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateProductTable(data.products);
            } else {
                alertify.error('Failed to fetch products');
            }
        })
        .catch(error => {
            console.error('Error fetching products:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function populateProductTable(products) {
    const tableBody = document.querySelector("#productTableBody");
    if (!tableBody) {
        console.error('Table body element not found');
        return;
    }
    tableBody.innerHTML = "";
    if (products.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="9" class="text-center">No products found</td></tr>`;
    } else {
        products.forEach((product, index) => {
            const imagePath = product.image_path ? `./api/api/${product.image_path}` : 'assets/img/default-product.png';
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <h2 class="table-avatar">
                        <a href="edit-products.php?id=${product.id}" class="avatar avatar-md me-2 companies">
                            <img class="avatar-img sales-rep" src="${imagePath}" alt="Product Image">
                        </a>
                        <a href="edit-products.php?id=${product.id}">${product.name}</a>
                    </h2>
                </td>
                <td>${product.category}</td>
                <td>${product.units}</td>
                <td>Rs. ${parseFloat(product.purchase_price).toFixed(2)}</td>
                <td>${product.requires_serial_numbers}</td>
                <td>${product.alert_quantity}</td>


                <td class="d-flex align-items-center">
                    <div class="dropdown dropdown-action">
                        <a href="#" class="btn-action-icon" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul>
                                <li>
                                    <a class="dropdown-item" href="edit-products.php?id=${product.id}"><i class="far fa-edit me-2"></i>Edit</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_modal" data-product-id="${product.id}"><i class="far fa-trash-alt me-2"></i>Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }
}

function fetchProductDetails(productId) {
    fetch(`./api/products/get-product.php?id=${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateProductForm(data.product);
            } else {
                showMessage('Product not found');
                hideEditForm();
            }
        })
        .catch(error => {
            console.error('Error fetching product details:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function populateProductForm(product) {
    document.querySelector("#product_id").value = product.id;
    document.querySelector("#name").value = product.name;
    document.querySelector("#model").value = product.model;
    // document.querySelector("#sku").value = product.sku;
    document.querySelector("#category").value = product.category;
    document.querySelector("#purchase_price").value = product.purchase_price;
    document.querySelector("#units").value = product.units;
    // document.querySelector("#barcode").value = product.barcode;
    document.querySelector("#alert_quantity").value = product.alert_quantity;
    document.querySelector("#description").value = product.description;
    document.querySelector("#requires_serial_numbers").value = product.serial_numbers ? 'yes' : 'no';

    const imagePath = product.image_path ? `./api/api/${product.image_path}` : 'assets/img/default-product.png';
    document.querySelector("#current_image").src = imagePath;


}

// function generateSerialNumberFields(quantity, serialNumbers = []) {
//     const container = document.querySelector("#serialNumbersContainer");
//     container.innerHTML = "";

//     for (let i = 0; i < quantity; i++) {
//         const div = document.createElement("div");
//         div.className = "col-lg-4 col-md-6 col-sm-12 mb-3";
//         const input = document.createElement("input");
//         input.type = "text";
//         input.className = "form-control";
//         input.name = `serial_numbers[]`;
//         input.placeholder = `Enter Serial Number ${i + 1}`;
//         input.value = serialNumbers[i] || "";
//         div.appendChild(input);
//         container.appendChild(div);
//     }
// }


function generateSKU() {
    const skuField = document.querySelector("#sku");
    skuField.value = 'SKU-' + Math.random().toString(36).substr(2, 9).toUpperCase();
}

function generateBarcode() {
    const barcodeField = document.querySelector("#barcode");
    barcodeField.value = 'BAR-' + Math.random().toString(36).substr(2, 9).toUpperCase();
}

function addOrUpdateProduct(productId) {
    const form = document.querySelector(productId ? "#editProductForm" : "#addProductForm");
    const formData = new FormData(form);

    if (productId) {
        formData.append('id', productId);
    }

    fetch(productId ? './api/products/update-product.php' : './api/products/add-product.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success(productId ? 'Product updated successfully' : 'Product added successfully');
                if (!productId) {
                    form.reset();
                    
                 
                    

                } else {
                    
                    fetchProductDetails(productId); // Refresh the form with updated data
                    setTimeout(() => {
                        window.location.href="./product-list.php"; 
                     }, 2000);
                }
            } else {
                alertify.error(productId ? 'Failed to update product' : 'Failed to add product');
            }
        })
        .catch(error => {
            console.error(productId ? 'Error updating product:' : 'Error adding product:', error);
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

function showMessage(message) {
    const messageElement = document.querySelector("#message");
    if (messageElement) {
        messageElement.textContent = message;
        messageElement.style.display = 'block';
    }
}

function hideEditForm() {
    const editProductForm = document.querySelector("#editProductForm");
    if (editProductForm) {
        editProductForm.style.display = 'none';
    }
}