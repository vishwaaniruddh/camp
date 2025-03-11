document.addEventListener("DOMContentLoaded", function () {
    fetchbanks();

    document.getElementById("applyFilters").addEventListener("click", function () {
        fetchbanks();
    });
    document.getElementById("downloadCSV").addEventListener("click", function () {
        downloadCSV();
    });
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

function fetchbanks(page = 1, limit = 20) {
    
    const tableBody = document.querySelector("#bankTableBody"); // Assuming the table has an id of 'vendorTable'
    if (!tableBody) {
        console.error("Table body element not found");
        return;
    }
    const filters = {
        name: document.getElementById("filterName").value,
        status: document.getElementById("filterStatus").value
    };

    const queryString = new URLSearchParams(filters).toString();

    fetch(`./api/bank/fetch-banks.php?page=${page}&limit=${limit}&${queryString}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populatebankTable(data.banks, page, limit);
                setupPagination(data.pagination.total_pages, page);

            } else {
                alertify.error('Failed to fetch banks');
                showNoDataMessage();
            }
        })
        .catch(error => {
            console.error('Error fetching banks:', error);
            alertify.error('An unexpected error occurred.',error);
            showNoDataMessage();
        });
}

function populatebankTable(banks,page, limit) {
    const tableBody = document.querySelector("#bankTableBody");
    tableBody.innerHTML = "";
    if (banks.length === 0) {
        showNoDataMessage();
    } else {
        banks.forEach((bank, index) => {
        const serialNumber = (page - 1) * limit + index + 1;

            const row = document.createElement("tr");
            row.innerHTML = `
                            <td>${serialNumber}</td>
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
                document.querySelector("#bank_status").value = bank.status || "";
            } else {
                alertify.error('Failed to fetch bank details');
            }
        })
        .catch(error => {
            console.error('Error fetching bank data:', error);
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

    fetch(`./api/bank/export-bank.php?${queryString}`, {
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
            a.download = 'CAMP_Bank_Data.csv';
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
        fetchbanks(1);
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
        fetchbanks(currentPage - 1);
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
            fetchbanks(i);
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
        fetchbanks(currentPage + 1);
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
        fetchbanks(totalPages);
    });
    lastLi.appendChild(lastLink);
    ul.appendChild(lastLi);

    paginationContainer.appendChild(ul);
}