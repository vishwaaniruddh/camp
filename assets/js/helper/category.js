document.addEventListener("DOMContentLoaded", function () {
    fetchCategories();

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

function fetchCategories() {
    fetch('./api/category/fetch-categories.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateCategoryTable(data.categories);
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

function populateCategoryTable(categories) {
    const tableBody = document.querySelector("#categoryTableBody");
    tableBody.innerHTML = "";
    if (categories.length === 0) {
        showNoDataMessage();
    } else {
        categories.forEach((category, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
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