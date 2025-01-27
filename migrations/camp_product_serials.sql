CREATE TABLE camp_product_serials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    serial_number VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES camp_products(id) ON DELETE CASCADE
);