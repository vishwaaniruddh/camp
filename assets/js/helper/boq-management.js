document.addEventListener("DOMContentLoaded", function () {
    const currentPage = window.location.pathname.split('/').pop();
    
    if (currentPage === 'boq-management.php') {
        fetchData('./api/customer/fetch-customers.php', populateCustomerData, 'Customers');
        fetchData('./api/bank/fetch-banks.php', populateBankData, 'Banks');
        fetchData('./api/boq/get_boqs.php', displayBOQs, 'BOQs');

        // document.getElementById("addRow").addEventListener("click", addNewRow);
    }
    
    document.getElementById("add_item_btn").addEventListener("click", handleAddItem);
});

function fetchData(url, callback, label) {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success || data.status === "success") {
                callback(data[label.toLowerCase()] || []);
            } else {
                alertify.error(`Failed to fetch ${label}`);
            }
        })
        .catch(error => {
            console.error(`Error fetching ${label}:`, error);
            alertify.error('An unexpected error occurred.');
        });
}

function populateCustomerData(customers) {
    populateDropdown("#customer", customers, "Select a Customer", "No Customers available");
}

function populateBankData(banks) {
    populateDropdown("#bank", banks, "Select a Bank", "No Banks available");
}

function populateDropdown(selector, items, defaultText, emptyText) {
    const select = document.querySelector(selector);
    if (!select) return console.error(`${selector} element not found`);

    select.innerHTML = `<option value="">${defaultText}</option>`;
    select.innerHTML += items.length
        ? items.map(item => `<option value="${item.name}">${item.name}</option>`).join("")
        : `<option value="">${emptyText}</option>`;
}

