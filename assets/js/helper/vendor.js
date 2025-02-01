document.addEventListener("DOMContentLoaded", function () {
    fetchVendors();

    document.getElementById("applyFilters").addEventListener("click", function () {
        fetchVendors();
    });

    document.getElementById("importVendorForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent default form submission
        bulkvendoradd();
    });

    document.getElementById("downloadExcel").addEventListener("click", function () {
        downloadExcel();
    });

    // Attach event listener for the edit vendor form submission
    const editVendorForm = document.querySelector("#edit_vendor");
    if (editVendorForm) {
        editVendorForm.addEventListener("submit", function (event) {
            event.preventDefault();
            const vendorId = document.querySelector("#edit_vendor input[name='vendor_id']").value;
            updateVendorData(vendorId);
        });
    }
});

function updateVendorData(vendorId) {

    const vendorForm = document.querySelector("#edit_vendor");
    
    // Assuming validateForm is a function in validation.js that validates the form
    if (!validateForm(vendorForm)) {
        return;
    }


    const vendorName = document.querySelector("#edit_vendor input[name='vendor_name']").value;
    const vendorEmail = document.querySelector("#edit_vendor input[name='vendor_email']").value;
    const vendorPhone = document.querySelector("#edit_vendor input[name='vendor_phoneno']").value;
    const vendorAddress = document.querySelector("#edit_vendor input[name='vendor_address']").value;
    const vendorStatus = document.querySelector("#edit_vendor select[name='vendor_status']").value;
    const vendorGstin = document.querySelector("#edit_vendor input[name='vendor_gstin']").value;

    const vendorData = {
        id: vendorId,
        name: vendorName,
        email: vendorEmail,
        phoneno: vendorPhone,
        address: vendorAddress,
        status: vendorStatus,
        gstin: vendorGstin
    };

    fetch('./api/vendor/update-vendors.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(vendorData),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('Vendor updated successfully');
                fetchVendors();
                // Optionally, refresh the vendor list or update the UI accordingly
            } else {
                alertify.error('Failed to update vendor');
            }
        })
        .catch(error => console.error('Error:', error));
}

// Function to fetch vendor data
function fetchVendors(page = 1, limit = 20) {
    const tableBody = document.querySelector("#vendorTableBody"); // Assuming the table has an id of 'vendorTable'
    if (!tableBody) {
        console.error("Table body element not found");
        return;
    }

    const filters = {
        name: document.getElementById("filterName").value,
        phone: document.getElementById("filterPhone").value,
        email: document.getElementById("filterEmail").value,
        gstin: document.getElementById("filterGstin").value,
        status: document.getElementById("filterStatus").value
    };

    const queryString = new URLSearchParams(filters).toString();

    fetch(`./api/vendor/fetch-vendors.php?page=${page}&limit=${limit}&${queryString}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                vendor_populateTable(data.data, page, limit);
                setupPagination(data.pagination.total_pages, page);
            } else {
                tableBody.innerHTML = `<tr><td colspan="6">${data.message}</td></tr>`;
            }
        })
        .catch(error => {
            console.log(error)
            alertify.error("Error fetching vendor data:", error);
            tableBody.innerHTML = `<tr><td colspan="6">An error occurred while fetching vendor data.</td></tr>`;
        });
}

// Function to populate table
function vendor_populateTable(vendors, page, limit) {
    const tableBody = document.querySelector("#vendorTableBody");
    tableBody.innerHTML = "";
    vendors.forEach((vendor, index) => {
        const serialNumber = (page - 1) * limit + index + 1;
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${serialNumber}</td>
            <td>
                <h2 class="table-avatar">
                    <a href="profile.html?vendorId=${vendor.id}">${vendor.name.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')} <span>${vendor.email}</span></a>
                </h2>
            </td>
            <td>
            <h2>
                ${vendor.phone} 
                <span>${vendor.gstin ? vendor.gstin : ''} </span>
            </h2>
            </td>
            <td>
                ${vendor.status === 'active'
                ? '<span class="badge bg-success-light d-inline-flex align-items-center">Active</span>'
                : '<span class="badge bg-danger-light d-inline-flex align-items-center">Deleted</span>'}
            </td>
            <td>${formatDate(vendor.created_at)}</td>
            <td class="d-flex align-items-center">
                <a href="ledger.html" class="btn btn-greys me-2"><i class="fa fa-eye me-1"></i> Ledger</a> 
                <div class="dropdown dropdown-action">
                    <a href="#" class="btn-action-icon" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <ul>
                            <li>
                                <a class="dropdown-item edit-vendor-btn" href="javascript:void(0);" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#edit_vendor_modal" 
                                   data-vendor-id="${vendor.id}">
                                    <i class="far fa-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item delete-vendor-btn" href="javascript:void(0);" 
                                   data-vendor-id="${vendor.id}">
                                    <i class="far fa-trash-alt me-2"></i>Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
        `;
        tableBody.appendChild(row);
    });

    // Attach event listeners after rendering
    attachEditListeners();
    attachDeleteListeners();
}

