document.addEventListener("DOMContentLoaded", function () {
    const productInventory = document.querySelector("#productInventory");
    if (productInventory) {
        fetchProductsFromInventory();
    }
});

function fetchProductsFromInventory(page = 1, limit = 10) {
    fetch(`./api/inventory/fetch-inventory-stocks.php?page=${page}&limit=${limit}`)
        .then(response => response.json())
        .then(data => {
            if (data.success === true) {
                populateProductInventory(data.data, page, limit);
                setupPagination(data.pagination.total_pages, page);

            } else {
                alertify.error('Failed to fetch products');
            }
        })
        .catch(error => {
            console.error('Error fetching products:', error);
            alertify.error('An unexpected error occurred.');
        });
}

// function populateProductInventory(products,page,limit) {
//     const inventoryTable = document.getElementById('inventory-table-body');
//     inventoryTable.innerHTML = '';

//     products.forEach((product.index) => {
//         const row = document.createElement('tr');
//         const serialNumber = (page - 1) * limit + index + 1;

//         row.innerHTML = `

//         <td>${product.id}</td>
// show serial number here 
//             <td>${product.product_name}</td>
//             <td>${product.product_model}</td>
//             <td>${product.serial_number}</td>
//             <td>${product.unit_price}</td>
//             <td>${product.working_status}</td>
//             <td>${product.material_tag}</td>
//             <td>${product.entry_date}</td>
//             <td>${product.status}</td>
//             <td>${product.remarks}</td>
//         `;
//         inventoryTable.appendChild(row);
//     });
// }

function setupPagination(totalPages, currentPage) {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = '';

    const maxVisiblePages = 5; // Number of visible page links
    const halfVisiblePages = Math.floor(maxVisiblePages / 2);

    const ul = document.createElement('ul');
    ul.classList.add('pagination', 'pagination-sm', 'mb-0');

    // Create "First" button
    const firstLi = document.createElement('li');
    firstLi.classList.add('page-item');
    if (currentPage === 1) firstLi.classList.add('disabled');
    const firstLink = document.createElement('a');
    firstLink.classList.add('page-link');
    firstLink.href = '#';
    firstLink.textContent = 'First';
    firstLink.addEventListener('click', function (e) {
        e.preventDefault();
        fetchProductsFromInventory(1);
    });
    firstLi.appendChild(firstLink);
    ul.appendChild(firstLi);

    // Create "Prev" button
    const prevLi = document.createElement('li');
    prevLi.classList.add('page-item');
    if (currentPage === 1) prevLi.classList.add('disabled');
    const prevLink = document.createElement('a');
    prevLink.classList.add('page-link');
    prevLink.href = '#';
    prevLink.textContent = 'Previous';
    prevLink.addEventListener('click', function (e) {
        e.preventDefault();
        fetchProductsFromInventory(currentPage - 1);
    });
    prevLi.appendChild(prevLink);
    ul.appendChild(prevLi);

    // Calculate start and end page numbers
    let startPage = Math.max(1, currentPage - halfVisiblePages);
    let endPage = Math.min(totalPages, currentPage + halfVisiblePages);

    if (currentPage <= halfVisiblePages) {
        endPage = Math.min(totalPages, maxVisiblePages);
    } else if (currentPage + halfVisiblePages >= totalPages) {
        startPage = Math.max(1, totalPages - maxVisiblePages + 1);
    }

    // Create page number buttons
    for (let i = startPage; i <= endPage; i++) {
        const pageLi = document.createElement('li');
        pageLi.classList.add('page-item');
        if (i === currentPage) pageLi.classList.add('active');
        const pageLink = document.createElement('a');
        pageLink.classList.add('page-link');
        pageLink.href = '#';
        pageLink.textContent = i;
        pageLink.addEventListener('click', function (e) {
            e.preventDefault();
            fetchProductsFromInventory(i);
        });
        pageLi.appendChild(pageLink);
        ul.appendChild(pageLi);
    }

    // Create "Next" button
    const nextLi = document.createElement('li');
    nextLi.classList.add('page-item');
    if (currentPage === totalPages) nextLi.classList.add('disabled');
    const nextLink = document.createElement('a');
    nextLink.classList.add('page-link');
    nextLink.href = '#';
    nextLink.textContent = 'Next';
    nextLink.addEventListener('click', function (e) {
        e.preventDefault();
        fetchProductsFromInventory(currentPage + 1);
    });
    nextLi.appendChild(nextLink);
    ul.appendChild(nextLi);

    // Create "Last" button
    const lastLi = document.createElement('li');
    lastLi.classList.add('page-item');
    if (currentPage === totalPages) lastLi.classList.add('disabled');
    const lastLink = document.createElement('a');
    lastLink.classList.add('page-link');
    lastLink.href = '#';
    lastLink.textContent = 'Last';
    lastLink.addEventListener('click', function (e) {
        e.preventDefault();
        fetchProductsFromInventory(totalPages);
    });
    lastLi.appendChild(lastLink);
    ul.appendChild(lastLi);

    paginationContainer.appendChild(ul);
}

