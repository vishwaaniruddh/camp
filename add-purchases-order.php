<?php include('./header.php'); 


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Fetch vendors
$vendors_sql = "SELECT * FROM camp_vendors ORDER BY name";
$vendors_result = $con->query($vendors_sql);

// Fetch products
$products_sql = "SELECT * FROM camp_products ORDER BY name";
$products_result = $con->query($products_sql);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Insert purchase order
        $sql = "INSERT INTO camp_purchase_orders_new (
            vendor_id, po_number, reference_no, order_date, due_date,
            discount_type, discount_value, tax_rate, bank_account,
            notes, taxable_amount, total_discount, total_tax,
            round_off, total_amount, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssdssddddisd",
            $_POST['vendor_id'],
            $_POST['po_number'],
            $_POST['reference_no'],
            $_POST['order_date'],
            $_POST['due_date'],
            $_POST['discount_type'],
            $_POST['discount_value'],
            $_POST['tax_rate'],
            $_POST['bank_account'],
            $_POST['notes'],
            $_POST['taxable_amount'],
            $_POST['total_discount'],
            $_POST['total_tax'],
            $_POST['round_off'],
            $_POST['total_amount'],
            $_POST['status']
        );
        
        $stmt->execute();
        $po_id = $conn->insert_id;

        // Insert purchase order items
        $items_sql = "INSERT INTO camp_purchase_order_items (
            purchase_order_id, product_id, quantity, unit,
            rate, discount, tax, amount
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $items_stmt = $conn->prepare($items_sql);
        
        foreach ($_POST['items'] as $item) {
            $items_stmt->bind_param("iidsdddd",
                $po_id,
                $item['product_id'],
                $item['quantity'],
                $item['unit'],
                $item['rate'],
                $item['discount'],
                $item['tax'],
                $item['amount']
            );
            $items_stmt->execute();
        }

        // Handle signature upload
        if (isset($_FILES['signature_image'])) {
            $target_dir = "uploads/signatures/";
            $file_extension = pathinfo($_FILES["signature_image"]["name"], PATHINFO_EXTENSION);
            $file_name = $po_id . '_' . time() . '.' . $file_extension;
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($_FILES["signature_image"]["tmp_name"], $target_file)) {
                $sig_sql = "INSERT INTO camp_signatures (purchase_order_id, name, signature_image)
                           VALUES (?, ?, ?)";
                $sig_stmt = $conn->prepare($sig_sql);
                $sig_stmt->bind_param("iss", $po_id, $_POST['signature_name'], $file_name);
                $sig_stmt->execute();
            }
        }

        $conn->commit();
        header("Location: purchase_orders.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $error = "Error creating purchase order: " . $e->getMessage();
    }
}
?>
			
			<div class="content container-fluid">
					<div class="card mb-0">
						<div class="card-body">
							<div class="content-page-header">
								<h5>Add Purchases Order</h5>
							</div>					 
							<div class="row">
								<div class="col-md-12">
									<div class="form-group-item border-0 mb-0">
										<div class="row align-item-center">
											<div class="col-lg-4 col-md-6 col-sm-12">
												<div class="input-block mb-3">
													<label>Purchases Id</label>
													<input type="text" class="form-control" placeholder="Enter Purchases Id">
												</div>
											</div>										
											<div class="col-lg-4 col-md-6 col-sm-12">											
												<div class="input-block mb-3">
													<label>Select Vendor</label>
													<ul class="form-group-plus css-equal-heights">
														<li>
														     <select class="select" id="vendor_id" name="vendor_id" required>
                            <option value="">Select Vendor</option>
                            <?php while ($vendor = $vendors_result->fetch_assoc()): ?>
                                <option value="<?php echo $vendor['id']; ?>">
                                    <?php echo htmlspecialchars($vendor['name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        
														
														</li>
														<li>    
															<a class="btn btn-primary form-plus-btn" href="add-customer.php"><i class="fas fa-plus-circle"></i></a>
														</li>
													</ul>												
												</div>									
											</div>
											<div class="col-lg-4 col-md-6 col-sm-12">
												<div class="input-block mb-3">
													<label>Purchases Order Date</label>
													<input type="text" class="datetimepicker form-control" placeholder="Select Date">
												</div>											
											</div>
											<div class="col-lg-4 col-md-6 col-sm-12">
												<div class="input-block mb-3">
													<label>Due Date</label>
													<input type="text" class="datetimepicker form-control" placeholder="Select Date">
												</div>											
											</div>
											<div class="col-lg-4 col-md-6 col-sm-12">
												<div class="input-block mb-3">
													<label>Reference No</label>
													<input type="text" class="form-control" placeholder="Enter Reference Number">
												</div>
											</div>
											<div class="col-lg-12">											
												<div class="input-block mb-3">
													<label>Products</label>
													<ul class="form-group-plus css-equal-heights">
														<li>
															<select class="select">
																<option>Select Product</option>
																<option>Product 1</option>
																<option>Product 2</option>
																<option>Product 3</option>
															</select>
														</li>
														<li>    
															<a class="btn btn-primary form-plus-btn" href="add-products.php"><i class="fas fa-plus-circle"></i></a>
														</li>
													</ul>												
												</div>									
											</div>
										</div>
									</div>
									<div class="form-group-item">
										<div class="card-table">
											<div class="card-body">
											    
											     <!-- Products Table -->
            <div class="table-responsive mb-3">
                <table class="table table-bordered" id="productsTable">
                    <thead>
                        <tr>
                            <th>Product / Service</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Rate</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="productRows">
                        <!-- Product rows will be added here -->
                    </tbody>
                </table>
                <button type="button" class="btn btn-secondary" id="addProduct">Add Product</button>
            </div>
            
            
												<div class="table-responsive no-pagination">
													<table class="table table-center table-hover datatable">
														<thead class="thead-light">
															<tr>
																<th>Product / Service</th>
																<th>Quantity</th>
																<th>Unit</th>
																<th>Rate</th>
																<th>Discount</th>
																<th>Tax</th>
																<th>Amount</th>
																<th class="no-sort">Action</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Nike Jordan</td>
																<td><input type="number" class="form-control" value="1"></td>
																<td>Pcs</td>
																<td><input type="number" class="form-control" value="1360.00"></td>
																<td>0</td>
																<td>0</td>
																<td>$1360.00</td>
																<td class="d-flex align-items-center">
																	<a href="#" class="btn-action-icon me-2" data-bs-toggle="modal" data-bs-target="#add_discount"><span><i class="fe fe-edit"></i></span></a>
																	<a href="#" class="btn-action-icon" data-bs-toggle="modal" data-bs-target="#delete_discount"><span><i class="fe fe-trash-2"></i></span></a>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="row">
												<div class="col-lg-7">
													<div class="input-block mb-3">
														<label>Discount Type</label>
														<select class="select">
															<option>Percentage(%)</option>
															<option>Fixed</option>
														</select>
													</div>
												</div>
												<div class="col-lg-5">
													<div class="input-block mb-3">
														<label>Discount(%)</label>
														<input type="text" class="form-control" placeholder="10">
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="input-block mb-3">
												<label>Tax</label>
												<select class="select">
													<option>No Tax</option>
													<option>IVA - (21%)</option>
													<option>IRPF - (-15%)</option>
													<option>PDV - (20%)</option>
												</select>
											</div>
										</div>
										<div class="col-md-4"></div>
									</div>
									<div class="form-group-item border-0 p-0">
										<div class="row">
											<div class="col-xl-6 col-lg-12">
												<div class="form-group-bank">
													<div class="row align-items-center">
														<div class="col-md-8">
															<div class="input-block mb-3">
																<label>Select Bank</label>
																<select class="select">
																	<option>Select Bank</option>
																	<option>SBI</option>
																	<option>IOB</option>
																	<option>Canara</option>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-groups">
																<a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#bank_details">Add Bank</a>
															</div>
														</div>
													</div>
													
													<div class="input-block mb-3 notes-form-group-info">
														<label>Notes</label>
														<textarea class="form-control" placeholder="Enter Notes"></textarea>
													</div>
													<div class="input-block mb-3 notes-form-group-info mb-0">
														<label>Terms and Conditions</label>
														<textarea class="form-control" placeholder="Enter Terms and Conditions"></textarea>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-lg-12">
												<div class="form-group-bank">
													<div class="invoice-total-box">
														<div class="invoice-total-inner">
															<p>Taxable Amount <span>$1360.00</span></p>
															<p>Discount <span>$136.00</span></p>
															<p>Vat <span>$0.00</span></p>
															<div class="status-toggle justify-content-between">
																<div class="d-flex align-center">
																	<p>Round Off </p>
																	<input id="rating_1" class="check" type="checkbox" checked="">
																	<label for="rating_1" class="checktoggle checkbox-bg">checkbox</label>
																</div>
																<span>$0.00</span>
															</div>																
														</div>
														<div class="invoice-total-footer">
															<h4>Total Amount <span>$1224.00</span></h4>
														</div>
													</div>
													<div class="input-block mb-3">
														<label>Signature Name</label>
														<input type="text" class="form-control" placeholder="Enter Signature Name">
													</div>
													<div class="input-block mb-0">
														<label>Signature Image</label>
														<div class="input-block service-upload service-upload-info mb-0">
															<span><i class="fe fe-upload-cloud me-1"></i>Upload Signature</span>
															<input type="file" multiple="" id="image_sign">
															<div id="frames"></div>
														</div>
													</div>
												</div>
											</div>
										</div>	
									</div>								
									<form action="https://kanakku.dreamstechnologies.com/html/template/purchase-orders.html" class="text-end">
										<button type="reset" class="btn btn-primary cancel me-2">Cancel</button>
										<button type="submit" class="btn btn-primary">Save</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

			<div class="modal custom-modal fade" id="add_discount" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Add Tax & Discount</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-3">
										<label>Rate</label>
										<input type="number" class="form-control" placeholder="120">
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-3">
										<label>Discount Amount</label>
										<input type="number" class="form-control" placeholder="0">
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-0">
										<label>Tax</label>
										<select class="select">
											<option>N/A</option>
											<option>5%</option>
											<option>10%</option>
											<option>15%</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn me-2">Back</a>
							<a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Save</a>
						</div>
					</div>
				</div>
			</div>

			<div class="modal custom-modal fade" id="delete_discount" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-body">
							<div class="form-header">
								<h3>Delete Product / Services</h3>
								<p>Are you sure want to delete?</p>
							</div>
							<div class="modal-btn delete-action">
								<div class="row">
									<div class="col-6">
										<a href="#" class="btn btn-primary paid-continue-btn">Delete</a>
									</div>
									<div class="col-6">
										<a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal custom-modal fade" id="bank_details" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Add Bank Details</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-3">
										<label>Bank Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" placeholder="Enter Bank Name">
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-3">
										<label>Account Number <span class="text-danger">*</span></label>
										<input type="number" class="form-control" placeholder="Enter Account Number">
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-3">
										<label>Branch Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" placeholder="Enter Branch Name">
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-0">
										<label>IFSC Code <span class="text-danger">*</span></label>
										<input type="number" class="form-control" placeholder="Enter IFSC COde">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn me-2">Back</a>
							<a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Save</a>
						</div>
					</div>
				</div>
			</div>
			
			
			
			<script>
        // Products data
        const products = <?php 
            $products = [];
            while ($product = $products_result->fetch_assoc()) {
                $products[] = $product;
            }
            echo json_encode($products);
        ?>;

        document.getElementById('addProduct').addEventListener('click', function() {

            const tbody = document.getElementById('productRows');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <select class="form-control product-select" name="items[][product_id]" required>
                        <option value="">Select Product</option>
                        ${products.map(p => `
                            <option value="${p.id}" data-rate="${p.rate}" data-unit="${p.unit}">
                                ${p.name}
                            </option>
                        `).join('')}
                    </select>
                </td>
                <td><input type="number" step="0.01" class="form-control quantity" name="items[][quantity]" required></td>
                <td><input type="text" class="form-control unit" name="items[][unit]" required></td>
                <td><input type="number" step="0.01" class="form-control rate" name="items[][rate]" required></td>
                <td><input type="number" step="0.01" class="form-control discount" name="items[][discount]" value="0"></td>
                <td><input type="number" step="0.01" class="form-control tax" name="items[][tax]" value="0"></td>
                <td><input type="number" step="0.01" class="form-control amount" name="items[][amount]" readonly></td>

                <td class="d-flex align-items-center">
																	<a href="#" class="btn-action-icon me-2" data-bs-toggle="modal" data-bs-target="#add_discount"><span><i class="fe fe-edit"></i></span></a>
																	<a href="#" class="btn-action-icon remove-row" data-bs-toggle="modal"  data-bs-target="#delete_discount"><span><i class="fe fe-trash-2"></i></span></a>
																</td>
            `;
            tbody.appendChild(row);

            // Add event listeners for calculations
            addRowEventListeners(row);
        });

        // Remove product row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
                calculateTotals();
            }
        });

        // Add event listeners to row
        function addRowEventListeners(row) {
            const productSelect = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.quantity');
            const rateInput = row.querySelector('.rate');
            const unitInput = row.querySelector('.unit');
            const discountInput = row.querySelector('.discount');
            const taxInput = row.querySelector('.tax');

            productSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                rateInput.value = selected.dataset.rate;
                unitInput.value = selected.dataset.unit;
                calculateRowAmount(row);
            });

            [quantityInput, rateInput, discountInput, taxInput].forEach(input => {
                input.addEventListener('input', () => calculateRowAmount(row));
            });
        }

        // Calculate row amount
        function calculateRowAmount(row) {
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const rate = parseFloat(row.querySelector('.rate').value) || 0;
            const discount = parseFloat(row.querySelector('.discount').value) || 0;
            const tax = parseFloat(row.querySelector('.tax').value) || 0;

            const subtotal = quantity * rate;
            const discountAmount = (discount / 100) * subtotal;
            const taxableAmount = subtotal - discountAmount;
            const taxAmount = (tax / 100) * taxableAmount;
            const total = taxableAmount + taxAmount;

            row.querySelector('.amount').value = total.toFixed(2);
            calculateTotals();
        }

        // Calculate totals
        function calculateTotals() {
            let taxableAmount = 0;
            let totalDiscount = 0;
            let totalTax = 0;
            let totalAmount = 0;

            document.querySelectorAll('#productRows tr').forEach(row => {
                const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                const rate = parseFloat(row.querySelector('.rate').value) || 0;
                const discount = parseFloat(row.querySelector('.discount').value) || 0;
                const tax = parseFloat(row.querySelector('.tax').value) || 0;

                const subtotal = quantity * rate;
                const discountAmount = (discount / 100) * subtotal;
                const rowTaxableAmount = subtotal - discountAmount;
                const taxAmount = (tax / 100) * rowTaxableAmount;

                taxableAmount += rowTaxableAmount;
                totalDiscount += discountAmount;
                totalTax += taxAmount;
                totalAmount += rowTaxableAmount + taxAmount;
            });

            // Apply additional discount
            const discountType = document.getElementById('discount_type').value;
            const discountValue = parseFloat(document.getElementById('discount_value').value) || 0;
            let additionalDiscount = 0;

            if (discountType === 'percentage') {
                additionalDiscount = (discountValue / 100) * taxableAmount;
            } else {
                additionalDiscount = discountValue;
            }

            totalDiscount += additionalDiscount;
            totalAmount -= additionalDiscount;

            // Apply round off if enabled
            if (document.getElementById('round_off').checked) {
                totalAmount = Math.round(totalAmount);
            }

            // Update summary
            document.getElementById('taxableAmount').textContent = taxableAmount.toFixed(2);
            document.getElementById('totalDiscount').textContent = totalDiscount.toFixed(2);
            document.getElementById('totalTax').textContent = totalTax.toFixed(2);
            document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);

            // Update hidden inputs
            document.getElementById('taxableAmountInput').value = taxableAmount.toFixed(2);
            document.getElementById('totalDiscountInput').value = totalDiscount.toFixed(2);
            document.getElementById('totalTaxInput').value = totalTax.toFixed(2);
            document.getElementById('totalAmountInput').value = totalAmount.toFixed(2);
        }

        // Add event listeners for discount type and value
        document.getElementById('discount_type').addEventListener('change', calculateTotals);
        document.getElementById('discount_value').addEventListener('input', calculateTotals);
        document.getElementById('round_off').addEventListener('change', calculateTotals);
    </script>
	
	
	
<?php include('./footer.php'); ?>