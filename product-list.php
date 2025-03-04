<?php include('./header.php');  ?>

<div class="content container-fluid">

	<!-- Page Header -->
	<div class="page-header">
		<div class="content-page-header ">
			<h5>Products / Services</h5>
			<div class="list-btn">
				<ul class="filter-list">
					<li>
						<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Filter"><span class="me-2"><img src="assets/img/icons/filter-icon.svg" alt="filter"></span>Filter </a>
					</li>
					<li class="">
						<div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Download">
							<a href="#" class="btn-filters" data-bs-toggle="dropdown" aria-expanded="false"><span><i class="fe fe-download"></i></span></a>
							<div class="dropdown-menu dropdown-menu-right">
								<ul class="d-block">
									<li>
										<a class="d-flex align-items-center download-item" href="javascript:void(0);" download><i class="far fa-file-pdf me-2"></i>PDF</a>
									</li>
									<li>
										<a class="d-flex align-items-center download-item" href="javascript:void(0);" download><i class="far fa-file-text me-2"></i>CVS</a>
									</li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<a class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Print"><span><i class="fe fe-printer"></i></span> </a>
					</li>
					<li>
						<a class="btn btn-primary" href="add-products.php"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Product</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Page Header -->

	<!-- Search Filter -->
	<div id="filter_inputs" class="card filter-card">
		<div class="card-body pb-0">
			<div class="row">
				<div class="col-sm-6 col-md-3">
					<div class="input-block mb-3">
						<label>Name</label>
						<input type="text" class="form-control">
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="input-block mb-3">
						<label>Email</label>
						<input type="text" class="form-control">
					</div>
				</div>
				<div class="col-sm-6 col-md-3">
					<div class="input-block mb-3">
						<label>Phone</label>
						<input type="text" class="form-control">
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Search Filter -->

	<!-- All Invoice -->
	<div class="card invoices-tabs-card">
		<div class="invoices-main-tabs">
			<div class="row align-items-center">
				<div class="col-lg-12">
					<div class="invoices-tabs">
						<ul>
							<li><a href="product-list.php" class="active">Product</a></li>
							<li><a href="category.php">Category</a></li>
							<li><a href="units.php">Units</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /All Invoice -->

	<!-- Table -->
	<div class="row">
		<div class="col-sm-12">
			<div class=" card-table">
				<div class="card-body">
					<div class="table-responsive">
						<div class="companies-table">
							<table class="table table-center table-hover">
								<thead class="thead-light">
									<tr>
										<th>#</th>
										<th>Item</th>
										<th>Category</th>
										<th>Units</th>
										<th>Purchase Price</th>

										<th>Required Serial Number</th>
										<th>Alert Quantity</th>
										
										<th class="no-sort">Action</th>
									</tr>
								</thead>
								<tbody id="productTableBody">
									<!-- Products will be populated here by JavaScript -->
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Table -->

</div>


<!-- Delete Items Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3>Delete Products / Services</h3>
					<p>Are you sure want to delete?</p>
				</div>
				<div class="modal-btn delete-action">
					<div class="row">
						<div class="col-6">
							<button type="reset" data-bs-dismiss="modal" class="w-100 btn btn-primary paid-continue-btn">Delete</button>
						</div>
						<div class="col-6">
							<button type="submit" data-bs-dismiss="modal" class="w-100 btn btn-primary paid-cancel-btn">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="./assets/js/helper/product-list.js"></script>


<?php include('./footer.php'); ?>