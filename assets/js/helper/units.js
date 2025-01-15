document.addEventListener("DOMContentLoaded", function () {
    fetchUnits();

});


document.getElementById("addUnitForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    const isValid = validateForm(form); // Call your validation function here

    if (isValid) {
        // Gather form data
        const formData = new FormData(form);

        // Show loading message
        // alertify.message('Adding unit, please wait...');

        // Send data via AJAX
        fetch("./api/units/add-unit.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success(data.message || "Unit added successfully!");

                // Close the modal after successful submission
                const modalElement = form.closest(".modal");
                if (modalElement) {
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) modalInstance.hide();
                }

                form.reset(); // Reset form fields

                // Refresh unit table
                fetchUnits();
            } else {
                // Show error message
                alertify.error(data.message || "Failed to add unit. Please try again.");
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

document.getElementById("editUnitForm").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    const isValid = validateForm(form); // Call your validation function here

    if (isValid) {
        // Gather form data
        const formData = new FormData(form);


        // Send data via AJAX
        fetch("./api/units/update-unit.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success(data.message || "Unit updated successfully!");

                // Close the modal after successful submission
                const modalElement = form.closest(".modal");
                if (modalElement) {
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) modalInstance.hide();
                }

                form.reset(); // Reset form fields

                // Refresh unit table
                fetchUnits();
            } else {
                // Show error message
                alertify.error(data.message || "Failed to update unit. Please try again.");
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

function fetchUnits() {
    fetch("./api/units/fetch-units.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateUnitTable(data.units);
            } else {
                alertify.error("Failed to fetch units.");
            }
        })
        .catch(error => {
            console.error("Error fetching units:", error);
            alertify.error("An unexpected error occurred.");
        });
}

function populateUnitTable(units) {
    const tableBody = document.querySelector("#unitTableBody");
    if (!tableBody) {
        console.error("Table body element not found");
        return;
    }
    tableBody.innerHTML = "";

    // Safeguard to ensure units is an array
    if (!Array.isArray(units) || units.length === 0) {
        const row = document.createElement("tr");
        row.innerHTML = `<td colspan="7" class="text-center">No units found</td>`;
        tableBody.appendChild(row);
        return;
    }

    units.forEach((unit, index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${unit.unitname}</td>
            <td>${unit.slug}</td>
            <td>${unit.status === 'active' 
                ? '<span class="badge bg-success-light d-inline-flex align-items-center">Active</span>' 
                : '<span class="badge bg-danger-light d-inline-flex align-items-center">Deleted</span>'}
            </td>
            <td class="d-flex align-items-center">
                <a href="javascript:void(0);" class="btn-action-icon me-2 edit-unit-btn" data-unit-id="${unit.id}" data-bs-toggle="modal" data-bs-target="#edit_unit"><i class="far fa-edit"></i></a>
                <a href="javascript:void(0);" class="btn-action-icon delete-unit-btn" data-unit-id="${unit.id}"><i class="fe fe-trash-2"></i></a>
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
    document.querySelectorAll(".edit-unit-btn").forEach(button => {
        button.addEventListener("click", function () {
            const unitId = this.dataset.unitId; // Get unit ID from data attribute
            fetchUnitData(unitId); // Fetch data and populate modal
        });
    });
}

function attachDeleteListeners() {
    document.querySelectorAll(".delete-unit-btn").forEach(button => {
        button.addEventListener("click", function () {
            const unitId = this.dataset.unitId; // Get unit ID from data attribute
            alertify.confirm("Are you sure you want to delete this unit?", function (e) {
                if (e) {
                    deleteUnit(unitId);
                }
            });
        });
    });
}

function fetchUnitData(unitId) {
    fetch(`./api/units/get-unit.php?id=${unitId}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const unit = data.unit;
            document.querySelector("#editUnitForm input[name='unit_id']").value = unit.id || "";
            document.querySelector("#editUnitForm input[name='unitname']").value = unit.unitname || "";
            document.querySelector("#editUnitForm input[name='slug']").value = unit.slug || "";
            document.querySelector("#editUnitForm select[name='status']").value = unit.status || "active";
        } else {
            alertify.error("Failed to fetch unit details.");
        }
    })
    .catch(error => {
        console.error("Error fetching unit data:", error);
        alertify.error("An unexpected error occurred.");
    });
}

function deleteUnit(unitId) {
    fetch("./api/units/delete-unit.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ id: unitId }) // Send unit ID as JSON
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alertify.success("Unit deleted successfully.");
            fetchUnits(); // Refresh the table
        } else {
            alertify.error("Failed to delete unit.");
        }
    })
    .catch(error => {
        console.error("Error deleting unit:", error);
        alertify.error("An unexpected error occurred.");
    });
}