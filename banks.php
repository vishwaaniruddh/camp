<?php include('./header.php');  ?>

<div class="content container-fluid">

	<!-- Page Header -->
	<div class="page-header">
		<div class="content-page-header ">
			<h5>Bank </h5>
			<div class="list-btn">
				<ul class="filter-list">
				
				<li>
						<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="filter"><span class="me-2"><img src="assets/img/icons/filter-icon.svg" alt="filter"></span>Filter </a>
					</li>


				<li class="">
						<div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="top" title="download">
							<a href="javascript:void(0);" id="downloadCSV" class="btn-filters download-item"><span><i class="fe fe-download"></i></span></a>

						</div>
					</li>	
					<li>
						<a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_bank"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Bank</a>
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
									<th>Bank Name</th>
									<th>Status</th>
									<th class="no-sort">Action</th>
								</tr>
							</thead>
							<tbody id="bankTableBody">

							</tbody>
						</table>

						<div id="pagination" class="pagination-container"></div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Table -->

</div>


<div class="modal custom-modal fade" id="add_bank" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header border-0 pb-0">
				<div class="form-header modal-header-title text-start mb-0">
					<h4 class="mb-0">Add Bank</h4>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="addbankForm">
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
					<button type="submit" class="btn btn-primary paid-continue-btn">Add Bank</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Add bank Modal -->

<!-- Edit bank Modal -->
<div class="modal custom-modal fade" id="edit_bank" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header border-0 pb-0">
				<div class="form-header modal-header-title text-start mb-0">
					<h4 class="mb-0">Edit bank</h4>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="editbankForm">
				<input type="hidden" name="bank_id">
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
												<label>bank Status</label>
												<select class="form-select" name="bank_status" id="bank_status">
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
<!-- /Edit bank Modal -->

<!-- Delete Items Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3>Delete bank</h3>
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

<?php
$names = $conn->query("SELECT DISTINCT name FROM camp_banks")->fetch_all(MYSQLI_ASSOC);
$statuses = $conn->query("SELECT DISTINCT status FROM camp_banks")->fetch_all(MYSQLI_ASSOC);
?>


<div class="toggle-sidebar">
    <div class="sidebar-layout-filter">
        <div class="sidebar-header">
            <h5>Filter</h5>
            <a href="#" class="sidebar-closes"><i class="fa-regular fa-circle-xmark"></i></a>
        </div>
        <div class="sidebar-body">
            <div class="filters">
                <div class="form-custom mb-3">
                    <input type="text" class="form-control" id="filterName" list="nameList" placeholder="Filter by Name">
                    <span><img src="assets/img/icons/search.svg" alt="img"></span>
					<datalist id="nameList">
                        <?php foreach ($names as $name): ?>
                            <option value="<?php echo htmlspecialchars($name['name']); ?>">
                        <?php endforeach; ?>
                    </datalist>
                </div>

             

                <div class="form-custom mb-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">Filter by Status</option>
                        <?php foreach ($statuses as $status): ?>
                            <option value="<?php echo htmlspecialchars($status['status']); ?>"><?php echo ucwords(htmlspecialchars($status['status'])); ?></option>
                        <?php endforeach; ?>
                    </select>
			    </div>

                <button id="applyFilters" class="btn btn-primary">Apply Filters</button>
            </div>
        </div>
    </div>
</div>
<script src="./assets/js/helper/bank.js"></script>
<?php include('./footer.php'); ?>