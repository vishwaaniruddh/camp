<?php include('./header.php');  ?>

<div class="content container-fluid">

	<!-- Page Header -->
	<div class="page-header">
		<div class="content-page-header ">
			<h5>couriers </h5>
			<div class="list-btn">
				<ul class="filter-list">

					<li>
						<a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_courier"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add courier</a>
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
			<div class="card-table">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-center table-hover">
							<thead class="thead-light">
								<tr>
									<th>#</th>
									<th>Courier Name</th>
									<th>Short Name</th>
									<th>Status</th>
									<th class="no-sort">Action</th>
								</tr>
							</thead>
							<tbody id="courierTableBody">

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Table -->

</div>

<div class="modal custom-modal fade" id="add_courier" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header border-0 pb-0">
				<div class="form-header modal-header-title text-start mb-0">
					<h4 class="mb-0">Add courier</h4>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="addcourierForm" action="#">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>courier Name*</label>
								<input type="text" name="couriername" class="form-control string_valid required_valid" placeholder="Enter courier Name">
							</div>
						</div>
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>Slug*</label>
								<input type="text" name="slug" class="form-control string_valid required_valid" placeholder="Enter Slug">
							</div>
						</div>

						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>Status</label>
								<select class="form-select" name="status">
									<option value="active">Active</option>
									<option value="deleted">Deleted</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
					<button type="submit" class="btn btn-primary paid-continue-btn">Add courier</button>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- filepath: /c:/xampp/htdocs/camp/couriers.php -->
<!-- Edit courier Modal -->
<div class="modal custom-modal fade" id="edit_courier" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header border-0 pb-0">
				<div class="form-header modal-header-title text-start mb-0">
					<h4 class="mb-0">Edit courier</h4>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="editcourierForm" action="#">
				<input type="hidden" name="courier_id">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>courier Name*</label>
								<input type="text" name="couriername" class="form-control string_valid required_valid" placeholder="Enter courier Name">
							</div>
						</div>
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>Slug*</label>
								<input type="text" name="slug" class="form-control string_valid required_valid" placeholder="Enter Slug">
							</div>
						</div>
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>Status</label>
								<select class="form-select" name="status">
									<option value="active">Active</option>
									<option value="deleted">Deleted</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
					<button type="submit" id="update_courier_modal" class class="btn btn-primary paid-continue-btn">Update courier</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Edit courier Modal -->

<!-- Delete Items Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3>Delete couriers</h3>
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

<!-- /Main Wrapper -->

<!--Theme Setting -->



<script src="./assets/js/helper/couriers.js"></script>

<?php include('./footer.php'); ?>