document.addEventListener("DOMContentLoaded", function () {
    // Get the current page name
    let currentPage = window.location.pathname.split("/").pop();

    // If the page is add-customer-purchase-order.php, fetch dropdown data
    if (currentPage === "add-customer-purchase-order.php") {
        fetchCustomers();
        fetchBanks();
        fetchBoqs();
    }

    // Check if elements exist before adding event listeners
    let boqElement = document.getElementById("boq");
    if (boqElement) {
        boqElement.addEventListener("change", fetchBOQItems);
    }

    let formElement = document.getElementById("addCustomerPoFormData");
    if (formElement) {
        formElement.addEventListener("submit", function (e) {
            e.preventDefault();
            addCustomerPO();
        });
    }

    // Fetch purchase orders only if the page is customer-purchase-order.php
    if (currentPage === "customer-purchase-order.php") {
        let tableBody = document.getElementById("customerPurchaseOrderTableBody");
        if (tableBody) {
            fetchCustomerPurchaseOrders();
        }
    }

    if (currentPage === "edit-customer-purchase-orders.php") {

        const urlParams = new URLSearchParams(window.location.search);
        const purchase_order = urlParams.get('purchase_order_id');


        fetchCustomers();
        fetchBanks();
        fetchBoqs();
        fetchSingleCustomerPO(purchase_order);

        document.querySelector("#updateCustomerPoFormData").addEventListener("submit", function (e) {
            e.preventDefault();
            updateCustomerPO();
        });

    }


});

function fetchCustomerPurchaseOrders() {
    fetch("./api/customer-purchase-order/fetch-customer-purchase-orders.php")
        .then(response => response.json())
        .then(data => {
            if (data.status !== "success") {
                document.getElementById("customerPurchaseOrderTableBody").innerHTML =
                    `<tr><td colspan="8" class="text-center text-danger">${data.message}</td></tr>`;
                return;
            }

            let html = "";
            data.orders.forEach((order, index) => {
                html += `<tr>
                            <td>${index + 1}</td>
                            <td>${order.po_number}</td>
                            <td>${order.customer_name}</td>
                            <td>${order.bank_name}</td>
                            <td>${order.order_received_date}</td>
                            <td>${order.created_at}</td>
                            <td>
                                <span class="badge bg-${getStatusClass(order.status)}">
                                    ${order.status}
                                </span>
                            </td>
                            <td>
                                <a href="./edit-customer-purchase-orders.php?purchase_order_id=${order.id}" class="btn-action-icon me-2 edit-po-btn" data-courier-id="${order.id}"><i class="far fa-edit"></i></a>
                                <a href="javascript:void(0);" class="btn-action-icon delete-customer-po-btn" data-purchase-order="${order.id}"><i class="fe fe-trash-2"></i></a>


                            </td>
                        </tr>`;
            });

            document.getElementById("customerPurchaseOrderTableBody").innerHTML = html;
        })
        .catch(error => console.error("Error fetching orders:", error));
}

function getStatusClass(status) {
    switch (status) {
        case "pending": return "warning";
        case "approved": return "success";
        case "rejected": return "danger";
        default: return "secondary";
    }
}



async function fetchCustomers(selectedValue = null) {
    try {
        let response = await fetch("./api/customer/fetch-customers.php");
        let data = await response.json();

        let customerSelect = document.getElementById("customer");
        if (!customerSelect) return;

        customerSelect.innerHTML = '<option value="">Select Customer</option>';

        data.customers.forEach(customer => {
            let option = document.createElement("option");
            option.value = customer.id;
            option.textContent = customer.name;
            customerSelect.appendChild(option);
        });

        // Set selected value after populating options
        if (selectedValue) {
            customerSelect.value = selectedValue;
        }

    } catch (error) {
        console.error("Error fetching customers:", error);
    }
}

async function fetchBanks(selectedValue = null) {
    try {
        let response = await fetch("./api/bank/fetch-banks.php");
        let data = await response.json();

        let bankSelect = document.getElementById("bank");
        if (!bankSelect) return;

        bankSelect.innerHTML = '<option value="">Select Bank</option>';

        data.banks.forEach(bank => {
            let option = document.createElement("option");
            option.value = bank.id;
            option.textContent = bank.name;
            bankSelect.appendChild(option);
        });

        // Set selected value after populating options
        if (selectedValue) {
            bankSelect.value = selectedValue;
        }

    } catch (error) {
        console.error("Error fetching banks:", error);
    }
}

