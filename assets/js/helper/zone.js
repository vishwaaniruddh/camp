document.addEventListener("DOMContentLoaded", function () {
    fetchzones();

    document.getElementById("applyFilters").addEventListener("click", function () {
        fetchzones();
    });
    document.getElementById("downloadCSV").addEventListener("click", function () {
        downloadCSV();
    });
    // Add zone Form Submission
    document.querySelector("#addzoneForm").addEventListener("submit", function (e) {
        e.preventDefault();
        addzone();
    });

    // Edit zone Form Submission
    document.querySelector("#editzoneForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const zoneId = document.querySelector("#editzoneForm input[name='zone_id']").value;
        updatezone(zoneId);
    });

    // Attach event listeners for delete buttons
    attachDeleteListeners();
});

function fetchzones(page = 1, limit = 20) {
    
    const tableBody = document.querySelector("#zoneTableBody"); // Assuming the table has an id of 'vendorTable'
    if (!tableBody) {
        console.error("Table body element not found");
        return;
    }
    const filters = {
        name: document.getElementById("filterName").value,
        status: document.getElementById("filterStatus").value
    };

    const queryString = new URLSearchParams(filters).toString();

    fetch(`./api/zone/fetch-zones.php?page=${page}&limit=${limit}&${queryString}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populatezoneTable(data.zones, page, limit);
                setupPagination(data.pagination.total_pages, page);

            } else {
                alertify.error('Failed to fetch zones');
                showNoDataMessage();
            }
        })
        .catch(error => {
            console.error('Error fetching zones:', error);
            alertify.error('An unexpected error occurred.',error);
            showNoDataMessage();
        });
}

function populatezoneTable(zones,page, limit) {
    const tableBody = document.querySelector("#zoneTableBody");
    tableBody.innerHTML = "";
    if (zones.length === 0) {
        showNoDataMessage();
    } else {
        zones.forEach((zone, index) => {
        const serialNumber = (page - 1) * limit + index + 1;

            const row = document.createElement("tr");
            row.innerHTML = `
                            <td>${serialNumber}</td>
                <td>${zone.name}</td>
                
                <td>
                ${zone.status === 'active'
                ? '<span class="badge bg-success-light d-inline-flex align-items-center">Active</span>'
                : '<span class="badge bg-danger-light d-inline-flex align-items-center">Deleted</span>'}
            </td>
                
                <td class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="btn-action-icon me-2 edit-zone-btn" data-zone-id="${zone.id}" data-bs-toggle="modal" data-bs-target="#edit_zone"><i class="fe fe-edit"></i></a>
                    <a href="javascript:void(0);" class="btn-action-icon delete-zone-btn" data-zone-id="${zone.id}" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="fe fe-trash-2"></i></a>
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
    const tableBody = document.querySelector("#zoneTableBody");
    tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No zones found</td></tr>`;
}

function addzone() {
    const form = document.querySelector("#addzoneForm");
    const formData = new FormData(form);

    fetch('./api/zone/add-zone.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('zone added successfully');
                fetchzones();
                form.reset();
                const modalElement = document.querySelector("#add_zone");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to add zone');
            }
        })
        .catch(error => {
            console.error('Error adding zone:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function updatezone(zoneId) {
    const form = document.querySelector("#editzoneForm");
    const formData = new FormData(form);
    formData.append('zone_id', zoneId);

    fetch('./api/zone/update-zone.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('zone updated successfully');
                fetchzones();
                const modalElement = document.querySelector("#edit_zone");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to update zone');
            }
        })
        .catch(error => {
            console.error('Error updating zone:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function deletezone(zoneId) {
    fetch('./api/zone/delete-zone.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: zoneId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('zone deleted successfully');
                fetchzones();
            } else {
                alertify.error('Failed to delete zone');
            }
        })
        .catch(error => {
            console.error('Error deleting zone:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function attachEditListeners() {
    document.querySelectorAll(".edit-zone-btn").forEach(button => {
        button.addEventListener("click", function () {
            const zoneId = this.dataset.zoneId;
            fetchzoneData(zoneId);
        });
    });
}

function attachDeleteListeners() {
    document.querySelectorAll(".delete-zone-btn").forEach(button => {
        button.addEventListener("click", function () {
            const zoneId = this.dataset.zoneId;
            document.querySelector("#delete_modal .btn-primary.paid-continue-btn").addEventListener("click", function () {
                deletezone(zoneId);
            });
        });
    });
}

function fetchzoneData(zoneId) {
    fetch(`./api/zone/get-zone.php?id=${zoneId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const zone = data.zone;
                document.querySelector("#editzoneForm input[name='zone_id']").value = zone.id || "";
                document.querySelector("#editzoneForm input[name='name']").value = zone.name || "";
                document.querySelector("#zone_status").value = zone.status || "";
            } else {
                alertify.error('Failed to fetch zone details');
            }
        })
        .catch(error => {
            console.error('Error fetching zone data:', error);
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

    fetch(`./api/zone/export-zone.php?${queryString}`, {
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
            a.download = 'CAMP_zone_Data.csv';
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
        fetchzones(1);
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
        fetchzones(currentPage - 1);
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
            fetchzones(i);
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
        fetchzones(currentPage + 1);
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
        fetchzones(totalPages);
    });
    lastLi.appendChild(lastLink);
    ul.appendChild(lastLi);

    paginationContainer.appendChild(ul);
}