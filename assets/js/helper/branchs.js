document.addEventListener("DOMContentLoaded", function () {
    fetchbranchs();
    fetchZones();

    document.getElementById("applyFilters").addEventListener("click", function () {
        fetchbranchs();
    });
    document.getElementById("downloadCSV").addEventListener("click", function () {
        downloadCSV();
    });
    // Add branch Form Submission
    document.querySelector("#addbranchForm").addEventListener("submit", function (e) {
        e.preventDefault();
        addbranch();
    });

    // Edit branch Form Submission
    document.querySelector("#editbranchForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const branchId = document.querySelector("#editbranchForm input[name='branch_id']").value;
        updatebranch(branchId);
    });

    // Attach event listeners for delete buttons
    attachDeleteListeners();
});

function fetchbranchs(page = 1, limit = 20) {
    
    const tableBody = document.querySelector("#branchTableBody"); // Assuming the table has an id of 'vendorTable'
    if (!tableBody) {
        console.error("Table body element not found");
        return;
    }
    const filters = {
        name: document.getElementById("filterName").value,
        status: document.getElementById("filterStatus").value
    };

    const queryString = new URLSearchParams(filters).toString();

    fetch(`./api/branch/fetch-branchs.php?page=${page}&limit=${limit}&${queryString}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log(data)
                populatebranchTable(data.data, page, limit);
                setupPagination(data.pagination.total_pages, page);

            } else {
                alertify.error('Failed to fetch branchs');
                showNoDataMessage();
            }
        })
        .catch(error => {
            console.error('Error fetching branchs:', error);
            alertify.error('An unexpected error occurred.',error);
            showNoDataMessage();
        });
}

function populatebranchTable(branchs,page, limit) {
    const tableBody = document.querySelector("#branchTableBody");
    tableBody.innerHTML = "";
    if (branchs.length === 0) {
        showNoDataMessage();
    } else {
        branchs.forEach((branch, index) => {
        const serialNumber = (page - 1) * limit + index + 1;

            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${serialNumber}</td>
                <td>${branch.name}</td>
                <td>${branch.zone_name}</td>
                <td>
                    ${branch.status === 'active'
                    ? '<span class="badge bg-success-light d-inline-flex align-items-center">Active</span>'
                    : '<span class="badge bg-danger-light d-inline-flex align-items-center">Deleted</span>'}
                </td>
                <td class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="btn-action-icon me-2 edit-branch-btn" data-branch-id="${branch.id}" data-bs-toggle="modal" data-bs-target="#edit_branch"><i class="fe fe-edit"></i></a>
                    <a href="javascript:void(0);" class="btn-action-icon delete-branch-btn" data-branch-id="${branch.id}" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="fe fe-trash-2"></i></a>
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
    const tableBody = document.querySelector("#branchTableBody");
    tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No branchs found</td></tr>`;
}

function addbranch() {
    const form = document.querySelector("#addbranchForm");
    const formData = new FormData(form);

    fetch('./api/branch/add-branch.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('branch added successfully');
                fetchbranchs();
                form.reset();
                const modalElement = document.querySelector("#add_branch");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to add branch');
            }
        })
        .catch(error => {
            console.error('Error adding branch:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function updatebranch(branchId) {
    const form = document.querySelector("#editbranchForm");
    const formData = new FormData(form);
    formData.append('branch_id', branchId);

    fetch('./api/branch/update-branch.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('branch updated successfully');
                fetchbranchs();
                const modalElement = document.querySelector("#edit_branch");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to update branch');
            }
        })
        .catch(error => {
            console.error('Error updating branch:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function deletebranch(branchId) {
    fetch('./api/branch/delete-branch.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: branchId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('branch deleted successfully');
                fetchbranchs();
            } else {
                alertify.error('Failed to delete branch');
            }
        })
        .catch(error => {
            console.error('Error deleting branch:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function attachEditListeners() {
    document.querySelectorAll(".edit-branch-btn").forEach(button => {
        button.addEventListener("click", function () {
            const branchId = this.dataset.branchId;
            fetchbranchData(branchId);
        });
    });
}

function attachDeleteListeners() {
    document.querySelectorAll(".delete-branch-btn").forEach(button => {
        button.addEventListener("click", function () {
            const branchId = this.dataset.branchId;
            document.querySelector("#delete_modal .btn-primary.paid-continue-btn").addEventListener("click", function () {
                deletebranch(branchId);
            });
        });
    });
}

function fetchbranchData(branchId) {
    fetch(`./api/branch/get-branch.php?id=${branchId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const branch = data.branch;
                document.querySelector("#editbranchForm input[name='branch_id']").value = branch.id || "";
                document.querySelector("#editbranchForm input[name='name']").value = branch.name || "";
                document.querySelector("#branch_status").value = branch.status || "";
            } else {
                alertify.error('Failed to fetch branch details');
            }
        })
        .catch(error => {
            console.error('Error fetching branch data:', error);
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

    fetch(`./api/branch/export-branch.php?${queryString}`, {
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
            a.download = 'CAMP_branch_Data.csv';
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
        fetchbranchs(1);
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
        fetchbranchs(currentPage - 1);
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
            fetchbranchs(i);
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
        fetchbranchs(currentPage + 1);
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
        fetchbranchs(totalPages);
    });
    lastLi.appendChild(lastLink);
    ul.appendChild(lastLi);

    paginationContainer.appendChild(ul);
}


function fetchZones() {
    return fetch('./api/zone/fetch-zones.php')
        .then(response => response.json())
        .then(data => {

            console.log(data);
            if (data.success) {
                populateZonesOptions(data.zones);
            } else {
                alertify.error('Failed to fetch Zones');
            }
        })
        .catch(error => {
            console.error('Error fetching Zones:', error);
            alertify.error('An unexpected error occurred.');
        });
}
function populateZonesOptions(Zones) {

    const zoneSelect = document.querySelector("#zone");
    if (!zoneSelect) {
        console.error('zone select element not found');
        return;
    }
    zoneSelect.innerHTML = "";

    // Add default first option
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select a zone";
    zoneSelect.appendChild(defaultOption);

    if (Zones.length === 0) {
        zoneSelect.innerHTML += `<option value="">No Zones available</option>`;
    } else {
        Zones.forEach(zone => {
            const option = document.createElement("option");
            option.value = zone.id;
            option.textContent = zone.name;
            zoneSelect.appendChild(option);
        });
    }
}