async function fetchBoqs(selectedValue = null) {
    try {
        let response = await fetch("./api/boq/get_boqs.php");
        let data = await response.json();

        let boqSelect = document.getElementById("boq");
        if (!boqSelect) return;

        boqSelect.innerHTML = '<option value="">Select BOQ</option>';

        data.boqs.forEach(boq => {
            let option = document.createElement("option");
            option.value = boq.id;
            option.textContent = boq.boq_number;
            boqSelect.appendChild(option);
        });

        // Set selected value after populating options
        if (selectedValue) {
            boqSelect.value = selectedValue;
        }

    } catch (error) {
        console.error("Error fetching BOQs:", error);
    }
}


function fetchBOQItems() {
    let boqId = document.getElementById("boq").value;
    let boqItemsContainer = document.getElementById("boq_items");
    let add_info = document.getElementById("add_info");

    if (!boqId) {

        add_info.innerHTML = ""; // Clear if no BOQ is selected
        boqItemsContainer.innerHTML = ""; // Clear if no BOQ is selected
        return;
    }

    fetch("./api/boq/fetch-boq-items.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ boq_id: boqId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status !== "success") {
                boqItemsContainer.innerHTML = `<p style='color:red;'>${data.message}</p>`;
                return;
            }

            if (data.items.length === 0) {
                boqItemsContainer.innerHTML = "<p>No items found for this BOQ.</p>";
                return;
            }

            let html = `<div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>`;

            data.items.forEach((item, index) => {
                html += `<tr>
                            <td>${index + 1}</td> <!-- Serial Number -->
                            <td>${item.spare_name}</td>
                            <td>${item.quantity}</td>
                        </tr>`;
            });

            html += `</tbody></table></div>`;
            boqItemsContainer.innerHTML = html;

            // Call add_info_container() after successfully loading BOQ items
            add_info_container();
        })
        .catch(error => {
            console.error("Error fetching BOQ items:", error);
            boqItemsContainer.innerHTML = "<p style='color:red;'>Failed to load BOQ items.</p>";
        });
}

function add_info_container() {
    let addInfoContainer = document.getElementById("add_info");

    if (!addInfoContainer) {
        console.error("Element with ID 'add_info' not found.");
        return;
    }

    let html = `<div class="table-responsive">
                    <table class="table table-bordered" id="info_table">
                        <thead>
                            <tr>
                                <th>ATM ID</th>
                                <th>Address</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="atm_id[]"></td>
                                <td><input type="text" class="form-control" name="address[]"></td>
                                <td><input type="text" class="form-control" name="remarks[]"></td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" onclick="addRow()">
                                        +
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                                        -
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="col-lg-12 col-md-12 col-sm-12"><hr />
                            </div>
                            
                `;

    addInfoContainer.innerHTML = html;
}

function addRow() {
    let table = document.getElementById("info_table").getElementsByTagName('tbody')[0];
    let newRow = table.insertRow();
    newRow.innerHTML = `<td><input type="text" class="form-control" name="atm_id[]"></td>
                        <td><input type="text" class="form-control" name="address[]"></td>
                        <td><input type="text" class="form-control" name="remarks[]"></td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm" onclick="addRow()">+</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">-</button>
                        </td>`;
}

function removeRow(button) {
    let row = button.parentNode.parentNode;
    let table = document.getElementById("info_table").getElementsByTagName('tbody')[0];

    if (table.rows.length > 1) {
        row.remove();
    } else {
        console.log("At least one row is required.");
    }
}

function saveInfo() {
    // alert("Data saved! (Implement actual save logic)");
}



function generatePONumber() {
    const skuField = document.querySelector("input[name='po_number']");
    skuField.value = 'CAMP-' + Math.random().toString(36).substr(2, 9).toUpperCase();
}

function generateSerialNumber() {
    const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const digits = "0123456789";

    let prefix = "";
    for (let i = 0; i < 3; i++) {
        prefix += letters[Math.floor(Math.random() * letters.length)];
    }

    let randomDigits = "";
    for (let i = 0; i < 4; i++) {
        randomDigits += digits[Math.floor(Math.random() * digits.length)];
    }

    let suffix = "";
    for (let i = 0; i < 3; i++) {
        suffix += letters[Math.floor(Math.random() * letters.length)];
    }

    const year = new Date().getFullYear();
    return `${prefix}-${randomDigits}-${suffix}-${year}`;
}

