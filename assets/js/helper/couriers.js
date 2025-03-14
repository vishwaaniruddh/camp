document.addEventListener("DOMContentLoaded", function () {
    fetchcouriers();

    document.getElementById("applyFilters").addEventListener("click", function () {
        fetchcouriers();
    });
    document.getElementById("downloadCSV").addEventListener("click", function () {
        downloadCSV();
    });


});


document.getElementById("addcourierForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    const isValid = validateForm(form); // Call your validation function here

    if (isValid) {
        // Gather form data
        const formData = new FormData(form);

        // Show loading message
        // alertify.message('Adding courier, please wait...');

        // Send data via AJAX
        fetch("./api/couriers/add-courier.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success(data.message || " Courier added successfully! ");

                // Close the modal after successful submission
                const modalElement = form.closest(".modal");
                if (modalElement) {
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) modalInstance.hide();
                }

                form.reset(); // Reset form fields

                // Refresh courier table
                fetchcouriers();
            } else {
                // Show error message
                alertify.error(data.message || "Failed to add courier. Please try again.");
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

document.getElementById("editcourierForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    const isValid = validateForm(form); // Call your validation function here

    if (isValid) {
        // Gather form data
        const formData = new FormData(form);


        // Send data via AJAX
        fetch("./api/couriers/update-courier.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success(data.message || "courier updated successfully!");

                // Close the modal after successful submission
                const modalElement = form.closest(".modal");
                if (modalElement) {
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) modalInstance.hide();
                }

                form.reset(); // Reset form fields

                // Refresh courier table
                fetchcouriers();
            } else {
                // Show error message
                alertify.error(data.message || "Failed to update courier. Please try again.");
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

function validateForm(form) {
    let isValid = true;

    // Select all inputs with validation classes
    const fields = form.querySelectorAll(
        "input.string_valid, input.number_valid, input.required_valid"
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

function fetchcouriers(page = 1, limit = 20) {
    const tableBody = document.querySelector("#courierTableBody"); // Assuming the table has an id of 'vendorTable'
    if (!tableBody) {
        console.error("Table body element not found");
        return;
    }
    const filters = {
        name: document.getElementById("filterName").value,
        status: document.getElementById("filterStatus").value
    };

    const queryString = new URLSearchParams(filters).toString();

    fetch(`./api/couriers/fetch-couriers.php?page=${page}&limit=${limit}&${queryString}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populatecourierTable(data.couriers, page, limit);
                setupPagination(data.pagination.total_pages, page);
            } else {
                alertify.error("Failed to fetch couriers.");
            }
        })
        .catch(error => {
            console.error("Error fetching couriers:", error);
            alertify.error("An unexpected error occurred.");
        });
}

function populatecourierTable(couriers, page, limit) {
    const tableBody = document.querySelector("#courierTableBody");
    if (!tableBody) {
        console.error("Table body element not found");
        return;
    }
    tableBody.innerHTML = "";

    // Safeguard to ensure couriers is an array
    if (!Array.isArray(couriers) || couriers.length === 0) {
        const row = document.createElement("tr");
        row.innerHTML = `<td colspan="7" class="text-center">No couriers found</td>`;
        tableBody.appendChild(row);
        return;
    }

    couriers.forEach((courier, index) => {
        const serialNumber = (page - 1) * limit + index + 1;

        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${serialNumber}</td>
            <td>${courier.couriername}</td>
            <td>${courier.status === 'active' 
                ? '<span class="badge bg-success-light d-inline-flex align-items-center">Active</span>' 
                : '<span class="badge bg-danger-light d-inline-flex align-items-center">Deleted</span>'}
            </td>
            <td class="d-flex align-items-center">
                <a href="javascript:void(0);" class="btn-action-icon me-2 edit-courier-btn" data-courier-id="${courier.id}" data-bs-toggle="modal" data-bs-target="#edit_courier"><i class="far fa-edit"></i></a>
                <a href="javascript:void(0);" class="btn-action-icon delete-courier-btn" data-courier-id="${courier.id}"><i class="fe fe-trash-2"></i></a>
            </td>
        `;
        tableBody.appendChild(row);
    });

    // Attach event listeners for edit and delete buttons
    attachEditListeners();
    attachDeleteListeners();
}


function formatDate(dateString) {
    const options = { year: "numeric", month: "short", day: "numeric", hour: "2-digit", minute: "2-digit" };
    return new Date(dateString).toLocaleDateString("en-US", options);
}

function attachEditListeners() {
    document.querySelectorAll(".edit-courier-btn").forEach(button => {
        button.addEventListener("click", function () {
            const courierId = this.dataset.courierId; // Get courier ID from data attribute
            fetchcourierData(courierId); // Fetch data and populate modal
        });
    });
}

function attachDeleteListeners() {
    document.querySelectorAll(".delete-courier-btn").forEach(button => {
        button.addEventListener("click", function () {
            const courierId = this.dataset.courierId; // Get courier ID from data attribute
            alertify.confirm("Are you sure you want to delete this courier?", function (e) {
                if (e) {
                    deletecourier(courierId);
                }
            });
        });
    });
}

function fetchcourierData(courierId) {
    fetch(`./api/couriers/get-courier.php?id=${courierId}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const courier = data.courier;
            document.querySelector("#editcourierForm input[name='courier_id']").value = courier.id || "";
            document.querySelector("#editcourierForm input[name='couriername']").value = courier.couriername || "";
            document.querySelector("#editcourierForm select[name='status']").value = courier.status || "active";
        } else {
            alertify.error("Failed to fetch courier details.");
        }
    })
    .catch(error => {
        console.error("Error fetching courier data:", error);
        alertify.error("An unexpected error occurred.");
    });
}

function deletecourier(courierId) {
    fetch("./api/couriers/delete-courier.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ id: courierId }) // Send courier ID as JSON
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alertify.success("courier deleted successfully.");
            fetchcouriers(); // Refresh the table
        } else {
            alertify.error("Failed to delete courier.");
        }
    })
    .catch(error => {
        console.error("Error deleting courier:", error);
        alertify.error("An unexpected error occurred.");
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

    fetch(`./api/couriers/export-couriers.php?${queryString}`, {
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
            a.download = 'CAMP_COURIER_DATA.csv';
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
        fetchcouriers(1);
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
        fetchcouriers(currentPage - 1);
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
            fetchcouriers(i);
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
        fetchcouriers(currentPage + 1);
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
        fetchcouriers(totalPages);
    });
    lastLi.appendChild(lastLink);
    ul.appendChild(lastLi);

    paginationContainer.appendChild(ul);
}