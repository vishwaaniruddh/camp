fetchVendors();
document.addEventListener("DOMContentLoaded", function () {

    const urlParams = new URLSearchParams(window.location.search);
    const purchase_order = urlParams.get('purchase-order');





    const addPoFormData = document.querySelector("#addPoFormData");
    const purchaseOrderTableBody = document.querySelector("#purchaseOrderTableBody");
    const edit_po_container = document.querySelector("#edit-po-container");

    if (addPoFormData) {
        document.getElementById('add-row').addEventListener('click', function () {
            var productRow = document.querySelector('.product-row');
            var newRow = productRow.cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelector('.remove-row').addEventListener('click', function () {
                newRow.remove();
                calculateTotalCost();
                updateSerialNumbers();
            });
            newRow.querySelector('.stock').addEventListener('input', calculateTotalCost);
            newRow.querySelector('.unit-cost').addEventListener('input', calculateTotalCost);
            document.getElementById('product-rows').appendChild(newRow);
            updateSerialNumbers();
        });


        document.querySelector("#addPoFormData").addEventListener("submit", function (e) {
            e.preventDefault();
            addPO();
        });
    }

    if (purchaseOrderTableBody) {

        fetchAllPOs();
    }

    if (purchase_order && edit_po_container) {

        fetchSinglePurchaseOrder(purchase_order);

    }



});



function generatePONumber() {
    const skuField = document.querySelector("input[name='po_number']");
    skuField.value = 'CAMP-' + Math.random().toString(36).substr(2, 9).toUpperCase();
}


