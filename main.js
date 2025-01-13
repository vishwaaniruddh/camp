document.addEventListener("DOMContentLoaded", function () {
    fetchVendors();
});

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


document.addEventListener("DOMContentLoaded", function() {
    // Attach the update function to the form submit event
    const editVendorForm = document.querySelector("#edit_vendor");
    if (editVendorForm) {
        editVendorForm.addEventListener("submit", function(event) {
            event.preventDefault();
            const vendorId = document.querySelector("#edit_vendor input[name='vendor_id']").value;
            updateVendorData(vendorId);
        });
    }

    // Fetch vendors on page load
    fetchVendors();
});

function updateVendorData(vendorId) {
    const vendorName = document.querySelector("#edit_vendor input[name='vendor_name']").value;
    const vendorEmail = document.querySelector("#edit_vendor input[name='vendor_email']").value;
    const vendorPhone = document.querySelector("#edit_vendor input[name='vendor_phoneno']").value;
    const vendorAddress = document.querySelector("#edit_vendor input[name='vendor_address']").value;
    const vendorStatus = document.querySelector("#edit_vendor select[name='vendor_status']").value;

    const vendorData = {
        id: vendorId,
        name: vendorName,
        email: vendorEmail,
        phone: vendorPhone,
        address: vendorAddress,
        status: vendorStatus
    };

    fetch('./api/update-vendors.php', {
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
            // Optionally, refresh the vendor list or update the UI accordingly
        } else {
            alertify.error('Failed to update vendor');
        }
    })
    .catch(error => console.error('Error:', error));
}


document.getElementById("addVendorForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    const isValid = validateForm(form); // Call your validation function here

    if (isValid) {
        // Gather form data
        const formData = new FormData(form);

        // Show loading message
        alertify.message('Adding vendor, please wait...');

        // Send data via AJAX
        fetch("./api/add-vendor.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success(data.message || "Vendor added successfully!");

                // Close the modal after successful submission
                const modalElement = form.closest(".modal");
                if (modalElement) {
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) modalInstance.hide();
                }

                form.reset(); // Reset form fields

                // Refresh vendor table
                fetchVendors();
            } else {
                // Show error message
                alertify.error(data.message || "Failed to add vendor. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alertify.error("An unexpected error occurred. Please try again.");
        });
    } else {
        // Show validation error message
        alertify.error("Please correct the highlighted fields.");
    }
});

document.addEventListener("submit", function (e) {
    if (e.target.tagName === "FORM") {
        e.preventDefault(); // Prevent default form submission
        const isValid = validateForm(e.target);
        if (isValid) {
            // If validation passes, check if the form is inside a modal
            const modalElement = e.target.closest(".modal");
            if (modalElement) {
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide(); // Close the modal
            }
            // alertify.success("Form submitted successfully!");
            // Add form submission logic here
        } else {
            alertify.error("Please correct the highlighted fields.");
        }
    }
});

function validateForm(form) {
    let isValid = true;

    // Select all inputs with validation classes
    const fields = form.querySelectorAll(
        "input.email_valid, input.phone_valid, input.required_valid, input.string_valid, input.number_valid"
    );

    fields.forEach((field) => {
        // Reset previous errors
        field.classList.remove("error");
        field.removeAttribute("title");

        // Required validation
        if (field.classList.contains("required_valid") && !field.value.trim()) {
            isValid = false;
            markError(field, "This field is required.");
        }

        // Phone number validation
        if (field.classList.contains("phone_valid")) {
            const phoneRegex = /^\d{10}$/; // Only 10-digit numbers
            if (!phoneRegex.test(field.value)) {
                isValid = false;
                markError(field, "Enter a valid 10-digit phone number.");
            }
        }

        // Email validation
        if (field.classList.contains("email_valid")) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email pattern
            if (!emailRegex.test(field.value)) {
                isValid = false;
                markError(field, "Enter a valid email address.");
            }
        }

        // String validation (letters and spaces only)
        if (field.classList.contains("string_valid")) {
            const stringRegex = /^[a-zA-Z\s]+$/; // Letters and spaces only
            if (!stringRegex.test(field.value)) {
                isValid = false;
                markError(field, "Only letters and spaces are allowed.");
            }
        }

        // Number validation (only numeric values)
        if (field.classList.contains("number_valid")) {
            const numberRegex = /^\d+$/; // Numbers only
            if (!numberRegex.test(field.value)) {
                isValid = false;
                markError(field, "Only numeric values are allowed.");
            }
        }
    });

    return isValid;
}

function markError(field, message) {
    field.classList.add("error");
    field.setAttribute("title", message); // Tooltip for error message
}

// Function to fetch vendor data
function fetchVendors(page = 1, limit = 10) {
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

    fetch(`./api/fetch-vendors.php?page=${page}&limit=${limit}&${queryString}`)
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
                    <a href="profile.html?vendorId=${vendor.id}" class="avatar avatar-sm me-2">
                        <img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-14.jpg" alt="User Image">
                    </a>
                    <a href="profile.html?vendorId=${vendor.id}">${vendor.name.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')} <span>${vendor.email}</span></a>
                </h2>
            </td>
            <td>${vendor.phone}</td>
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
                                   data-bs-target="#edit_vendor" 
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


// Utility function to format date
function formatDate(dateString) {
    const options = { year: "numeric", month: "short", day: "numeric", hour: "2-digit", minute: "2-digit" };
    return new Date(dateString).toLocaleDateString("en-US", options);
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
    fetch(`./api/get-vendor.php?id=${vendorId}`, {
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
    fetch("./api/delete-vendor.php", {
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

    fetch('./api/import-vendors.php', {
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

    fetch(`./api/export-vendor.php?${queryString}`, {
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

    // Create "First" button
    const firstButton = document.createElement('button');
    firstButton.textContent = 'First';
    firstButton.classList.add('page-btn');
    firstButton.disabled = currentPage === 1;
    firstButton.addEventListener('click', function () {
        fetchVendors(1);
    });
    paginationContainer.appendChild(firstButton);

    // Create "Prev" button
    const prevButton = document.createElement('button');
    prevButton.textContent = 'Prev';
    prevButton.classList.add('page-btn');
    prevButton.disabled = currentPage === 1;
    prevButton.addEventListener('click', function () {
        fetchVendors(currentPage - 1);
    });
    paginationContainer.appendChild(prevButton);

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
        const pageButton = document.createElement('button');
        pageButton.textContent = i;
        pageButton.classList.add('page-btn');
        if (i === currentPage) {
            pageButton.classList.add('active');
        }
        pageButton.addEventListener('click', function () {
            fetchVendors(i);
        });
        paginationContainer.appendChild(pageButton);
    }

    // Create "Next" button
    const nextButton = document.createElement('button');
    nextButton.textContent = 'Next';
    nextButton.classList.add('page-btn');
    nextButton.disabled = currentPage === totalPages;
    nextButton.addEventListener('click', function () {
        fetchVendors(currentPage + 1);
    });
    paginationContainer.appendChild(nextButton);

    // Create "Last" button
    const lastButton = document.createElement('button');
    lastButton.textContent = 'Last';
    lastButton.classList.add('page-btn');
    lastButton.disabled = currentPage === totalPages;
    lastButton.addEventListener('click', function () {
        fetchVendors(totalPages);
    });
    paginationContainer.appendChild(lastButton);
}