// Initial fetch
document.addEventListener('DOMContentLoaded', () => {
    fetchProductsFromInventory();
});

function populateProductInventory(products, page, limit) {
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
            const serialNumber = (page - 1) * limit + index + 1;

            let workingStatusBadge = '';
            if (product.working_status === 'Not Working') {
                if (product.not_working_type === 'Repairable') {
                    workingStatusBadge = `
                        <span class="badge bg-danger-light d-inline-flex align-items-center">Not Working</span>
                        <span class="badge bg-warning d-inline-flex align-items-center">${product.not_working_type}</span>
                    `;
                } else if (product.not_working_type === 'Non-Repairable') {
                    workingStatusBadge = `
                        <span class="badge bg-danger-light d-inline-flex align-items-center">Not Working</span>
                        <span class="badge bg-danger-light d-inline-flex align-items-center">${product.not_working_type}</span>
                        <span class="badge bg-danger-light d-inline-flex align-items-center">${product.non_repairable_reason}</span>
                    `;
                }
            } else {
                workingStatusBadge = '<span class="badge bg-success-light d-inline-flex align-items-center">Working</span>';
            }

            row.innerHTML = `
                <td>${serialNumber}</td>
                <td><strong>${product.product_name.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')}</strong></td>
                <td>${product.product_model}</td>
                <td>${product.serial_number}</td>
                <td>Rs. ${parseFloat(product.unit_price).toFixed(2)}</td>
                <td>${workingStatusBadge}</td>
                <td>${product.entry_date}</td>
                
                 <td>
                ${product.status === 'Available'
                ? '<span class="badge bg-success-light d-inline-flex align-items-center">Available</span>'
                : '<span class="badge bg-danger-light d-inline-flex align-items-center">Not Available</span>'}
            </td>


                
                </td>

                
                 <td class="d-flex align-items-center">
                    <a class="dropdown-item edit-product-btn" href="#" data-product-id="${product.id}" data-bs-toggle="modal" data-bs-target="#edit_inventory"><i class="far fa-edit me-2"></i>Edit</a>
                </td>
            `;
            tableBody.appendChild(row);
        });

        document.querySelectorAll('.edit-product-btn').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                fetchProductInfo(productId);
            });
        });


    }
}


