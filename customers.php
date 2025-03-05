<?php include('./header.php');  ?>

<div class="content container-fluid">

	<!-- Page Header -->
	<div class="page-header">
		<div class="content-page-header ">
			<h5>Customer </h5>
			<div class="list-btn">
				<ul class="filter-list">
					
					<li class="">
						<div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Download">
							<a href="#" class="btn-filters" data-bs-toggle="dropdown" aria-expanded="false"><span><i class="fe fe-download"></i></span></a>
							
						</div>
					</li>
					
					<li>
						<a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_customer"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Customer</a>
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


	<!-- Table -->
	<div class="row">
		<div class="col-sm-12">
			<div class=" card-table">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-center table-hover">
							<thead class="thead-light">
								<tr>
									<th>#</th>
									<th>Customer Name</th>
									<th>Status</th>
									<th class="no-sort">Action</th>
								</tr>
							</thead>
							<tbody id="customerTableBody">

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Table -->

</div>


<div class="modal custom-modal fade" id="add_customer" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header border-0 pb-0">
				<div class="form-header modal-header-title text-start mb-0">
					<h4 class="mb-0">Add customer</h4>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="addcustomerForm">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="card-body">
								<div class="form-group-item border-0 pb-0 mb-0">
									<div class="row">
										<div class="col-lg-12 col-sm-12">
											<div class="input-block mb-3">
												<label>Name <span class="text-danger">*</span></label>
												<input type="text" name="name" class="form-control" placeholder="Enter Name" required>
											</div>
										</div>
									
									
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
					<button type="submit" class="btn btn-primary paid-continue-btn">Add customer</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Add customer Modal -->

<!-- Edit customer Modal -->
<div class="modal custom-modal fade" id="edit_customer" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header border-0 pb-0">
				<div class="form-header modal-header-title text-start mb-0">
					<h4 class="mb-0">Edit customer</h4>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="editcustomerForm">
				<input type="hidden" name="customer_id">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="card-body">
								<div class="form-group-item border-0 pb-0 mb-0">
									<div class="row">
										<div class="col-lg-12 col-sm-12">
											<div class="input-block mb-3">
												<label>Name <span class="text-danger">*</span></label>
												<input type="text" name="name" class="form-control" placeholder="Enter Name" required>
											</div>
										</div>
										

										<div class="col-lg-12 col-sm-12">
											<div class="input-block mb-3">
												<label>customer Status</label>
												<select class="form-select" name="customer_status" id="customer_status">
													<option value="active">Active</option>
													<option value="deleted">Deleted</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn me-2">Cancel</button>
					<button type="submit" class="btn btn-primary paid-continue-btn">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Edit customer Modal -->

<!-- Delete Items Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3>Delete customer</h3>
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
<!-- /Delete Items Modal -->

<script src="./assets/js/helper/customer.js"></script>
<?php include('./footer.php'); ?>