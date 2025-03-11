document.addEventListener("DOMContentLoaded", function () {

    fetchCustomers();
    fetchBanks();

    
    document.getElementById("selectAllCustomers").addEventListener("change", toggleSelectAllCustomers);
    document.getElementById("selectAllBanks").addEventListener("change", toggleSelectAllBanks);
    document.getElementById("selectAllZones").addEventListener("change", toggleSelectAllZones);
    document.getElementById("selectAllPermissions").addEventListener("change", toggleSelectAll);

    
    const userForm = document.getElementById("userForm");

    // if (!userForm) return;

    const phoneInput = document.querySelector("input[name='phone']");
    const emailInput = document.querySelector("input[name='email']");

    // Add password fields dynamically
    addPasswordFields();

    // Event Listeners
    phoneInput?.addEventListener("input", handlePhoneValidation);
    emailInput?.addEventListener("input", handleEmailValidation);
    userForm.addEventListener("submit", handleSubmit);

    function addPasswordFields() {
        const passwordContainer = document.createElement("div");
        passwordContainer.className = "row";

        const passwordInput = createInputField("password", "Password");
        const confirmPasswordInput = createInputField("confirm_password", "Confirm Password");

        passwordContainer.appendChild(passwordInput.container);
        passwordContainer.appendChild(confirmPasswordInput.container);
        userForm.insertBefore(passwordContainer, userForm.querySelector(".row.password"));

        passwordInput.input.addEventListener("input", validatePasswords);
        confirmPasswordInput.input.addEventListener("input", validatePasswords);
    }

    function createInputField(name, label) {
        const container = document.createElement("div");
        container.className = "col-md-6 mb-3";
        container.innerHTML = `<div class="input-block"><label>${label}</label></div>`;

        const input = document.createElement("input");
        input.type = "password";
        input.name = name;
        input.className = "form-control";
        input.required = true;

        container.querySelector(".input-block").appendChild(input);
        return { container, input };
    }

    function validatePasswords() {
        const password = document.querySelector("input[name='password']");
        const confirmPassword = document.querySelector("input[name='confirm_password']");

        if (password.value !== confirmPassword.value) {
            showError(confirmPassword, "Passwords do not match!");
            return false;
        } else {
            removeError(confirmPassword);
            return true;
        }
    }

    async function handlePhoneValidation() {
        const phone = phoneInput.value.trim();

        if (!/^[6-9]\d{9}$/.test(phone)) {
            showError(phoneInput, "Invalid phone number format!");
            return;
        } else {
            removeError(phoneInput);
        }

        if (!(await checkUnique("validate_phone.php", { phone }))) {
            showError(phoneInput, "Phone number already exists!");
        }
    }

    async function handleEmailValidation() {
        const email = emailInput.value.trim();

        if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
            showError(emailInput, "Invalid email format!");
            return;
        } else {
            removeError(emailInput);
        }

        if (!(await checkUnique("validate_email.php", { email }))) {
            showError(emailInput, "Email already exists!");
        }
    }

    async function handleSubmit(event) {
        event.preventDefault();

        const formData = new FormData(userForm);
        const userData = Object.fromEntries(formData.entries());

        if (!/^[6-9]\d{9}$/.test(userData.phone)) {
            alertify.error("Invalid phone number format!");
            return;
        }

        if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(userData.email)) {
            alertify.error("Invalid email format!");
            return;
        }

        if (!validatePasswords()) {
            alertify.error("Passwords do not match!");
            return;
        }

        if (!(await checkUnique("validate_phone.php", { phone: userData.phone }))) {
            alertify.error("Phone number already exists!");
            return;
        }

        if (!(await checkUnique("validate_email.php", { email: userData.email }))) {
            alertify.error("Email already exists!");
            return;
        }

        const response = await saveRegistration(userData);
        if (response.success) {
            alertify.success("User Created! Redirecting to Permissions...");
            window.location.href = `assign_permissions.php?user_id=${response.user_id}`;
        } else {
            alertify.error("Error saving user. Please try again.");
        }
    }

    async function checkUnique(endpoint, payload) {
        try {
            const response = await fetch(`api/user/${endpoint}`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload)
            });

            const data = await response.json();
            return !data.exists;
        } catch (error) {
            console.error(`Validation error (${endpoint}):`, error);
            return false;
        }
    }

    async function saveRegistration(userData) {
        try {
            const response = await fetch("api/user/save_registration.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(userData)
            });

            return await response.json();
        } catch (error) {
            console.error("Registration save error:", error);
            return { success: false };
        }
    }

    function showError(input, message) {
        removeError(input);
        const errorDiv = document.createElement("div");
        errorDiv.className = "invalid-feedback";
        errorDiv.textContent = message;
        input.parentNode.appendChild(errorDiv);
        input.classList.add("is-invalid");
    }

    function removeError(input) {
        input.classList.remove("is-invalid");
        const existingError = input.parentNode.querySelector(".invalid-feedback");
        if (existingError) {
            existingError.remove();
        }
    }


// Fetch and populate customers
async function fetchCustomers() {
    try {
        const response = await fetch("./api/customer/fetch-customers.php");
        const data = await response.json();
        if (data.success && Array.isArray(data.customers)) {
            populateGrid("#multiselect_customers", data.customers, "customers[]");
        } else {
            console.error("Failed to fetch customers:", data.message);
        }
    } catch (error) {
        console.error("Error fetching customers:", error);
    }
}

// Fetch and populate banks
async function fetchBanks() {
    try {
        const response = await fetch("./api/bank/fetch-banks.php");
        const data = await response.json();
        if (data.success && Array.isArray(data.banks)) {
            populateGrid("#multiselect_banks", data.banks, "banks[]");
        } else {
            console.error("Failed to fetch banks:", data.message);
        }
    } catch (error) {
        console.error("Error fetching banks:", error);
    }
}

// Populate checkboxes inside grid
function populateGrid(selector, items, nameAttr) {
    const container = document.querySelector(selector);
    if (!container) return;

    container.innerHTML = ""; // Clear existing content

    items.forEach(item => {
        const div = document.createElement("div");
        div.classList.add("grid-item");

        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.name = nameAttr;
        checkbox.value = item.id;

        const label = document.createElement("label");
        label.textContent = item.name;

        div.appendChild(checkbox);
        div.appendChild(label);
        container.appendChild(div);
    });
}

// Toggle Select All Customers
function toggleSelectAllCustomers() {
    const checked = document.getElementById("selectAllCustomers").checked;
    document.querySelectorAll("#multiselect_customers input[type='checkbox']").forEach(cb => cb.checked = checked);
}

// Toggle Select All Banks
function toggleSelectAllBanks() {
    const checked = document.getElementById("selectAllBanks").checked;
    document.querySelectorAll("#multiselect_banks input[type='checkbox']").forEach(cb => cb.checked = checked);
}

// Toggle Select All Zones
function toggleSelectAllZones() {
    const checked = document.getElementById("selectAllZones").checked;
    document.querySelectorAll("input[name='zones[]']").forEach(cb => cb.checked = checked);
}

// Toggle Select All (Customers, Banks, and Zones)
function toggleSelectAll() {
    const checked = document.getElementById("selectAllPermissions").checked;
    document.getElementById("selectAllCustomers").checked = checked;
    document.getElementById("selectAllBanks").checked = checked;
    document.getElementById("selectAllZones").checked = checked;

    toggleSelectAllCustomers();
    toggleSelectAllBanks();
    toggleSelectAllZones();
}
    
});