function fetchProductInfo(productId) {
    fetch(`./api/inventory/fetch-product-info.php?product_id=${productId}`)
        .then(response => response.json())
        .then(data => {

            console.table(data.product)
            if (data.success=== true) {
                populateProductInfoModal(data.product);
            } else {
                alertify.error('Failed to fetch product information');
            }
        })
        .catch(error => {
            console.error('Error fetching product information:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function populateProductInfoModal(product) {
    document.getElementById('product_name').value = product.product_name;
    document.getElementById('product_model').value = product.product_model;
    document.getElementById('serial_number').value = product.serial_number;
    document.getElementById('unit_price').value = product.unit_price;
    document.getElementById('working_status').value = product.working_status;
    document.getElementById('not_working_type').value = product.not_working_type;
    document.getElementById('non_repairable_reason').value = product.non_repairable_reason;
    document.getElementById('material_tag').value = product.material_tag;
    document.getElementById('status').value = product.status;

    // Show or hide additional fields based on working status
    const notWorkingTypeBlock = document.getElementById('not_working_type_block');
    const nonRepairableReasonBlock = document.getElementById('non_repairable_reason_block');

    if (product.working_status === 'Not Working') {
        notWorkingTypeBlock.style.display = 'block';
        if (product.not_working_type === 'Non-Repairable') {
            nonRepairableReasonBlock.style.display = 'block';
        } else {
            nonRepairableReasonBlock.style.display = 'none';
        }
    } else {
        notWorkingTypeBlock.style.display = 'none';
        nonRepairableReasonBlock.style.display = 'none';
    }

    // Store the product ID in a hidden field for later use
    document.getElementById('product_id').value = product.id;
}

// Function to handle the update action
function updateProductInfo(event) {
    event.preventDefault();

    const productId = document.getElementById('product_id').value;
    const productName = document.getElementById('product_name').value;
    const productModel = document.getElementById('product_model').value;
    const serialNumber = document.getElementById('serial_number').value;
    const unitPrice = document.getElementById('unit_price').value;
    const workingStatus = document.getElementById('working_status').value;
    const notWorkingType = document.getElementById('not_working_type').value;
    const nonRepairableReason = document.getElementById('non_repairable_reason').value;
    const materialTag = document.getElementById('material_tag').value;
    const status = document.getElementById('status').value;

    const data = {
        id: productId,
        product_name: productName,
        product_model: productModel,
        serial_number: serialNumber,
        unit_price: unitPrice,
        working_status: workingStatus,
        not_working_type: notWorkingType,
        non_repairable_reason: nonRepairableReason,
        material_tag: materialTag,
        status: status
    };

    fetch('./api/inventory/update-product-info.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alertify.success('Product information updated successfully');
            fetchProductsFromInventory(); // Refresh the inventory list
        } else {
            alertify.error('Failed to update product information');
        }
    })
    .catch(error => {
        console.error('Error updating product information:', error);
        alertify.error('An unexpected error occurred.');
    });
}

// Add event listener to the update button
document.getElementById('edit_inventory_form').addEventListener('submit', updateProductInfo);

// Example usage: Fetch product info when an edit button is clicked
document.querySelectorAll('.edit-product-btn').forEach(button => {
    button.addEventListener('click', function () {
        const productId = this.getAttribute('data-product-id');
        fetchProductInfo(productId);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const addWorkingStatusSelect = document.getElementById('add_working_status');
    const addNotWorkingTypeBlock = document.getElementById('add_not_working_type_block');
    const addNotWorkingTypeSelect = document.getElementById('add_not_working_type');
    const addNonRepairableReasonBlock = document.getElementById('add_non_repairable_reason_block');

    addWorkingStatusSelect.addEventListener('change', function () {
        if (this.value === 'Not Working') {
            addNotWorkingTypeBlock.style.display = 'block';
        } else {
            addNotWorkingTypeBlock.style.display = 'none';
            addNonRepairableReasonBlock.style.display = 'none';
        }
    });

    addNotWorkingTypeSelect.addEventListener('change', function () {
        if (this.value === 'Non-Repairable') {
            addNonRepairableReasonBlock.style.display = 'block';
        } else {
            addNonRepairableReasonBlock.style.display = 'none';
        }
    });

    document.getElementById('add_inventory_form').addEventListener('submit', function (event) {
        event.preventDefault();

        const productName = document.getElementById('add_product_name').value;
        const productModel = document.getElementById('add_product_model').value;
        const serialNumber = document.getElementById('add_serial_number').value;
        const unitPrice = document.getElementById('add_unit_price').value;
        const workingStatus = document.getElementById('add_working_status').value;
        const notWorkingType = document.getElementById('add_not_working_type').value;
        const nonRepairableReason = document.getElementById('add_non_repairable_reason').value;
        const materialTag = document.getElementById('add_material_tag').value;
        const status = document.getElementById('add_status').value;
        const remarks = document.getElementById('add_remarks').value;

        const data = {
            product_name: productName,
            product_model: productModel,
            serial_number: serialNumber,
            unit_price: unitPrice,
            working_status: workingStatus,
            not_working_type: notWorkingType,
            non_repairable_reason: nonRepairableReason,
            material_tag: materialTag,
            status: status,
            remarks: remarks
        };

        fetch('./api/inventory/add-product-info.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('Product added successfully');
                fetchProductsFromInventory(); // Refresh the inventory list
            } else {
                alertify.error('Failed to add product');
            }
        })
        .catch(error => {
            console.error('Error adding product:', error);
            alertify.error('An unexpected error occurred.');
        });
    });
});