document.addEventListener("DOMContentLoaded", function () {
    fetchusers();

    // Add user Form Submission
    document.querySelector("#adduserForm").addEventListener("submit", function (e) {
        e.preventDefault();
        adduser();
    });

    // Edit user Form Submission
    document.querySelector("#edituserForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const userId = document.querySelector("#edituserForm input[name='user_id']").value;
        updateuser(userId);
    });

    // Attach event listeners for delete buttons
    attachDeleteListeners();
});

function fetchusers() {
    fetch('./api/user/fetch-users.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateuserTable(data.users);
            } else {
                alertify.error('Failed to fetch users');
                showNoDataMessage();
            }
        })
        .catch(error => {
            console.error('Error fetching users:', error);
            alertify.error('An unexpected error occurred.');
            showNoDataMessage();
        });
}

function populateuserTable(users) {
    const tableBody = document.querySelector("#userTableBody");
    tableBody.innerHTML = "";
    if (users.length === 0) {
        showNoDataMessage();
    } else {
        users.forEach((user, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${user.name}</td>
                
                <td>
                ${user.status === 'active'
                ? '<span class="badge bg-success-light d-inline-flex align-items-center">Active</span>'
                : '<span class="badge bg-danger-light d-inline-flex align-items-center">Deleted</span>'}
            </td>
                
                <td class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="btn-action-icon me-2 edit-user-btn" data-user-id="${user.id}" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="fe fe-edit"></i></a>
                    <a href="javascript:void(0);" class="btn-action-icon delete-user-btn" data-user-id="${user.id}" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="fe fe-trash-2"></i></a>
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
    const tableBody = document.querySelector("#userTableBody");
    tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No users found</td></tr>`;
}

function adduser() {
    const form = document.querySelector("#adduserForm");
    const formData = new FormData(form);

    fetch('./api/user/add-user.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('user added successfully');
                fetchusers();
                form.reset();
                const modalElement = document.querySelector("#add_user");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to add user');
            }
        })
        .catch(error => {
            console.error('Error adding user:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function updateuser(userId) {
    const form = document.querySelector("#edituserForm");
    const formData = new FormData(form);
    formData.append('user_id', userId);

    fetch('./api/user/update-user.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('user updated successfully');
                fetchusers();
                const modalElement = document.querySelector("#edit_user");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to update user');
            }
        })
        .catch(error => {
            console.error('Error updating user:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function deleteuser(userId) {
    fetch('./api/user/delete-user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: userId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('user deleted successfully');
                fetchusers();
            } else {
                alertify.error('Failed to delete user');
            }
        })
        .catch(error => {
            console.error('Error deleting user:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function attachEditListeners() {
    document.querySelectorAll(".edit-user-btn").forEach(button => {
        button.addEventListener("click", function () {
            const userId = this.dataset.userId;
            fetchuserData(userId);
        });
    });
}

function attachDeleteListeners() {
    document.querySelectorAll(".delete-user-btn").forEach(button => {
        button.addEventListener("click", function () {
            const userId = this.dataset.userId;
            document.querySelector("#delete_modal .btn-primary.paid-continue-btn").addEventListener("click", function () {
                deleteuser(userId);
            });
        });
    });
}

function fetchuserData(userId) {
    fetch(`./api/user/get-user.php?id=${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.user;
                document.querySelector("#edituserForm input[name='user_id']").value = user.id || "";
                document.querySelector("#edituserForm input[name='name']").value = user.name || "";
                document.querySelector("#user_status").value = user.status || "";
            } else {
                alertify.error('Failed to fetch user details');
            }
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
            alertify.error('An unexpected error occurred.');
        });
}