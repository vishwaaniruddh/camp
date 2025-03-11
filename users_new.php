<?php include('./header.php');  ?>

<div class="content container-fluid">

	<!-- Page Header -->
	<div class="page-header">
		<div class="content-page-header ">
			<h5>user </h5>
			<div class="list-btn">
				<ul class="filter-list">
				
					
					<li>
						<a class="btn btn-primary" href="./user_ui.php"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add user</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Page Header -->



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
									<th>user Name</th>
									<th>Status</th>
									<th class="no-sort">Action</th>
								</tr>
							</thead>
							<tbody id="userTableBody">

							</tbody>
						</table>
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
					<h3>Delete user</h3>
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

<script src="./assets/js/helper/users_new.js"></script>
<?php include('./footer.php'); ?>