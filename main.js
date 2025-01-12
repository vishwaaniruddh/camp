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
            alertify.success("Form submitted successfully!");
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


document.addEventListener("DOMContentLoaded", function () {

    document.getElementById("addVendorForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        const form = e.target;
        const isValid = validateForm(form); // Call your validation function here

        if (isValid) {
            // Gather form data
            const formData = new FormData(form);

            // Clear previous messages
            const messageContainer = document.getElementById("messageContainer");
            if (messageContainer) messageContainer.innerHTML = "";

            // Send data via AJAX
            fetch("./api/add-vendor.php", {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        displayMessage("success", data.message || "Vendor added successfully!");

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
                        displayMessage("error", data.message || "Failed to add vendor. Please try again.");
                    }
                })
                .catch(error => {
                    alertify.error("Error:", error);
                    // Show unexpected error message
                    displayMessage("error", "An unexpected error occurred. Please try again.");
                });
        } else {
            // Show validation error message
            displayMessage("error", "Please correct the highlighted fields.");
        }
    });

    function displayMessage(type, message) {
        const messageContainer = document.getElementById("messageContainer");

        // If the container doesn't exist, create one dynamically
        if (!messageContainer) {
            const container = document.createElement("div");
            container.id = "messageContainer";
            container.style.position = "fixed";
            container.style.top = "20px";
            container.style.right = "20px";
            container.style.zIndex = "1050";
            document.body.appendChild(container);
        }

        // Create a message element
        const messageElement = document.createElement("div");
        messageElement.className = `alert alert-${type === "success" ? "success" : "danger"}`;
        messageElement.innerText = message;

        // Append the message to the container
        document.getElementById("messageContainer").appendChild(messageElement);

        // Automatically remove the message after 5 seconds
        setTimeout(() => {
            messageElement.remove();
        }, 5000);
    }

    const tableBody = document.getElementById("vendorTableBody");

    // Function to fetch vendor data
    function fetchVendors(page = 1, limit = 10) {
        fetch(`./api/fetch-vendors.php?page=${page}&limit=${limit}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    populateTable(data.data);
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
    function populateTable(vendors) {
        tableBody.innerHTML = ""; 
        vendors.forEach((vendor, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <h2 class="table-avatar">
                        <a href="profile.html?vendorId="${vendor.id}" class="avatar avatar-sm me-2">
                            <img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-14.jpg" alt="User Image">
                        </a>
                        <a href="profile.html?vendorId="${vendor.id}s">${vendor.name} <span>${vendor.email}</span></a>
                    </h2>
                </td>
                <td>${vendor.phone}</td>
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
                    document.querySelector("#edit_vendor input[name='vendor_name']").value = vendor.name || "";
                    document.querySelector("#edit_vendor input[name='vendor_email']").value = vendor.email || "";
                    document.querySelector("#edit_vendor input[name='vendor_phoneno']").value = vendor.phone || "";
                    document.querySelector("#edit_vendor input[name='vendor_address']").value = vendor.address || "";
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
    console.log(vendorId);
    fetch("./api/delete-vendor.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ id: vendorId }) // Send vendor ID as JSON
    })
    .then(response => response.json())
    .then(data => {
        
        console.log(data)
        
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
                if (confirm("Are you sure you want to delete this vendor?")) {
                    deleteVendor(vendorId);
                }
            });
        });
    }
    
    
    // Fetch vendors on page load
    fetchVendors();

});


