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
        } else {
            alertify.error("Please correct the highlighted fields.");
        }
    }
});


// Utility function to format date
function formatDate(dateString) {
    const options = { year: "numeric", month: "short", day: "numeric", hour: "2-digit", minute: "2-digit" };
    return new Date(dateString).toLocaleDateString("en-US", options);
}
