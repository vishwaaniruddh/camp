document.addEventListener("DOMContentLoaded", function () {
    fetchCategories();

    document.getElementById("applyFilters").addEventListener("click", function () {
        fetchCategories();
    });
    document.getElementById("downloadCSV").addEventListener("click", function () {
        downloadCSV();
    });


    // Add Category Form Submission
    document.querySelector("#addCategoryForm").addEventListener("submit", function (e) {
        e.preventDefault();
        addCategory();
    });

    // Edit Category Form Submission
    document.querySelector("#editCategoryForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const categoryId = document.querySelector("#editCategoryForm input[name='category_id']").value;
        updateCategory(categoryId);
    });

    // Attach event listeners for delete buttons
    attachDeleteListeners();
});

function fetchCategories(page = 1, limit = 20) {

    const tableBody = document.querySelector("#categoryTableBody"); // Assuming the table has an id of 'vendorTable'
    if (!tableBody) {
        console.error("Table body element not found");
        return;
    }
    const filters = {
        name: document.getElementById("filterName").value,
        status: document.getElementById("filterStatus").value
    };

    const queryString = new URLSearchParams(filters).toString();

    fetch(`./api/category/fetch-categories.php?page=${page}&limit=${limit}&${queryString}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateCategoryTable(data.categories, page, limit);
                setupPagination(data.pagination.total_pages, page);

            } else {
                alertify.error('Failed to fetch categories');
                showNoDataMessage();
            }
        })
        .catch(error => {
            console.error('Error fetching categories:', error);
            alertify.error('An unexpected error occurred.');
            showNoDataMessage();
        });
}

function populateCategoryTable(categories, page, limit) {
    const tableBody = document.querySelector("#categoryTableBody");
    tableBody.innerHTML = "";
    if (categories.length === 0) {
        showNoDataMessage();
    } else {
        categories.forEach((category, index) => {
            const serialNumber = (page - 1) * limit + index + 1;

            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${serialNumber}</td>
                <td>${category.name}</td>
                <td>${category.slug}</td>
                
                <td>
                ${category.status === 'active'
                ? '<span class="badge bg-success-light d-inline-flex align-items-center">Active</span>'
                : '<span class="badge bg-danger-light d-inline-flex align-items-center">Deleted</span>'}
            </td>
                
                <td class="d-flex align-items-center">
                    <a href="javascript:void(0);" class="btn-action-icon me-2 edit-category-btn" data-category-id="${category.id}" data-bs-toggle="modal" data-bs-target="#edit_category"><i class="fe fe-edit"></i></a>
                    <a href="javascript:void(0);" class="btn-action-icon delete-category-btn" data-category-id="${category.id}" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="fe fe-trash-2"></i></a>
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
    const tableBody = document.querySelector("#categoryTableBody");
    tableBody.innerHTML = `<tr><td colspan="5" class="text-center">No categories found</td></tr>`;
}

function addCategory() {
    const form = document.querySelector("#addCategoryForm");
    const formData = new FormData(form);

    fetch('./api/category/add-category.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('Category added successfully');
                fetchCategories();
                form.reset();
                const modalElement = document.querySelector("#add_category");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to add category');
            }
        })
        .catch(error => {
            console.error('Error adding category:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function updateCategory(categoryId) {
    const form = document.querySelector("#editCategoryForm");
    const formData = new FormData(form);
    formData.append('category_id', categoryId);

    fetch('./api/category/update-category.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('Category updated successfully');
                fetchCategories();
                const modalElement = document.querySelector("#edit_category");
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) modalInstance.hide();
            } else {
                alertify.error('Failed to update category');
            }
        })
        .catch(error => {
            console.error('Error updating category:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function deleteCategory(categoryId) {
    fetch('./api/category/delete-category.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: categoryId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertify.success('Category deleted successfully');
                fetchCategories();
            } else {
                alertify.error('Failed to delete category');
            }
        })
        .catch(error => {
            console.error('Error deleting category:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function attachEditListeners() {
    document.querySelectorAll(".edit-category-btn").forEach(button => {
        button.addEventListener("click", function () {
            const categoryId = this.dataset.categoryId;
            fetchCategoryData(categoryId);
        });
    });
}

function attachDeleteListeners() {
    document.querySelectorAll(".delete-category-btn").forEach(button => {
        button.addEventListener("click", function () {
            const categoryId = this.dataset.categoryId;
            document.querySelector("#delete_modal .btn-primary.paid-continue-btn").addEventListener("click", function () {
                deleteCategory(categoryId);
            });
        });
    });
}

function fetchCategoryData(categoryId) {
    fetch(`./api/category/get-category.php?id=${categoryId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const category = data.category;
                document.querySelector("#editCategoryForm input[name='category_id']").value = category.id || "";
                document.querySelector("#editCategoryForm input[name='name']").value = category.name || "";
                document.querySelector("#editCategoryForm input[name='slug']").value = category.slug || "";
            } else {
                alertify.error('Failed to fetch category details');
            }
        })
        .catch(error => {
            console.error('Error fetching category data:', error);
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

    fetch(`./api/category/export-categories.php?${queryString}`, {
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
            a.download = 'CAMP_CUSTOMER_Data.csv';
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
        fetchCategories(1);
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
        fetchCategories(currentPage - 1);
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
            fetchCategories(i);
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
        fetchCategories(currentPage + 1);
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
        fetchCategories(totalPages);
    });
    lastLi.appendChild(lastLink);
    ul.appendChild(lastLi);

    paginationContainer.appendChild(ul);
}