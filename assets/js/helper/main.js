function generateSerialNumber() {
    const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const digits = "0123456789";

    let prefix = "";
    for (let i = 0; i < 3; i++) {
        prefix += letters[Math.floor(Math.random() * letters.length)];
    }

    let randomDigits = "";
    for (let i = 0; i < 4; i++) {
        randomDigits += digits[Math.floor(Math.random() * digits.length)];
    }

    let suffix = "";
    for (let i = 0; i < 3; i++) {
        suffix += letters[Math.floor(Math.random() * letters.length)];
    }

    const year = new Date().getFullYear();
    return `${prefix}-${randomDigits}-${suffix}-${year}`;
}

function getStatusBadge(status) {
    switch (status) {
        case 'Pending':
            return '<span class="badge bg-warning badge d-inline-flex align-items-center">Pending</span>';
        case 'Approved':
            return '<span class="badge bg-success d-inline-flex align-items-center">Approved</span>';
        case 'Fulfilled':
            return '<span class="badge bg-primary d-inline-flex align-items-center">Fulfilled</span>';
        case 'Cancelled':
            return '<span class="badge bg-danger d-inline-flex align-items-center">Cancelled</span>';
        case 'Deleted':
            return '<span class="badge bg-danger d-inline-flex align-items-center">Deleted</span>';
        default:
            return '<span class="badge bg-secondary d-inline-flex align-items-center">Unknown</span>';
    }
}

function generatePONumber() {
    const skuField = document.querySelector("input[name='po_number']");
    skuField.value = 'CAMP-' + Math.random().toString(36).substr(2, 9).toUpperCase();
}
