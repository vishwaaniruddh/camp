fetchVendors();

function calculateTotalCost() {
    let totalCost = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        const stock = parseFloat(row.querySelector('.stock').value) || 0;
        const unitCost = parseFloat(row.querySelector('.unit-cost').value) || 0;
        totalCost += stock * unitCost;
    });
    document.getElementById('total_cost').value = totalCost.toFixed(2);
}

function updateSerialNumbers() {
    document.querySelectorAll('.product-row').forEach((row, index) => {
        row.querySelector('.serial-number').textContent = index + 1;
    });
}

document.getElementById('add-row').addEventListener('click', function() {
    var productRow = document.querySelector('.product-row');
    var newRow = productRow.cloneNode(true);
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    newRow.querySelector('.remove-row').addEventListener('click', function() {
        newRow.remove();
        calculateTotalCost();
        updateSerialNumbers();
    });
    newRow.querySelector('.stock').addEventListener('input', calculateTotalCost);
    newRow.querySelector('.unit-cost').addEventListener('input', calculateTotalCost);
    document.getElementById('product-rows').appendChild(newRow);
    updateSerialNumbers();
});

document.querySelectorAll('.remove-row').forEach(button => {
    button.addEventListener('click', function() {
        button.closest('tr').remove();
        calculateTotalCost();
        updateSerialNumbers();
    });
});

document.querySelectorAll('.stock, .unit-cost').forEach(input => {
    input.addEventListener('input', calculateTotalCost);
});

updateSerialNumbers();


function fetchVendors() {
    return fetch('./api/vendor/fetch_all_vendors.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateVendorsOptions(data.vendors);
            } else {
                alertify.error('Failed to fetch Vendors');
            }
        })
        .catch(error => {
            console.error('Error fetching Vendors:', error);
            alertify.error('An unexpected error occurred.');
        });
}

function populateVendorsOptions(Vendors) {
    const vendorSelect = document.querySelector("#vendor");
    if (!vendorSelect) {
        console.error('vendor select element not found');
        return;
    }
    vendorSelect.innerHTML = "";

    // Add default first option
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select a vendor";
    vendorSelect.appendChild(defaultOption);

    if (Vendors.length === 0) {
        vendorSelect.innerHTML += `<option value="">No Vendors available</option>`;
    } else {
        Vendors.forEach(vendor => {
            const option = document.createElement("option");
            option.value = vendor.name;
            option.textContent = vendor.name;
            vendorSelect.appendChild(option);
        });
    }
}