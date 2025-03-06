<?php include('./header.php'); ?>
<div class="content container-fluid">

	<!-- Page Header -->
	<div class="page-header">
		<div class="content-page-header">
			<h5>Customer Purchase Orders</h5>
			<div class="list-btn">
				<ul class="filter-list">

					<li>
						<a class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Settings"><span><i class="fe fe-settings"></i></span> </a>
					</li>
					<li>
						<a class="btn btn-primary" href="add-customer-purchase-order.php"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Customer Purchases Order</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Page Header -->

	<!-- Table -->
	<div class="row">
		<div class="col-sm-12">
			<div class="card-table">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-stripped table-hover">
							<thead class="thead-light">
								<tr>
									<th>#</th>
									<th>Purchase ID</th>
									<th>Customer</th>
									<th>Bank</th>
									<th>Order Date</th>
									<th>Created Date</th>
                                    <th>Current Status</th>
									<th class="no-sort">Action</th>
								</tr>
							</thead>
							<tbody id="customerPurchaseOrderTableBody"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Table -->

</div>

<!-- /Page Wrapper -->

<script src="./assets/js/helper/customer-purchase-order.js"></script>


<?php include('./footer.php'); ?>