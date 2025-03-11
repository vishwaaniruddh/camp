document.addEventListener("DOMContentLoaded", function () {
    fetchcustomers();

    document.getElementById("applyFilters").addEventListener("click", function () {
        fetchcustomers();
    });
    document.getElementById("downloadCSV").addEventListener("click", function () {
        downloadCSV();
    });


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

function fetchcustomers(page = 1, limit = 20) {
    const tableBody = document.querySelector("#customerTableBody"); // Assuming the table has an id of 'vendorTable'
    if (!tableBody) {
        console.error("Table body element not found");
        return;
    }
    const filters = {
        name: document.getElementById("filterName").value,
        status: document.getElementById("filterStatus").value
    };

    const queryString = new URLSearchParams(filters).toString();

    fetch(`./api/customer/fetch-customers.php?page=${page}&limit=${limit}&${queryString}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populatecustomerTable(data.customers, page, limit);
                setupPagination(data.pagination.total_pages, page);
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

function populatecustomerTable(customers, page, limit) {
    const tableBody = document.querySelector("#customerTableBody");
    tableBody.innerHTML = "";
    if (customers.length === 0) {
        showNoDataMessage();
    } else {
        customers.forEach((customer, index) => {
            const serialNumber = (page - 1) * limit + index + 1;

            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${serialNumber}</td>
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

function downloadCSV() {
    // Show loading message
    const loadingMessage = alertify.message('Preparing your download, please wait...', 0); // 0 means the message will not auto-dismiss

    const filters = {
        name: document.getElementById("filterName").value,
        status: document.getElementById("filterStatus").value
    };

    const queryString = new URLSearchParams(filters).toString();

    fetch(`./api/customer/export-customer.php?${queryString}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'text/csv',
        },
    })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'CAMP_CUSTOMER_Data.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);

            // Hide loading message and show success message
            alertify.dismissAll();
            alertify.success('Download started');
        })
        .catch(error => {
            console.error('Error downloading CSV file:', error);
            alertify.dismissAll();
            alertify.error('Error downloading CSV file');
        });
}


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
        fetchcustomers(1);
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
        fetchcustomers(currentPage - 1);
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
            fetchcustomers(i);
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
        fetchcustomers(currentPage + 1);
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
        fetchcustomers(totalPages);
    });
    lastLi.appendChild(lastLink);
    ul.appendChild(lastLi);

    paginationContainer.appendChild(ul);
}