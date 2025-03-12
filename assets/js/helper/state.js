document.addEventListener("DOMContentLoaded", function () {
    fetchstates();

    document.getElementById("applyFilters").addEventListener("click", function () {
        fetchstates();
    });
    document.getElementById("downloadCSV").addEventListener("click", function () {
        downloadCSV();
    });
    // Add state Form Submission
    document.querySelector("#addstateForm").addEventListener("submit", function (e) {
        e.preventDefault();
        addstate();
    });

    // Edit state Form Submission
    document.querySelector("#editstateForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const stateId = document.querySelector("#editstateForm input[name='state_id']").value;
        updatestate(stateId);
    });

    // Attach event listeners for delete buttons
    attachDeleteListeners();
});

function fetchstates(page = 1, limit = 20) {
    
    const tableBody = document.querySelector("#stateTableBody"); // Assuming the table has an id of 'vendorTable'
    if (!tableBody) {
        console.error("Table body element not found");
        return;
    }
    const filters = {
        name: document.getElementById("filterName").value,
        status: document.getElementById("filterStatus").value
    };

    const queryString = new URLSearchParams(filters).toString();

    fetch(`./api/state/fetch-states.php?page=${page}&limit=${limit}&${queryString}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populatestateTable(data.states, page, limit);
                setupPagination(data.pagination.total_pages, page);

            } else {
                alertify.error('Failed to fetch states');
                showNoDataMessage();
            }
        })
        .catch(error => {
            console.error('Error fetching states:', error);
            alertify.error('An unexpected error occurred.',error);
            showNoDataMessage();
        });
}

function populatestateTable(states,page, limit) {
    const tableBody = document.querySelector("#stateTableBody");
    tableBody.innerHTML = "";
    if (states.length === 0) {
        showNoDataMessage();
    } else {
        states.forEach((state, index) => {
        const serialNumber = (page - 1) * limit + index + 1;

            const row = document.createElement("tr");
            row.innerHTML = `
                            <td>${serialNumber}</td>
                <td>${state.name}</td>
                
                <td>
                ${state.status === 'active'
                ? '<span class="badge bg-success-light d-inline-flex align-items-center">Active</span>'
                : '<span class="badge bg-danger-light d-inline-flex align-items-center">Deleted</span>'}
            </td>
                
                <td class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="btn-action-icon me-2 edit-state-btn" data-state-id="${state.id}" data-bs-toggle="modal" data-bs-target="#edit_state"><i class="fe fe-edit"></i></a>
                    <a href="javascript:void(0);" class="btn-action-icon delete-state-btn" data-state-id="${state.id}" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="fe fe-trash-2"></i></a>
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
    const tableBody = document.querySelector("#stateTableBody");
    tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No states found</td></tr>`;
}

function addstate() {
    const form = document.querySelector("#addstateForm");
    const formData = new FormData(form);

    fetch('./api/state/add-state.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('state added successfully');
                fetchstates();
                form.reset();
                const modalElement = document.querySelector("#add_state");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to add state');
            }
        })
        .catch(error => {
            console.error('Error adding state:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function updatestate(stateId) {
    const form = document.querySelector("#editstateForm");
    const formData = new FormData(form);
    formData.append('state_id', stateId);

    fetch('./api/state/update-state.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('state updated successfully');
                fetchstates();
                const modalElement = document.querySelector("#edit_state");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to update state');
            }
        })
        .catch(error => {
            console.error('Error updating state:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function deletestate(stateId) {
    fetch('./api/state/delete-state.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: stateId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('state deleted successfully');
                fetchstates();
            } else {
                alertify.error('Failed to delete state');
            }
        })
        .catch(error => {
            console.error('Error deleting state:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function attachEditListeners() {
    document.querySelectorAll(".edit-state-btn").forEach(button => {
        button.addEventListener("click", function () {
            const stateId = this.dataset.stateId;
            fetchstateData(stateId);
        });
    });
}

function attachDeleteListeners() {
    document.querySelectorAll(".delete-state-btn").forEach(button => {
        button.addEventListener("click", function () {
            const stateId = this.dataset.stateId;
            document.querySelector("#delete_modal .btn-primary.paid-continue-btn").addEventListener("click", function () {
                deletestate(stateId);
            });
        });
    });
}

function fetchstateData(stateId) {
    fetch(`./api/state/get-state.php?id=${stateId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const state = data.state;
                document.querySelector("#editstateForm input[name='state_id']").value = state.id || "";
                document.querySelector("#editstateForm input[name='name']").value = state.name || "";
                document.querySelector("#state_status").value = state.status || "";
            } else {
                alertify.error('Failed to fetch state details');
            }
        })
        .catch(error => {
            console.error('Error fetching state data:', error);
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

    fetch(`./api/state/export-state.php?${queryString}`, {
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
            a.download = 'CAMP_state_Data.csv';
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
        fetchstates(1);
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
        fetchstates(currentPage - 1);
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
            fetchstates(i);
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
        fetchstates(currentPage + 1);
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
        fetchstates(totalPages);
    });
    lastLi.appendChild(lastLink);
    ul.appendChild(lastLi);

    paginationContainer.appendChild(ul);
}