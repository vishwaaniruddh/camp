document.addEventListener("DOMContentLoaded", function () {
    const productInventory = document.querySelector("#productInventory");
    if (productInventory) {
        fetchProductsFromInventory();
    }
});





function fetchProductsFromInventory() {
    fetch('./api/inventory/fetch-inventory-stocks.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                populateProductInventory(data.products);
            } else {
                alertify.error('Failed to fetch products');
            }
        })
        .catch(error => {
            console.error('Error fetching products:', error);
            alertify.error('An unexpected error occurred.');
        });
}


function populateProductInventory(products) {
    const tableBody = document.querySelector("#productInventory");
    if (!tableBody) {
        console.error('Table body element not found');
        return;
    }
    tableBody.innerHTML = "";
    if (products.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="9" class="text-center">No products found</td></tr>`;
    } else {
        products.forEach((product, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${product.product_name}</td>
                <td>${product.product_model}</td>
                <td>${product.serial_number}</td>
                <td>Rs. ${parseFloat(product.unit_price).toFixed(2)}</td>
                <td>${product.working_status}</td>
                <td>${product.serial_number}</td>
                
                

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