function addPO() {
    const form = document.querySelector("#addPoFormData");
    const formData = new FormData(form);

    fetch('./api/PO/add-purchase-order.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alertify.success(`Purchase Order created successfully! PO ID: ${data.po_id}`);
                form.reset();
            } else {
                alertify.error('Failed to add Purchase Order');
            }
        })
        .catch(error => {
            console.error('Error adding Purchase Order:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function fetchAllPOs() {
    fetch('./api/PO/fetch-purchase-orders.php')
        .then(response => response.json())
        .then(data => {
            if (data.status == 'success') {
                populatePOData(data.data);
                setupDeleteAction();

            } else {
                alertify.error('Failed to fetch categories');
                showNoDataMessage();
            }
        })
        .catch(error => {
            console.error('Error fetching categories:', error);
            alertify.error('An unexpected error occurred.');
            showNoDataMessage();
        });
}

function getStatusBadge(status) {
    switch (status) {
        case 'Pending':
            return '<span class="badge bg-warning badge d-inline-flex align-items-center">Pending</span>';
        case 'Approved':
            return '<span class="badge bg-success d-inline-flex align-items-center">Approved</span>';
        case 'Fulfilled':
            return '<span class="badge bg-primary d-inline-flex align-items-center">Fulfilled</span>';
        case 'Cancelled':
            return '<span class="badge bg-danger d-inline-flex align-items-center">Cancelled</span>';
        case 'Deleted':
            return '<span class="badge bg-danger d-inline-flex align-items-center">Deleted</span>';
        default:
            return '<span class="badge bg-secondary d-inline-flex align-items-center">Unknown</span>';
    }
}



function populatePOData(categories) {
    const tableBody = document.querySelector("#purchaseOrderTableBody");
    tableBody.innerHTML = "";
    if (categories.length === 0) {
        showNoDataMessage();
    } else {
        categories.forEach((po, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${po.po_number}</td>
                <td>${po.vendor}</td>
                <td>${po.total_amount}</td>
                <td>${po.order_date}</td>
                <td>${po.expected_delivery_date}</td>
                <td>${getStatusBadge(po.status)}</td>
                <td>${po.created_at}</td>
                <td class="d-flex align-items-center">
                    <a href="./pdf/generate-pdf.php?purchase-order=${po.po_number}" class="btn-action-icon me-2 edit-po-btn"><i class="far fa-file-pdf"></i></a>
                    <a href="./edit-purchase-orders.php?purchase-order=${po.po_number}" class="btn-action-icon me-2 edit-po-btn"><i class="fe fe-edit"></i></a>
                    <a href="javascript:void(0);" class="btn-action-icon delete-po-btn" data-purchase-order="${po.po_id}" data-po-number="${po.po_number}" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="fe fe-trash-2"></i></a>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Add event listeners for delete buttons
    }
}

function setupDeleteAction() {
    // Select all delete buttons
    const deleteButtons = document.querySelectorAll(".delete-po-btn");
    // Add click event listener to each button
    deleteButtons.forEach(button => {
        button.addEventListener("click", () => {
            const purchaseOrder = button.getAttribute("data-purchase-order");

            if (purchaseOrder) {
                alertify.confirm("Are you sure you want to delete this Purchase Order ?", function (e) {
                    if (e) {
                        deletePurchseOrder(purchaseOrder); // Call your delete function with the purchase order ID
                    }
                });
            } else {
                console.error('Error: Purchase order ID is not set.');
            }

        });
    });
}

function showNoDataMessage() {
    const tableBody = document.querySelector("#purchaseOrderTableBody");
    tableBody.innerHTML = "<tr><td colspan='9' class='text-center'>No data available</td></tr>";
}

// Example function to handle the delete action
function calculateTotalCost() {
    let totalCost = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        const stock = parseFloat(row.querySelector('.stock').value) || 0;
        const unitCost = parseFloat(row.querySelector('.unit-cost').value) || 0;
        totalCost += stock * unitCost;
    });
    document.getElementById('total_cost').value = totalCost.toFixed(2);
}

function updateSerialNumbers() {
    document.querySelectorAll('.product-row').forEach((row, index) => {
        row.querySelector('.serial-number').textContent = index + 1;
    });
}



document.querySelectorAll('.remove-row').forEach(button => {
    button.addEventListener('click', function () {
        button.closest('tr').remove();
        calculateTotalCost();
        updateSerialNumbers();
    });
});

document.querySelectorAll('.stock, .unit-cost').forEach(input => {
    input.addEventListener('input', calculateTotalCost);
});

updateSerialNumbers();


function fetchVendors() {
    return fetch('./api/vendor/fetch_all_vendors.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateVendorsOptions(data.vendors);
            } else {
                alertify.error('Failed to fetch Vendors');
            }
        })
        .catch(error => {
            console.error('Error fetching Vendors:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function populateVendorsOptions(Vendors) {
    const vendorSelect = document.querySelector("#vendor");
    if (!vendorSelect) {
        console.error('vendor select element not found');
        return;
    }
    vendorSelect.innerHTML = "";

    // Add default first option
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select a vendor";
    vendorSelect.appendChild(defaultOption);

    if (Vendors.length === 0) {
        vendorSelect.innerHTML += `<option value="">No Vendors available</option>`;
    } else {
        Vendors.forEach(vendor => {
            const option = document.createElement("option");
            option.value = vendor.name;
            option.textContent = vendor.name;
            vendorSelect.appendChild(option);
        });
    }
}

// For Edit Purchase order

function fetchSinglePurchaseOrder(purchase_order) {
    fetch(`./api/PO/fetch-purchase-order.php?purchase-order=${purchase_order}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                populateProductForm(data);
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

function populateProductForm(data) {
    const po = data.po;
    const items = data.items;

    // Populate PO details
    document.querySelector("#po_number").value = po.po_number;
    document.querySelector("#vendor").value = po.vendor;
    document.querySelector("#order_date").value = po.order_date;
    document.querySelector("#expected_delivery_date").value = po.expected_delivery_date;
    document.querySelector("#total_cost").value = po.total_amount;
    document.querySelector("#notes").value = po.notes;

    // Clear existing product rows
    const productRows = document.querySelector("#product-rows");
    productRows.innerHTML = '';

    // Populate items
    for (let i = 0; i < items.name.length; i++) {
        const newRow = document.createElement('tr');
        newRow.classList.add('product-row');

        newRow.innerHTML = `
            <td class="serial-number">${i + 1}</td>
            <td><input type="text" class="form-control" name="product_name[]" value="${items.name[i]}" required></td>
            <td><input type="text" class="form-control" name="model_name[]" value="${items.model_name[i]}" required></td>
            <td><input type="number" class="form-control stock" name="quantity[]" value="${items.quantity[i]}" required></td>
            <td><input type="number" step="0.01" class="form-control unit-cost" name="unit_cost[]" value="${items.unit_price[i]}" required></td>
            <td><i class="fa fa-minus-circle me-1 remove-row"></i></td>
        `;

        // Add event listeners for the new row
        newRow.querySelector('.remove-row').addEventListener('click', function () {
            newRow.remove();
            calculateTotalCost();
            updateSerialNumbers();
        });
        newRow.querySelector('.stock').addEventListener('input', calculateTotalCost);
        newRow.querySelector('.unit-cost').addEventListener('input', calculateTotalCost);

        productRows.appendChild(newRow);
    }

    // Update serial numbers
    updateSerialNumbers();
    // Recalculate total cost
    calculateTotalCost();
}

function deletePurchseOrder(po_id) {
    fetch("./api/PO/delete-purchase-order.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ id: po_id }) // Send unit ID as JSON
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alertify.success("Purchase Order deleted successfully.");
                fetchAllPOs(); // Refresh the table
            } else {
                alertify.error("Failed to delete Purchase Order.");
            }
        })
        .catch(error => {
            console.error("Error deleting Purchase Order :", error);
            alertify.error("An unexpected error occurred.");
        });
}