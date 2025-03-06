document.addEventListener("DOMContentLoaded", function () {
    fetchcustomers();

    // Add customer Form Submission
    document.querySelector("#addcustomerForm").addEventListener("submit", function (e) {
        e.preventDefault();
        addcustomer();
    });

    // Edit customer Form Submission
    document.querySelector("#editcustomerForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const customerId = document.querySelector("#editcustomerForm input[name='customer_id']").value;
        updatecustomer(customerId);
    });

    // Attach event listeners for delete buttons
    attachDeleteListeners();
});

function fetchcustomers() {
    fetch('./api/customer/fetch-customers.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populatecustomerTable(data.customers);
            } else {
                alertify.error('Failed to fetch customers');
                showNoDataMessage();
            }
        })
        .catch(error => {
            console.error('Error fetching customers:', error);
            alertify.error('An unexpected error occurred.');
            showNoDataMessage();
        });
}

function populatecustomerTable(customers) {
    const tableBody = document.querySelector("#customerTableBody");
    tableBody.innerHTML = "";
    if (customers.length === 0) {
        showNoDataMessage();
    } else {
        customers.forEach((customer, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${customer.name}</td>
                
                <td>
                ${customer.status === 'active'
                ? '<span class="badge bg-success-light d-inline-flex align-items-center">Active</span>'
                : '<span class="badge bg-danger-light d-inline-flex align-items-center">Deleted</span>'}
            </td>
                
                <td class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="btn-action-icon me-2 edit-customer-btn" data-customer-id="${customer.id}" data-bs-toggle="modal" data-bs-target="#edit_customer"><i class="fe fe-edit"></i></a>
                    <a href="javascript:void(0);" class="btn-action-icon delete-customer-btn" data-customer-id="${customer.id}" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="fe fe-trash-2"></i></a>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Attach event listeners for edit and delete buttons
        attachEditListeners();
        attachDeleteListeners();
    }
}

function showNoDataMessage() {
    const tableBody = document.querySelector("#customerTableBody");
    tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No customers found</td></tr>`;
}

function addcustomer() {
    const form = document.querySelector("#addcustomerForm");
    const formData = new FormData(form);

    fetch('./api/customer/add-customer.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('customer added successfully');
                fetchcustomers();
                form.reset();
                const modalElement = document.querySelector("#add_customer");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to add customer');
            }
        })
        .catch(error => {
            console.error('Error adding customer:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function updatecustomer(customerId) {
    const form = document.querySelector("#editcustomerForm");
    const formData = new FormData(form);
    formData.append('customer_id', customerId);

    fetch('./api/customer/update-customer.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('customer updated successfully');
                fetchcustomers();
                const modalElement = document.querySelector("#edit_customer");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to update customer');
            }
        })
        .catch(error => {
            console.error('Error updating customer:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function deletecustomer(customerId) {
    fetch('./api/customer/delete-customer.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: customerId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('customer deleted successfully');
                fetchcustomers();
            } else {
                alertify.error('Failed to delete customer');
            }
        })
        .catch(error => {
            console.error('Error deleting customer:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function attachEditListeners() {
    document.querySelectorAll(".edit-customer-btn").forEach(button => {
        button.addEventListener("click", function () {
            const customerId = this.dataset.customerId;
            fetchcustomerData(customerId);
        });
    });
}

function attachDeleteListeners() {
    document.querySelectorAll(".delete-customer-btn").forEach(button => {
        button.addEventListener("click", function () {
            const customerId = this.dataset.customerId;
            document.querySelector("#delete_modal .btn-primary.paid-continue-btn").addEventListener("click", function () {
                deletecustomer(customerId);
            });
        });
    });
}

function fetchcustomerData(customerId) {
    fetch(`./api/customer/get-customer.php?id=${customerId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const customer = data.customer;
                document.querySelector("#editcustomerForm input[name='customer_id']").value = customer.id || "";
                document.querySelector("#editcustomerForm input[name='name']").value = customer.name || "";
                document.querySelector("#customer_status").value = customer.status || "";
            } else {
                alertify.error('Failed to fetch customer details');
            }
        })
        .catch(error => {
            console.error('Error fetching customer data:', error);
            alertify.error('An unexpected error occurred.');
        });
}