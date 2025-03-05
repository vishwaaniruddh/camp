document.addEventListener("DOMContentLoaded", function () {
    fetchbanks();

    // Add bank Form Submission
    document.querySelector("#addbankForm").addEventListener("submit", function (e) {
        e.preventDefault();
        addbank();
    });

    // Edit bank Form Submission
    document.querySelector("#editbankForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const bankId = document.querySelector("#editbankForm input[name='bank_id']").value;
        updatebank(bankId);
    });

    // Attach event listeners for delete buttons
    attachDeleteListeners();
});

function fetchbanks() {
    fetch('./api/bank/fetch-banks.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populatebankTable(data.banks);
            } else {
                alertify.error('Failed to fetch banks');
                showNoDataMessage();
            }
        })
        .catch(error => {
            console.error('Error fetching banks:', error);
            alertify.error('An unexpected error occurred.');
            showNoDataMessage();
        });
}

function populatebankTable(banks) {
    const tableBody = document.querySelector("#bankTableBody");
    tableBody.innerHTML = "";
    if (banks.length === 0) {
        showNoDataMessage();
    } else {
        banks.forEach((bank, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${bank.name}</td>
                
                <td>
                ${bank.status === 'active'
                ? '<span class="badge bg-success-light d-inline-flex align-items-center">Active</span>'
                : '<span class="badge bg-danger-light d-inline-flex align-items-center">Deleted</span>'}
            </td>
                
                <td class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="btn-action-icon me-2 edit-bank-btn" data-bank-id="${bank.id}" data-bs-toggle="modal" data-bs-target="#edit_bank"><i class="fe fe-edit"></i></a>
                    <a href="javascript:void(0);" class="btn-action-icon delete-bank-btn" data-bank-id="${bank.id}" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="fe fe-trash-2"></i></a>
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
    const tableBody = document.querySelector("#bankTableBody");
    tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No banks found</td></tr>`;
}

function addbank() {
    const form = document.querySelector("#addbankForm");
    const formData = new FormData(form);

    fetch('./api/bank/add-bank.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('bank added successfully');
                fetchbanks();
                form.reset();
                const modalElement = document.querySelector("#add_bank");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to add bank');
            }
        })
        .catch(error => {
            console.error('Error adding bank:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function updatebank(bankId) {
    const form = document.querySelector("#editbankForm");
    const formData = new FormData(form);
    formData.append('bank_id', bankId);

    fetch('./api/bank/update-bank.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('bank updated successfully');
                fetchbanks();
                const modalElement = document.querySelector("#edit_bank");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to update bank');
            }
        })
        .catch(error => {
            console.error('Error updating bank:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function deletebank(bankId) {
    fetch('./api/bank/delete-bank.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: bankId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('bank deleted successfully');
                fetchbanks();
            } else {
                alertify.error('Failed to delete bank');
            }
        })
        .catch(error => {
            console.error('Error deleting bank:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function attachEditListeners() {
    document.querySelectorAll(".edit-bank-btn").forEach(button => {
        button.addEventListener("click", function () {
            const bankId = this.dataset.bankId;
            fetchbankData(bankId);
        });
    });
}

function attachDeleteListeners() {
    document.querySelectorAll(".delete-bank-btn").forEach(button => {
        button.addEventListener("click", function () {
            const bankId = this.dataset.bankId;
            document.querySelector("#delete_modal .btn-primary.paid-continue-btn").addEventListener("click", function () {
                deletebank(bankId);
            });
        });
    });
}

function fetchbankData(bankId) {
    fetch(`./api/bank/get-bank.php?id=${bankId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const bank = data.bank;
                document.querySelector("#editbankForm input[name='bank_id']").value = bank.id || "";
                document.querySelector("#editbankForm input[name='name']").value = bank.name || "";
            } else {
                alertify.error('Failed to fetch bank details');
            }
        })
        .catch(error => {
            console.error('Error fetching bank data:', error);
            alertify.error('An unexpected error occurred.');
        });
}