// Attach click listeners for edit buttons
function attachEditListeners() {
    document.querySelectorAll(".edit-vendor-btn").forEach(button => {
        button.addEventListener("click", function () {
            const vendorId = this.dataset.vendorId; // Get vendor ID from data attribute
            fetchVendorData(vendorId); // Fetch data and populate modal
        });
    });
}

// Attach click listeners for delete buttons
function attachDeleteListeners() {
    document.querySelectorAll(".delete-vendor-btn").forEach(button => {
        button.addEventListener("click", function () {
            const vendorId = this.dataset.vendorId; // Get vendor ID from data attribute
            alertify.confirm("Are you sure you want to delete this vendor?", function (e) {
                if (e) {
                    deleteVendor(vendorId);
                }
            });
        });
    });
}

// Fetch vendor data for editing
function fetchVendorData(vendorId) {
    fetch(`./api/vendor/get-vendor.php?id=${vendorId}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const vendor = data.vendor;
                document.querySelector("#edit_vendor input[name='vendor_id']").value = vendor.vendor_id || "";
                document.querySelector("#edit_vendor input[name='vendor_name']").value = vendor.name || "";
                document.querySelector("#edit_vendor input[name='vendor_email']").value = vendor.email || "";
                document.querySelector("#edit_vendor input[name='vendor_phoneno']").value = vendor.phone || "";
                document.querySelector("#edit_vendor input[name='vendor_address']").value = vendor.address || "";
                document.querySelector("#edit_vendor select[name='vendor_status']").value = vendor.status || "Active";
                document.querySelector("#edit_vendor input[name='vendor_gstin']").value = vendor.gstin || "";

            } else {
                alertify.error("Failed to fetch vendor details.");
            }
        })
        .catch(error => {
            alertify.error("Error fetching vendor data:", error);
            alertify.error("An unexpected error occurred.");
        });
}

// Delete vendor function
function deleteVendor(vendorId) {
    fetch("./api/vendor/delete-vendor.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ id: vendorId }) // Send vendor ID as JSON
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alertify.success("Vendor deleted successfully.");
                fetchVendors(); // Refresh the table
            } else {
                alertify.error("Failed to delete vendor.");
            }
        })
        .catch(error => {
            alertify.error("Error deleting vendor:", error);
            alertify.error("An unexpected error occurred.");
        });
}

function uploadExcel() {
    const form = document.getElementById("importVendorForm");
    const formData = new FormData(form);
    const fileInput = form.querySelector('input[name="importVendor"]');

    if (fileInput.files.length === 0) {
        alertify.error("Please select a file to upload.");
        return;
    }

    // Show loading message
    alertify.message('Uploading your file, please wait...');

    fetch('./api/vendor/import-vendors.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('Vendors imported successfully');
                // Optionally, refresh the vendor list or update the UI accordingly
                fetchVendors();
            } else {
                alertify.error('Failed to import vendors');
            }
        })
        .catch(error => {
            console.error('Error uploading file:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function downloadExcel() {
    // Show loading message
    const loadingMessage = alertify.message('Preparing your download, please wait...', 0); // 0 means the message will not auto-dismiss

    const filters = {
        name: document.getElementById("filterName").value,
        phone: document.getElementById("filterPhone").value,
        email: document.getElementById("filterEmail").value,
        gstin: document.getElementById("filterGstin").value,
        status: document.getElementById("filterStatus").value
    };

    const queryString = new URLSearchParams(filters).toString();

    fetch(`./api/vendor/export-vendor.php?${queryString}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        },
    })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'vendor_data.xlsx';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);

            // Hide loading message and show success message
            alertify.dismissAll();
            alertify.success('Download started');
        })
        .catch(error => {
            console.error('Error downloading Excel file:', error);
            alertify.dismissAll();
            alertify.error('Error downloading Excel file');
        });
}

// Function to setup pagination
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
        fetchVendors(1);
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
        fetchVendors(currentPage - 1);
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
            fetchVendors(i);
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
        fetchVendors(currentPage + 1);
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
        fetchVendors(totalPages);
    });
    lastLi.appendChild(lastLink);
    ul.appendChild(lastLi);

    paginationContainer.appendChild(ul);
}