document.getElementById("add_item_btn").addEventListener("click", function () {
    let boqNumber = this.getAttribute("data-boq-number").trim();
    
    let boqModal = document.getElementById("view_boq_modal");
    let modalInstance = bootstrap.Modal.getInstance(boqModal);
    modalInstance.hide();

    alertify.confirm(`
        <div>
            <label for="item_name">Enter Item Name:</label>
            <input type="text" id="item_name" class="ajs-input alertify-input" required>
        </div>
        <div>
            <label for="item_quantity">Enter Quantity:</label>
            <input type="number" id="item_quantity" class="ajs-input alertify-input" min="1" value="1" required>
        </div>
    `, function () {
        const itemName = document.getElementById("item_name").value.trim();
        const itemQuantity = parseFloat(document.getElementById("item_quantity").value);

        if (!itemName || isNaN(itemQuantity) || itemQuantity <= 0) {
            alertify.error("Invalid item name or quantity.");
            return;
        }

        // Call API to add the new item
        fetch("./api/boq/add-boq-item.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                boq_number: boqNumber,
                item_name: itemName,
                quantity: itemQuantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alertify.success("Item added successfully!");
                // viewBoqInfo(boqNumber); // Refresh BOQ items list
            } else {
                alertify.error(data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alertify.error("Something went wrong.");
        });

    }, function () {
        alertify.error("Cancelled");
    }).set({ labels: { ok: "Submit", cancel: "Cancel" }, title: "Add New Item" });
});



function fetchCustomers() {
    return fetch('./api/customer/fetch-customers.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateCustomerData(data.customers);
            } else {
                alertify.error('Failed to fetch Customers');
            }
        })
        .catch(error => {
            console.error('Error fetching Customers:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function populateCustomerData(customers) {

    const customerSelect = document.querySelector("#customer");
    if (!customerSelect) {
        console.error('customer select element not found');
        return;
    }
    customerSelect.innerHTML = "";

    // Add default first option
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select a Customer";
    customerSelect.appendChild(defaultOption);

    if (customers.length === 0) {
        customerSelect.innerHTML += `<option value="">No Customer available</option>`;
    } else {
        customers.forEach(customer => {
            const option = document.createElement("option");
            option.value = customer.name;
            option.textContent = customer.name;
            customerSelect.appendChild(option);
        });
    }
}

function fetchbanks() {
    return fetch('./api/bank/fetch-banks.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populatebankData(data.banks);
            } else {
                alertify.error('Failed to fetch banks');
            }
        })
        .catch(error => {
            console.error('Error fetching banks:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function populatebankData(banks) {

    const bankSelect = document.querySelector("#bank");
    if (!bankSelect) {
        console.error('bank select element not found');
        return;
    }
    bankSelect.innerHTML = "";

    // Add default first option
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select a bank";
    bankSelect.appendChild(defaultOption);

    if (banks.length === 0) {
        bankSelect.innerHTML += `<option value="">No bank available</option>`;
    } else {
        banks.forEach(bank => {
            const option = document.createElement("option");
            option.value = bank.name;
            option.textContent = bank.name;
            bankSelect.appendChild(option);
        });
    }
}


document.addEventListener("DOMContentLoaded", function () {

    const currentPage = window.location.pathname.split('/').pop();
    if (currentPage === 'boq-management.php') {

        fetchCustomers();
        fetchbanks();
        fetchBOQs();


        $("#addRow").click(function () {
            var newRow = `<tr>
                <td><input type="text" class="form-control" name="item_name[]" placeholder="Enter item name"></td>
                <td><input type="number" class="form-control" name="quantity[]" min="1" value="1"></td>
                <td><button type="button" class="btn btn-danger removeRow"><i class="fa fa-trash"></i></button></td>
            </tr>`;
            $("#boq_items_table tbody").append(newRow);
        });

        // Remove row
        $(document).on("click", ".removeRow", function () {
            $(this).closest("tr").remove();
        });

        // save boq

        document.getElementById("submit_adding_new_boq").addEventListener("submit", function (e) {
            e.preventDefault();

            let boqData = {
                customer: document.getElementById("customer").value,
                bank: document.getElementById("bank").value,
                boq_name: document.getElementById("boq_name").value,
                items: []
            };

            document.querySelectorAll("#boq_items_table tbody tr").forEach(row => {
                boqData.items.push({
                    item_name: row.querySelector("input[name='item_name[]']").value,
                    quantity: row.querySelector("input[name='quantity[]']").value
                });
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
                    console.log(data.message);
                    if (data.status === "success") {
                        alertify.success(`BOQ Added Successfully`);

                        fetchBOQs();

                    }
                })
                .catch(error => console.error("Error:", error));
        });


        // Fetch BOQ 

        function fetchBOQs() {
            fetch("./api/boq/get_boqs.php") // Update with actual API URL
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        displayBOQs(data.boqs);
                    } else {
                        console.error("Error fetching BOQs:", data.message);
                    }
                })
                .catch(error => console.error("Fetch error:", error));
        }

        function displayBOQs(boqs) {
            let tableBody = document.getElementById("boqTableBody");
            tableBody.innerHTML = ""; // Clear existing rows

            boqs.forEach((boq, index) => {
                let row = `<tr>
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
                </tr>`;
                tableBody.innerHTML += row;
            });
        }


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
        
                    if (data.status === "success" && data.items.length > 0) {
                        let tableHTML = `
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        document.getElementById("add_item_btn").setAttribute("data-boq-number", data.boq_number);

        
                        data.items.forEach((item, index) => {
                            tableHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.spare_name}</td>
                                    <td>${item.quantity}</td>
                                </tr>
                            `;
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

        

    }

});