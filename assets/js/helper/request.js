// document.addEventListener("DOMContentLoaded", function () {
//     const requestTableBody = document.querySelector("#requestTableBody");
//     if (requestTableBody) {
//         fetchRequest();
//     }
// });

const statusLabels = {
    0: "Select",
    1: "Material Requirement",
    2: "Available",
    3: "Not Available",
    4: "Dispatched",
    5: "Confirm Processed",
    6: "Cancelled"
};
document.getElementById("applyFilters").addEventListener("click", function () {
    fetchRequest();
});

function fetchCouriers() {
    return fetch('./api/couriers/fetch-couriers.php')
        .then(response => response.json())
        .then(data => {
            
            if (data.success) {
                populateCourierOptions(data.couriers);
            } else {
                alertify.error('Failed to fetch couriers');
            }
        })
        .catch(error => {
            console.error('Error fetching couriers:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function populateCourierOptions(courier) {
    const courierSelect = document.querySelector("#fetch_courier_dropdown");
    if (!courierSelect) {
        console.error('Courier select element not found');
        return;
    }
    courierSelect.innerHTML = "";

    // Add default first option
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select a Courier";
    courierSelect.appendChild(defaultOption);

    if (courier.length === 0) {
        courierSelect.innerHTML += `<option value="">No courier available</option>`;
    } else {
        courier.forEach(courier => {
            const option = document.createElement("option");
            option.value = courier.couriername;
            option.textContent = courier.couriername;
            courierSelect.appendChild(option);
        });
    }
}

function fetchRequest(page = 1, limit = 10) {
    const filters = {
        status: document.getElementById("status").value
    };

    if (filters.status > 0) {
        const queryString = new URLSearchParams(filters).toString();

        fetch(`./api/request/fetch-request.php?page=${page}&limit=${limit}&${queryString}`)
            .then(response => response.json())
            .then(data => {
                if (data.success === true) {

                    console.log(data)
                    document.getElementById("count").innerHTML = data.totalRecords;

                    populateRequestData(data.data, page, limit);
                    setupPagination(data.pagination.total_pages, page);

                    // Show current selected status
                    const currentSelectedStatus = document.getElementById("currentSelectedStatus");
                    if (currentSelectedStatus) {
                        currentSelectedStatus.textContent = ` ( Current Selected: ${statusLabels[filters.status]} ) `;
                    }
                } else {
                    alertify.error('Failed to fetch requests');
                }
            })
            .catch(error => {
                console.error('Error fetching requests:', error);
                alertify.error('An unexpected error occurred.');
            });
    } else {
        const tableBody = document.querySelector("#requestTableBody");
        if (tableBody) {
            tableBody.innerHTML = `<tr><td colspan="12" class="text-center">Please Select Filter To Fetch Records...</td></tr>`;
        }

        // Clear current selected status
        const currentSelectedStatus = document.getElementById("currentSelectedStatus");
        if (currentSelectedStatus) {
            currentSelectedStatus.textContent = '';
        }
    }
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
        fetchRequest(1);
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
        fetchRequest(currentPage - 1);
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
            fetchRequest(i);
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
        fetchRequest(currentPage + 1);
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
        fetchRequest(totalPages);
    });
    lastLi.appendChild(lastLink);
    ul.appendChild(lastLi);

    paginationContainer.appendChild(ul);
}

// Initial fetch
document.addEventListener('DOMContentLoaded', () => {
    fetchRequest();
});

function populateRequestData(requestDatas, page, limit) {


    const tableBody = document.querySelector("#requestTableBody");
    if (!tableBody) {
        console.error('Table body element not found');
        return;
    }
    tableBody.innerHTML = "";
    if (requestDatas.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="12" class="text-center">No requests found</td></tr>`;
    } else {
        requestDatas.forEach((requestData, index) => {
            const row = document.createElement("tr");
            const serialNumber = (page - 1) * limit + index + 1;

            row.innerHTML = `
                <td>${serialNumber}</td>
                <td>
                    <button style="border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-outline-primary view-request-btn" data-request-id="${requestData.mis_id}">View</button>
                </td>
                <td><strong>${requestData.ticket_id}</strong></td>
                <td>${requestData.customer}</td>
                <td>${requestData.bank}</td>
                <td>${requestData.atmid}</td>
                <td>${requestData.material_condition}</td>
                <td>${requestData.material}</td>
                <td>${requestData.location}</td>
                <td>
                    <h2 class="table-avatar">    
                        <a href="#">${requestData.contact_person_name} <span>${requestData.contact_person_mob}</span></a>
                    </h2>
                </td>
                <td>${requestData.remark}</td>
                <td>${requestData.created_at}</td>

                <td>${requestData.location}</td>
                <td>${requestData.city}</td>
                <td>${requestData.state}</td>
                <td>${requestData.zone}</td>
                <td>${requestData.mis_id}</td>
                <td>${requestData.user_created_by}</td>

                
            `;
            tableBody.appendChild(row);


        });

        // Add event listeners for view buttons
        document.querySelectorAll('.view-request-btn').forEach(button => {
            button.addEventListener('click', function () {
                const requestId = this.getAttribute('data-request-id');
                viewRequestInfo(requestId);
            });
        });

        // Add event listeners for accept buttons
        // document.querySelectorAll('.accept-request-btn').forEach(button => {
        //     button.addEventListener('click', function () {
        //         const requestId = this.getAttribute('data-request-id');
        //         acceptRequest(requestId);
        //     });
        // });
    }
}

function viewRequestInfo(requestId) {

    // fetch()

    fetchRequestInfo(requestId);
    fetchCouriers();
    // You can fetch and display the request details in a modal or another section of the page
}

// function acceptRequest(requestId) {
//     // Implement the logic to accept the request
//     console.log(`Accept request for ID: ${requestId}`);
//     // You can send a request to the server to update the status of the request
// }



function fetchRequestInfo(requestId) {
    fetch(`./api/request/fetch-request-info.php?request_id=${requestId}`)
        .then(response => response.json())
        .then(data => {

            // console.table(data.request)
            if (data.status === 'success') {
                populateRequestInfoModal(data.request);
            } else {
                alertify.error('Failed to fetch request information');
            }
        })
        .catch(error => {
            console.error('Error fetching request information:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function populateRequestInfoModal(request) {
    console.table(request)

    document.getElementById('address').value = request.delivery_address;
    document.getElementById('contact_person_name').value = request.contact_person_name;
    document.getElementById('contact_person_mobile').value = request.contact_person_mob;


    // Store the request ID in a hidden field for later use
    document.getElementById('request_id').value = request.mis_id;
}

// Function to handle the update action
function updateRequestInfo(event) {
    event.preventDefault();

    const productId = document.getElementById('product_id').value;
    const productName = document.getElementById('product_name').value;

    const data = {
        id: productId,
        product_name: productName,
    };

    fetch('./api/inventory/update-product-info.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('Product information updated successfully');
                fetchRequest(); // Refresh the inventory list
            } else {
                alertify.error('Failed to update product information');
            }
        })
        .catch(error => {
            console.error('Error updating product information:', error);
            alertify.error('An unexpected error occurred.');
        });
}

// Add event listener to the update button
// document.getElementById('edit_inventory_form').addEventListener('submit', updateRequestInfo);




document.getElementById('submit_dispatch_info_form').addEventListener('submit', function (event) {
    event.preventDefault();

    // Gather form data
    const formData = new FormData(this);
    let data = {};
    formData.forEach((value, key) => {
        data[key] = value.trim(); // Trim values to remove extra spaces
    });

    // Send data using Fetch API
    fetch('./api/request/submit-dispatch-info.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(responseData => {
        if (responseData.success) {
            alertify.success('Dispatch Info added successfully');
            fetchRequest(); // Refresh the inventory list
            document.getElementById('submit_dispatch_info_form').reset(); // Reset form after submission
        } else {
            alertify.error(responseData.message || 'Failed to add Dispatch Info');
        }
    })
    .catch(error => {
        console.error('Error adding Dispatch Info:', error);
        alertify.error('An unexpected error occurred.');
    });
});