function addCustomerPO() {
    let form = document.getElementById("addCustomerPoFormData");

    if (!form) {
        console.error("Form with ID 'addCustomerPoFormData' not found.");
        return;
    }

    let formData = new FormData(form);

    fetch("./api/customer-purchase-order/add-customer-purchase-order.php", {
        method: "POST",
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alertify.success(`Customer Purchase Order added successfully! PO ID: ${data.po_id}`);

                // form.reset(); // Reset form after successful submission
            } else {
                alertify.error("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error submitting form:", error);
            alertify.error('Failed to add Customer Purchase Order. Please try again');
        });
}

function fetchSingleCustomerPO(purchaseOrderId) {
    fetch("./api/customer-purchase-order/fetch-single-customer-purchase-order.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ purchase_order_id: purchaseOrderId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status !== "success") {
                console.error("Error fetching order:", data.message);
                return;
            }
            let order = data.order;

            // Call dropdown functions with selected values
            fetchCustomers(order.customer_id);
            fetchBanks(order.bank_id);
            fetchBoqs(order.boq_id);
            
            // Populate form fields
            
            document.getElementById("purchase_order_id").value = order.id;
            document.getElementById("po_number").value = order.po_number;
            document.getElementById("order_received_date").value = order.order_received_date;
            document.getElementById("notes").value = order.notes || "";

            // Populate BOQ Items as Input Fields
            let itemsContainer = document.getElementById("boq_items");
            if (itemsContainer) {
                let html = `<table class="table table-bordered" id="info_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ATM ID</th>
                                    <th>Address</th>
                                    <th>Remarks</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>`;

                order.items.forEach((item, index) => {
                    html += `<tr>
                            <td>${index + 1}</td>
                            <td><input type="text" name="atm_id[]" class="form-control" value="${item.atm_id}"></td>
                            <td><input type="text" name="address[]" class="form-control" value="${item.address}"></td>
                            <td><input type="text" name="remarks[]" class="form-control" value="${item.remarks || ''}"></td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                                    -
                                </button>
                            </td>
                         </tr>`;
                });

                html += `</tbody></table>`;
                itemsContainer.innerHTML = html;
            }
        })
        .catch(error => {
            console.error("Error fetching order:", error);
        });
}


function populateCustomerPOData(order) {

    document.getElementById("po_number").value = order.po_number;
    document.getElementById("customer").value = order.customer_id; // select
    document.getElementById("bank").value = order.bank_id;  // select
    document.getElementById("order_received_date").value = order.order_received_date;
    document.getElementById("boq").value = order.boq_id; // select
    document.getElementById("notes").value = order.notes || "";

    // Populate Items Table
    let itemsContainer = document.getElementById("boq_items");
    if (itemsContainer) {
        let html = `<table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ATM ID</th>
                                <th>Address</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>`;

        order.items.forEach((item, index) => {
            html += `<tr>
                        <td>${index + 1}</td>
                        <td>${item.atm_id}</td>
                        <td>${item.address}</td>
                        <td>${item.remarks || "N/A"}</td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm" onclick="addRow()">
                                +
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                                -
                            </button>
                     </tr>`;
        });

        html += `</tbody></table>`;
        itemsContainer.innerHTML = html;
    }
}


function updateCustomerPO() {
    let form = document.getElementById("updateCustomerPoFormData");
    let formData = new FormData(form);

    // Collect BOQ Items dynamically
    let items = [];
    let rows = document.querySelectorAll("#info_table tbody tr");
    rows.forEach(row => {
        let atm_id = row.querySelector("input[name='atm_id[]']").value.trim();
        let address = row.querySelector("input[name='address[]']").value.trim();
        let remarks = row.querySelector("input[name='remarks[]']").value.trim();

        if (atm_id && address) { // Ensure required fields are not empty
            items.push({ atm_id, address, remarks });
        }
    });

    // Append collected data into the object
    let data = {
        purchase_order_id: formData.get("purchase_order_id"),
        po_number: formData.get("po_number"),
        order_received_date: formData.get("order_received_date"),
        customer_id: formData.get("customer"),
        bank_id: formData.get("bank"),
        boq_id: formData.get("boq"),
        notes: formData.get("notes"),
        items: items
    };

    // Send data to API
    fetch("./api/customer-purchase-order/update-customer-purchase-order.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(responseData => {
            if (responseData.status === "success") {
                console.log("Purchase Order Updated Successfully!");
                // Optionally reload or redirect
            } else {
                console.log("Error: " + responseData.message);
            }
        })
        .catch(error => {
            console.error("Error updating order:", error);
            console.log("Failed to update Purchase Order.");
        });
}
