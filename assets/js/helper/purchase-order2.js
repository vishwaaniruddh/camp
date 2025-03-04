fetchVendors();
document.addEventListener("DOMContentLoaded", function () {

    const urlParams = new URLSearchParams(window.location.search);
    const purchase_order = urlParams.get('purchase-order');

    const addPoFormData = document.querySelector("#addPoFormData");
    const editPoFormData = document.querySelector("#editPoFormData");

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
    if (editPoFormData) {
        document.querySelector("#editPoFormData").addEventListener("submit", function (e) {
            e.preventDefault();
            updatePO();
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
function updatePO() {
    const form = document.querySelector("#editPoFormData");
    const formData = new FormData(form);

    fetch('./api/PO/update-purchase-order.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alertify.success(`Purchase Order Updated successfully! PO ID: ${data.po_id}`);
                // form.reset();
                setTimeout(() => {
                    
                    window.location="./purchase-orders.php";
                }, 2000);
            } else {
                alertify.error('Failed to update purchase order');
            }
        })
        .catch(error => {
            console.error('Error updating purchase order:', error);
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
                <td>
                <a href="./purchase-order-action.php?purchase-order=${po.po_number}">${po.po_number}</a>
                </td>
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
        const stockElement = row.querySelector('.stock');
        const unitCostElement = row.querySelector('.unit-cost');

        if (stockElement && unitCostElement) {
            const stock = parseFloat(stockElement.value) || 0;
            const unitCost = parseFloat(unitCostElement.value) || 0;
            totalCost += stock * unitCost;
        }
    });

    const totalCostElement = document.getElementById('total_cost');
    if (totalCostElement) {
        totalCostElement.value = totalCost.toFixed(2);
    } else {
        console.error('Error: Total cost element not found.');
    }
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

    setTimeout(() => {
        fetch(`./api/PO/fetch-purchase-order.php?purchase-order=${purchase_order}`)
            .then(response => response.json())
            .then(data => {

                console.log(data);

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
    }, 1000);

}

function populateProductForm(data) {
    const po = data.po;
    const items = data.items;

    // Determine the current page
    const currentPage = window.location.pathname.split('/').pop();

    const productRows = document.querySelector("#product-rows");
    productRows.innerHTML = '';


    if (currentPage === 'edit-purchase-orders.php') {
        // Populate PO details
        document.querySelector("#po_id").value = po.po_id;

        document.querySelector("#po_number").value = po.po_number;
        document.querySelector("#vendor").value = po.vendor;
        document.querySelector("#order_date").value = po.order_date;
        document.querySelector("#expected_delivery_date").value = po.expected_delivery_date;
        document.querySelector("#total_cost").value = po.total_amount;
        document.querySelector("#notes").value = po.notes;
    } else if (currentPage === 'purchase-order-action.php') {

        console.log(po)
        document.querySelector("#po_number").innerHTML = po.po_number;
        document.querySelector("#vendor").innerHTML = po.vendor;
        document.querySelector("#order_date").innerHTML = po.order_date;
        document.querySelector("#expected_delivery_date").innerHTML = po.expected_delivery_date;
        document.querySelector("#total_cost").innerHTML = po.total_amount;
        document.querySelector("#notes").innerHTML = po.notes;

    }


    // Populate items
    for (let i = 0; i < items.name.length; i++) {
        const newRow = document.createElement('tr');
        newRow.classList.add('product-row');

        if (currentPage === 'edit-purchase-orders.php') {


            console.log(`${items.name[i]}  ---  ${items.model_name[i]}`);
            newRow.innerHTML = `
            <input type="hidden" name="item_id[]" value="${items.item_id[i]}" />
                <td class="serial-number">${i + 1}</td>
                <td>
                    <select class="form-control product_name_model" name="product_name[]" required>
                    </select>
                </td>

                <td><input type="number" class="form-control stock" name="quantity[]" value="${items.quantity[i]}" required></td>
                <td><input type="number" step="0.01" class="form-control unit-cost" name="unit_cost[]" value="${items.unit_price[i]}" required></td>
                
            `;

            fetch('./api/products/fetch-products.php')
                .then(response => response.json())
                .then(products => {
                    const select = newRow.querySelector('.product_name_model');
                    select.innerHTML = '<option value="">Select Product</option>'; // Reset options

                    products.products.forEach(product => {
                        let optionValue = `${product.name}  ---  ${product.model}`;
                        let selected = optionValue === `${items.name[i]}  ---  ${items.model_name[i]}` ? 'selected' : '';
                        select.innerHTML += `<option value="${optionValue}" ${selected}>${optionValue}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching product list:', error));


        } else if (currentPage === 'purchase-order-action.php') {
            const receivedStatus = items.receivedStatus[i] || 'Not Updated';
            const receivedQuantity = items.receivedQuantity[i] || '0';
            const notes = items.notes[i] || 'No notes';

            newRow.innerHTML = `
                <td class="serial-number">${i + 1}</td>
                <td><span>${items.name[i]}</span></td>
                <td><span>${items.model_name[i]}</span></td>
                <td><span>${items.quantity[i]}</span></td>
                <td><span>${items.unit_price[i]}</span></td>
                <td>
    <span>Status: ${receivedStatus}</span><br>
    <span>Quantity: ${receivedQuantity}</span><br>
    <span>Notes: ${notes}</span><br>
    ${receivedStatus === 'Pending' || receivedStatus === 'Partly Received' ? `
        <button type="button" class="btn btn-warning btn-sm update-status-btn" 
            data-po-id="${po.po_id}" data-po-number="${po.po_number}" 
            data-itemkey="${items.item_id[i]}" data-status="Pending">Pending</button>
        <button type="button" class="btn btn-success btn-sm update-status-btn" 
            data-po-id="${po.po_id}" data-po-number="${po.po_number}" 
            data-itemkey="${items.item_id[i]}" data-status="Fully Received" 
            data-quantity="${items.quantity[i]}">Fully Received</button>
        <button type="button" class="btn btn-info btn-sm update-status-btn" 
            data-po-id="${po.po_id}" data-po-number="${po.po_number}" 
            data-itemkey="${items.item_id[i]}" data-status="Partly Received" 
            data-original-quantity="${items.quantity[i]}">Partly Received</button>
    ` : receivedStatus !== 'Fully Received' ? `
        <button type="button" class="btn btn-secondary btn-sm show-update-options-btn" 
            data-po-id="${po.po_id}" data-po-number="${po.po_number}" 
            data-itemkey="${items.item_id[i]}" data-status="${receivedStatus}">Update</button>
        <div class="update-options" style="display: none;">
            <button type="button" class="btn btn-warning btn-sm update-status-btn" 
                data-po-id="${po.po_id}" data-po-number="${po.po_number}" 
                data-itemkey="${items.item_id[i]}" data-status="Pending">Pending</button>
            <button type="button" class="btn btn-success btn-sm update-status-btn" 
                data-po-id="${po.po_id}" data-po-number="${po.po_number}" 
                data-itemkey="${items.item_id[i]}" data-status="Fully Received" 
                data-quantity="${items.quantity[i]}">Fully Received</button>
            <button type="button" class="btn btn-info btn-sm update-status-btn" 
                data-po-id="${po.po_id}" data-po-number="${po.po_number}" 
                data-itemkey="${items.item_id[i]}" data-status="Partly Received" 
                data-original-quantity="${items.quantity[i]}">Partly Received</button>
        </div>
    ` : ''}
</td>
            `;
        }

        // Add event listeners for the new row
        if (currentPage === 'edit-purchase-orders.php') {
            // newRow.querySelector('.remove-row').addEventListener('click', function () {
            //     newRow.remove();
            //     calculateTotalCost();
            //     updateSerialNumbers();
            // });
            newRow.querySelector('.stock').addEventListener('input', calculateTotalCost);
            newRow.querySelector('.unit-cost').addEventListener('input', calculateTotalCost);
        }

        productRows.appendChild(newRow);
    }

    // Update serial numbers
    updateSerialNumbers();
    // Recalculate total cost
    calculateTotalCost();

    // Add event listeners for status update buttons
    document.querySelectorAll('.update-status-btn').forEach(button => {
        button.addEventListener('click', function () {
            const poId = this.getAttribute('data-po-id');
            const poNumber = this.getAttribute('data-po-number');
            const status = this.getAttribute('data-status');
            const itemkey = this.getAttribute('data-itemkey');

            if (status === 'Pending') {
                alertify.prompt('Update Status', 'Enter notes:', '',
                    function (evt, value) {
                        po_product_update(poId, poNumber, status, value, '', itemkey);
                    },
                    function () {
                        alertify.error('Cancel');
                    });
            } else if (status === 'Partly Received') {
                const originalQuantity = parseFloat(this.getAttribute('data-original-quantity'));
                alertify.confirm(`
                    <div>
                        <label for="quantity">Enter quantity:</label>
                        <input type="number" id="qty_quantity" class="ajs-input alertify-input" required>
                    </div>
                    <div>
                        <label for="notes">Enter notes:</label>
                        <textarea id="qty_notes" class="ajs-input alertify-textarea" required></textarea>
                    </div>
                `, function () {
                    const quantity = parseFloat(document.getElementById('qty_quantity').value);
                    const notes = document.getElementById('qty_notes').value;
                    if (quantity > originalQuantity) {
                        alertify.error('Entered quantity is greater than the original quantity.');
                    } else {
                        po_product_update(poId, poNumber, status, notes, quantity, itemkey);
                    }
                }, function () {
                    alertify.error('Cancel');
                }).set({ labels: { ok: 'Submit', cancel: 'Cancel' }, title: 'Update Status' });
            } else if (status === 'Fully Received') {
                const quantity = this.getAttribute('data-quantity');
                const notes = 'Fully received';
                po_product_update(poId, poNumber, status, notes, quantity, itemkey);
            } else {
                po_product_update(poId, poNumber, status, '', '', itemkey);
            }
        });
    });

    // Add event listeners for show update options buttons
    document.querySelectorAll('.show-update-options-btn').forEach(button => {
        button.addEventListener('click', function () {
            const updateOptions = this.nextElementSibling;
            if (updateOptions) {
                updateOptions.style.display = 'block';
            }
        });
    });
}

function po_product_update(poId, poNumber, status, notes = '', quantity = '', itemkey) {
    // Placeholder function to handle the update
    console.log(`Updating PO ${poNumber} to status ${status} with notes: ${notes}, quantity: ${quantity}, and itemkey: ${itemkey}`);

    fetch('./api/PO/update-po-status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ po_id: poId, po_number: poNumber, status: status, notes: notes, quantity: quantity, itemkey: itemkey })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success(`Purchase Order status updated to ${status}`);
                fetchSinglePurchaseOrder(poNumber); // Reload data to reflect the new status
            } else {
                alertify.error('Failed to update Purchase Order status');
            }
        })
        .catch(error => {
            console.error('Error updating Purchase Order status:', error);
            alertify.error('An unexpected error occurred.');
        });
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



document.addEventListener("DOMContentLoaded", function () {
    function fetchCampProducts() {
        fetch('./api/products/fetch-products.php') // Fetch product data from server
            .then(response => response.json())
            .then(data => {
                document.querySelectorAll(".product_name_model").forEach(dropdown => {
                    dropdown.innerHTML = '<option value="">Select Product</option>'; // Reset dropdown


                    data.products.forEach(product => {
                        let option = document.createElement("option");
                        option.value = product.name + '  ---  ' + product.model;
                        option.textContent = product.name + '  ---  ' + product.model;
                        option.setAttribute("data-cost", product.purchase_price);
                        dropdown.appendChild(option);
                    });
                });
            })
            .catch(error => console.error("Failed to fetch products:", error));
    }

    // Fetch products on page load
    fetchCampProducts();

    // Update unit cost when product is selected
    document.addEventListener("change", function (event) {
        if (event.target.classList.contains("product_name_model")) {
            let selectedOption = event.target.selectedOptions[0];
            let unitCost = selectedOption.getAttribute("data-cost") || 0;
            event.target.closest(".product-row").querySelector(".unit-cost").value = unitCost;
        }
    });

    // Dynamically add new rows
    document.querySelector(".add-row").addEventListener("click", function () {
        let firstRow = document.querySelector(".product-row");
        let newRow = firstRow.cloneNode(true);

        // Clear inputs
        newRow.querySelectorAll("input").forEach(input => input.value = "");

        document.querySelector("table tbody").appendChild(newRow);

        fetchCampProducts();
    });

    // Remove row
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-row")) {
            event.target.closest(".product-row").remove();
        }
    });
});