function displayBOQs(boqs) {
    const tableBody = document.getElementById("boqTableBody");
    
    if (!boqs || boqs.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center">No records found</td>
            </tr>
        `;
        return;
    }

    tableBody.innerHTML = boqs.map((boq, index) => `
        <tr>
            <td>${index + 1}</td>
            <td>
                <a class="view-boq-btn" href="javascript:void(0);" 
                    data-bs-toggle="modal" 
                    data-bs-target="#view_boq_modal" 
                    data-boq-id="${boq.id}">
                        ${boq.boq_number}
                </a>
            </td>
            <td>${boq.customer_name || "N/A"}</td>
            <td>${boq.bank_name || "N/A"}</td>
            <td>${boq.created_at}</td>
        </tr>
    `).join("");
}


function handleAddItem() {
    let boqNumber = this.getAttribute("data-boq-number").trim();
    let boqModal = document.getElementById("view_boq_modal");
    bootstrap.Modal.getInstance(boqModal).hide();

    // Fetch product options dynamically
    fetch("./api/products/fetch-products.php")
        .then(response => response.json())
        .then(responseData => {
            if (!responseData.success || !responseData.products) {
                throw new Error("Invalid response format");
            }

            let productOptions = responseData.products.map(product => 
                `<option value="${product.id}" data-name="${product.name}">${product.name} (${product.model})</option>`
            ).join("");

            alertify.confirm(`
                <div>
                    <label>Select Item Name:</label>
                    <select id="item_name" class="ajs-input alertify-input">
                        ${productOptions}
                    </select>
                </div>
                <div>
                    <label>Enter Quantity:</label>
                    <input type="number" id="item_quantity" class="ajs-input alertify-input" min="1" value="1" required>
                </div>
            `, function () {
                const itemSelect = document.getElementById("item_name");
                const itemID = itemSelect.value;
                const itemName = itemSelect.options[itemSelect.selectedIndex].getAttribute("data-name");
                const itemQuantity = parseFloat(document.getElementById("item_quantity").value);

                if (!itemID || !itemName || isNaN(itemQuantity) || itemQuantity <= 0) {
                    return alertify.error("Invalid item selection or quantity.");
                }

                fetch("./api/boq/add-boq-item.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ 
                        boq_number: boqNumber, 
                        item_id: itemID, 
                        item_name: itemName, 
                        quantity: itemQuantity 
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alertify[data.status === "success" ? "success" : "error"](data.message || "Something went wrong.");
                })
                .catch(error => {
                    console.error("Error:", error);
                    alertify.error("Something went wrong.");
                });

            }, function () {
                alertify.error("Cancelled");
            }).set({ labels: { ok: "Submit", cancel: "Cancel" }, title: "Add New Item" });

        })
        .catch(error => {
            console.error("Error fetching products:", error);
            alertify.error("Failed to load product list.");
        });
}




function addNewRow() {
    fetch('./api/products/fetch-products.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (!data || !data.products || data.products.length === 0) {
                throw new Error("No products received");
            }
            createNewRow(data.products);
        })
        .catch(error => console.error('Error fetching product list:', error));
}

function createNewRow(products) {
    const tableBody = document.querySelector("#boq_items_table tbody");
    let newRow = document.createElement("tr");

    newRow.innerHTML = `
        <input type="hidden" name="item_id[]" value="">
        <td>
            <select class="form-control product_name_model" name="item_name[]" required>
                <option value="">Select Product</option>
                ${products.map(product => `
                    <option value="${product.name}  ---  ${product.model}" 
                            data-price="${product.purchase_price}">
                        ${product.name} --- ${product.model}
                    </option>
                `).join("")}
            </select>
        </td>
        <td><input type="number" class="form-control stock" name="quantity[]" value="1" min="1" required></td>
        <td><input type="number" step="0.01" class="form-control unit-cost" name="unit_cost[]" value="0.00" required readonly></td>
        <td><input type="number" step="0.01" class="form-control total-amount" name="total_amount[]" value="0.00" required readonly></td>
        <td><button type="button" class="btn btn-danger removeRow"><i class="fa fa-trash"></i></button></td>
    `;

    tableBody.appendChild(newRow);

    // Automatically attach event listener for product selection
    newRow.querySelector(".product_name_model").addEventListener("change", function (e) {
        let selectedOption = e.target.options[e.target.selectedIndex];
        let unitPrice = parseFloat(selectedOption.dataset.price) || 0;

        console.log("Selected Product:", selectedOption.value);
        console.log("Unit Price:", unitPrice);

        let row = e.target.closest("tr");
        if (row) {
            row.querySelector(".unit-cost").value = unitPrice.toFixed(2);
            row.querySelector(".stock").removeAttribute("readonly"); // Enable quantity input
            updateTotal(row);
        }
    });

    // Attach event listener for quantity change
    newRow.querySelector(".stock").addEventListener("input", function () {
        updateTotal(newRow);
    });
}

// Function to update total price (quantity × unit price)
function updateTotal(row) {
    let quantity = parseInt(row.querySelector(".stock").value) || 1;
    let unitPrice = parseFloat(row.querySelector(".unit-cost").value) || 0;
    let totalAmount = quantity * unitPrice;

    row.querySelector(".total-amount").value = totalAmount.toFixed(2);
}

// Event listener for adding new row
document.getElementById("addRow").addEventListener("click", addNewRow);

// Event listener for removing row
document.addEventListener("click", function (e) {
    if (e.target.closest(".removeRow")) {
        e.target.closest("tr").remove();
    }
});


// Event Delegation for removing rows
document.querySelector("#boq_items_table tbody").addEventListener("click", function (event) {
    if (event.target.closest(".removeRow")) {
        event.target.closest("tr").remove();
    }
});
document.getElementById("submit_adding_new_boq").addEventListener("submit", function (e) {
    e.preventDefault();

    let boqData = {
        customer: document.getElementById("customer").value,
        bank: document.getElementById("bank").value,
        boq_name: document.getElementById("boq_name").value,
        items: []
    };

    document.querySelectorAll("#boq_items_table tbody tr").forEach(function (row) {
        let itemSelect = row.querySelector("select[name='item_name[]']"); // Fix: Get select element
        let quantityInput = row.querySelector("input[name='quantity[]']");
        let unitcostInput = row.querySelector("input[name='unit_cost[]']");

        if (itemSelect && quantityInput) { 
            let selectedItem = itemSelect.options[itemSelect.selectedIndex]; // Get selected option

            boqData.items.push({
                item_name: selectedItem.value, // Get item name from select
                quantity: quantityInput.value,
                unit_cost: unitcostInput.value
            });
        }
    });


    fetch("./api/boq/save_boq.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(boqData)
    })
    .then(response => response.json())
    .then(data => {
        // console.log('ajax calling');
        if (data.status === "success") {
            // location.reload();
            // displayBOQs();
window.location.reload();
            // console.log(data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});


document.getElementById("boqTableBody").addEventListener("click", function (event) {
    if (event.target.classList.contains("view-boq-btn")) {
        const requestId = event.target.getAttribute("data-boq-id");
        console.log(requestId);
         viewBoqInfo(requestId);  
    }
});


function viewBoqInfo(requestId) {
    setTimeout(() => {
        fetch(`./api/boq/fetch-boq-items.php`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ boq_id: requestId })
        })
        .then(response => response.json())
        .then(data => {
            const boqItemsContainer = document.getElementById("boqItems");

            console.log(data.boq_number)
            console.log(data)
            if (data.status === "success") {

                document.getElementById("boq_number").innerHTML = data.boq_number;
                let tableHTML = `
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>`
                ;
                document.getElementById("add_item_btn").setAttribute("data-boq-number", data.boq_id);
                // document.getElementById("add_item_btn").setAttribute("data-boq-id", data.boq_id);
                data.items.forEach((item, index) => {
                    tableHTML += 
                        `<tr>
                            <td>${index + 1}</td>
                            <td>${item.spare_name}</td>
                            <td>${item.quantity}</td>
                        </tr>`
                    ;
                });

                tableHTML += `</tbody></table>`;
                boqItemsContainer.innerHTML = tableHTML;

            } else {
                boqItemsContainer.innerHTML = '<p class="text-danger">No Items found.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching BOQ items:', error);
            alertify.error('An unexpected error occurred.');
        });
    }, 1000);
}


function addNewItem() {
    var boqNumber = document.getElementById("boq_number").textContent.trim();
    if (!boqNumber) {
        alertify.error("BOQ Number not found!");
        return;
    }

    alertify.prompt("Add Item to BOQ", "Enter Item Name:", "",
        function(evt, itemName) {
            if (!itemName) {
                alertify.error("Item name is required");
                return;
            }

            alertify.prompt("Enter Quantity:", "Enter Quantity:", "1",
                function(evt, quantity) {
                    if (!quantity || isNaN(quantity) || quantity <= 0) {
                        alertify.error("Enter a valid quantity");
                        return;
                    }

                    // Send API request
                    fetch("./api/boq/add-boq-item.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ boq_number: boqNumber, spare_name: itemName, quantity: quantity })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            alertify.success("Item added successfully");
                            viewBoqInfo(boqNumber); // Refresh BOQ list
                        } else {
                            alertify.error(data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alertify.error("An unexpected error occurred.");
                    });
                },
                function() {
                    alertify.error("Cancelled");
                }
            );
        },
        function() {
            alertify.error("Cancelled");
        }
    );
}