CREATE TABLE camp_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    sku VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    selling_price DECIMAL(10, 2) NOT NULL,
    purchase_price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    units VARCHAR(50),
    discount_type VARCHAR(50),
    barcode VARCHAR(255),
    alert_quantity INT,
    tax VARCHAR(50),
    description TEXT,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by VARCHAR(255) NOT NULL,
    status ENUM('active', 'deleted') DEFAULT 'active'
);