<?php include('./header.php');

$inv_sql = mysqli_query($con, "select * from camp_inventory");
$inv_count = mysqli_num_rows($inv_sql);

$vendor_sql = mysqli_query($con, "select * from camp_vendors");
$vendor_count = mysqli_num_rows($vendor_sql);

$purchase_order_sql = mysqli_query($con, "select * from camp_purchase_orders");
$purchase_order_count = mysqli_num_rows($purchase_order_sql);


?>

<div class="content container-fluid">
	<div class="row">
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-1">
							<i class="fas fa-dollar-sign"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">Total Quantity</div>
							<div class="dash-counts">
								<p><?php echo $inv_count; ?></p>
							</div>
						</div>
					</div>
					<div class="progress progress-sm mt-3">
						<div class="progress-bar bg-5" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-2">
							<i class="fas fa-users"></i>
						</span>
						<div class="dash-count">
							<div class="dash-titledash-title">Vendors</div>
							<div class="dash-counts">
								<p><?php echo $vendor_count; ?></p>
							</div>
						</div>
					</div>
					<div class="progress progress-sm mt-3">
						<div class="progress-bar bg-6" role="progressbar" style="width: 65%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
					</div>

				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-3">
							<i class="fas fa-file-alt"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">Purchase Orders</div>
							<div class="dash-counts">
								<p><?php echo $purchase_order_count; ?></p>
							</div>
						</div>
					</div>
					<div class="progress progress-sm mt-3">
						<div class="progress-bar bg-7" role="progressbar" style="width: 85%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
					</div>

				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card">
				<div class="card-body">
					<div class="dash-widget-header">
						<span class="dash-widget-icon bg-4">
							<i class="far fa-file"></i>
						</span>
						<div class="dash-count">
							<div class="dash-title">Estimates</div>
							<div class="dash-counts">
								<p>2,150</p>
							</div>
						</div>
					</div>
					<div class="progress progress-sm mt-3">
						<div class="progress-bar bg-8" role="progressbar" style="width: 45%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
					</div>

				</div>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-md-6 col-sm-6">
			<div class="card mb-0">
				<div class="card-header">
					<div class="row align-center">
						<div class="col">
							<h5 class="card-title">Recent PO's</h5>
						</div>
						<div class="col-auto">
							<a href="./purchase-orders.php" class="btn-right btn btn-sm btn-outline-primary">
								View All
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="mb-3">
						<div class="progress progress-md rounded-pill mb-3">
							<div class="progress-bar bg-success" role="progressbar" style="width: 47%" aria-valuenow="47" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar bg-warning" role="progressbar" style="width: 28%" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<div class="row">
							<div class="col-auto">
								<i class="fas fa-circle text-success me-1"></i> Paid
							</div>
							<div class="col-auto">
								<i class="fas fa-circle text-warning me-1"></i> Unpaid
							</div>
							<div class="col-auto">
								<i class="fas fa-circle text-danger me-1"></i> Overdue
							</div>
							<div class="col-auto">
								<i class="fas fa-circle text-info me-1"></i> Draft
							</div>
						</div>
					</div>

					<div class="table-responsive">

						<table class="table table-stripped table-hover">
							<thead class="thead-light">
								<tr>
									<th>Customer</th>
									<th>Amount</th>
									<th>Due Date</th>
									<th>Status</th>
									<th class="text-end">Action</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$purchase_order_sql = mysqli_query($con, "SELECT * FROM camp_purchase_orders");
								while ($purchase_order_row = mysqli_fetch_array($purchase_order_sql)) {
									$po_number = $purchase_order_row['po_number'];
									$order_date = $purchase_order_row['order_date'];
									$expected_delivery_date = $purchase_order_row['expected_delivery_date'];
									$total_amount = $purchase_order_row['total_amount'];
									$vendor = $purchase_order_row['vendor'];
									$status = $purchase_order_row['status'];
								?>

									<tr>
										<td>
											<h2 class="table-avatar">
												<?php echo $vendor ; ?>
											</h2>
										</td>
										<td><?php echo $total_amount ;  ?></td>
										<td><?php echo $order_date ; ?></td>
										<td><span class="badge bg-success-light"><?php echo $status; ?></span></td>
										<td class="text-end">
											<div class="dropdown dropdown-action">
												<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" href="./edit-purchase-orders.php?purchase-order=<?php echo $po_number ; ?>"><i class="far fa-edit me-2"></i>Edit</a>
													<a class="dropdown-item" href="invoice-details.html"><i class="far fa-eye me-2"></i>View</a>
													<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
													<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
													<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Invoice</a>
													<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-copy me-2"></i>Clone Invoice</a>
												</div>
											</div>
										</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6">
			<div class="card mb-0">
				<div class="card-header">
					<div class="row align-center">
						<div class="col">
							<h5 class="card-title">Products</h5>
						</div>
						<div class="col-auto">
							<a href="./inventory.php" class="btn-right btn btn-sm btn-outline-primary">
								View All
							</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					
					<div class="table-responsive">
						<table class="table table-hover">
							<thead class="thead-light">
								<tr>
									<th>Product</th>
									<th>Model</th>
									<th>Working / Not Working</th>
									<th>Count</th>
									<th class="text-end">Action</th>
								</tr>
							</thead>
							<tbody>

							<?php
							$inv_sql = mysqli_query($con,"SELECT product_name,product_model,working_status, count(1) FROM `camp_inventory` group by product_name,product_model,working_status");
							while($inv_sql_rows = mysqli_fetch_array($inv_sql)){
								$product_name = $inv_sql_rows['product_name'];
								$product_model = $inv_sql_rows['product_model'];
								$working_status = $inv_sql_rows['working_status'];
								$count = $inv_sql_rows['count(1)'];

								?>
								<tr>
									<td>
										<h2 class="table-avatar">
                                            <?php echo $product_name ; ?>
										</h2>
									</td>
									<td><?php echo $product_model; ?></td>
									<td><?php echo $working_status ; ?></td>
									<td><?php echo $count ; ?></td>
									
									<td class="text-end">
										<div class="dropdown dropdown-action">
											<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
												<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-trash-alt me-2"></i>Delete</a>
												<a class="dropdown-item" href="invoice-details.html"><i class="far fa-eye me-2"></i>View</a>
												<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-file-alt me-2"></i>Convert to Invoice</a>
												<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as sent</a>
												<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-paper-plane me-2"></i>Send Estimate</a>
												<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-check-circle me-2"></i>Mark as Accepted</a>
												<a class="dropdown-item" href="javascript:void(0);"><i class="far fa-times-circle me-2"></i>Mark as Rejected</a>
											</div>
										</div>
									</td>
								</tr>
<?php
							}
							?>


							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include('./footer.php'); ?>