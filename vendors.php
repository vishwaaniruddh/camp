<?php include('./header.php');  ?>

<div class="content container-fluid">

	<!-- Page Header -->
	<div class="page-header">
		<div class="content-page-header ">
			<h5>Vendors</h5>
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
						<a class="btn btn-import" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#import_vendor"><i class="fe fe-check-square me-2" aria-hidden="true"></i>Import</a>
					</li>
					<li>
						<a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_vendor"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Vendors</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Page Header -->







	<div class="row">
		<div class="col-sm-12">
			<div class=" card-table">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-center table-hover">
							<thead class="thead-light">
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Phone</th>
									<th>Status</th>
									<th>Created</th>
									<th class="no-sort">Actions</th>
								</tr>
							</thead>
							<tbody id="vendorTableBody">
								<!-- Rows will be added dynamically -->
							</tbody>
						</table>

						<div id="pagination" class="pagination-container"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Search Filter -->

<!-- Search Filter -->
<?php
$names = $conn->query("SELECT DISTINCT name FROM camp_vendors")->fetch_all(MYSQLI_ASSOC);
$phones = $conn->query("SELECT DISTINCT phone FROM camp_vendors")->fetch_all(MYSQLI_ASSOC);
$emails = $conn->query("SELECT DISTINCT email FROM camp_vendors")->fetch_all(MYSQLI_ASSOC);
$gstins = $conn->query("SELECT DISTINCT gstin FROM camp_vendors")->fetch_all(MYSQLI_ASSOC);
$statuses = $conn->query("SELECT DISTINCT status FROM camp_vendors")->fetch_all(MYSQLI_ASSOC);
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
                    <input type="text" class="form-control" id="filterPhone" list="phoneList" placeholder="Filter by Phone Number">
					<span><img src="assets/img/icons/search.svg" alt="img"></span>
					<datalist id="phoneList">
                        <?php foreach ($phones as $phone): ?>
                            <option value="<?php echo htmlspecialchars($phone['phone']); ?>">
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-custom mb-3">
                    <input type="text" class="form-control" id="filterEmail" list="emailList" placeholder="Filter by Email">
					<span><img src="assets/img/icons/search.svg" alt="img"></span>
					<datalist id="emailList">
                        <?php foreach ($emails as $email): ?>
                            <option value="<?php echo htmlspecialchars($email['email']); ?>">
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-custom mb-3">
                    <input type="text" class="form-control" id="filterGstin" list="gstinList" placeholder="Filter by GSTIN">
                    <span><img src="assets/img/icons/search.svg" alt="img"></span>
					<datalist id="gstinList">
                        <?php foreach ($gstins as $gstin): ?>
                            <option value="<?php echo htmlspecialchars($gstin['gstin']); ?>">
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
<!-- /Search Filter -->





<!-- Edit Vendor Modal -->
<div class="modal custom-modal fade" id="edit_vendor_modal" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header border-0 pb-0">
				<div class="form-header modal-header-title text-start mb-0">
					<h4 class="mb-0">Edit Vendor</h4>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

				</button>
			</div>
			<form id="edit_vendor">
				<input type="hidden" name="vendor_id" value="">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="input-block mb-3">
								<label>Name</label>
								<input type="text" name="vendor_name" class="form-control string_valid required_valid" placeholder="Enter Name">
							</div>
						</div>
						<div class="col-lg-12 col-md-12">
							<div class="input-block mb-3">
								<label>Email</label>
								<input type="text" name="vendor_email" class="form-control email_valid required_valid" placeholder="Select Date">
							</div>
						</div>
						<div class="col-lg-12 col-md-12">
							<div class="input-block mb-3">
								<label>Phone Number</label>
								<input type="text" class="form-control phone_valid required_valid" name="vendor_phoneno" placeholder="Enter Reference Number">
							</div>
						</div>
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>Address</label>
								<input type="text" name="vendor_address" class="form-control" placeholder="Enter Address...">
							</div>
						</div>

						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>Vendor Status</label>
								<select class="form-select" name="vendor_status" id="vendor_status">
									<option value="active">Active</option>
									<option value="deleted">Deleted</option>
								</select>
							</div>
						</div>

						
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-0">
								<label>GSTIN</label>
								<input type="text" name="vendor_gstin" class="form-control" placeholder="GSTIN...">
							</div>
						</div>


					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn me-2">Cancel</button>
					<button type="submit" id="update_vendor_modal" class="btn btn-primary paid-continue-btn">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Edit Vendor Modal -->

<!-- Delete Items Modal -->
<div class="modal custom-modal fade" id="delete_modal" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-header">
					<h3>Delete Vendor</h3>
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


<!-- Add Ledger Modal -->
<div class="modal custom-modal fade" id="add_ledger" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header border-0 pb-0">
				<div class="form-header modal-header-title text-start mb-0">
					<h4 class="mb-0">Add Ledger</h4>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

				</button>
			</div>
			<form action="#">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="input-block mb-3">
								<label>Amount</label>
								<input type="text" class="form-control" placeholder="Enter Amount">
							</div>
						</div>
						<div class="col-lg-12 col-md-12">
							<div class="input-block mb-3">
								<label>Date</label>
								<div class="cal-icon cal-icon-info">
									<input type="text" class="datetimepicker form-control" placeholder="Select Date">
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12">
							<div class="input-block mb-3">
								<label>Reference</label>
								<input type="text" class="form-control" placeholder="Enter Reference Number">
							</div>
						</div>
						<div class="col-lg-12 col-md-12">
							<div class="input-block d-inline-flex align-center mb-0">
								<label class="me-5 mb-0">Mode</label>
								<div>
									<label class="custom_radio me-3 mb-0">
										<input type="radio" name="payment" checked>
										<span class="checkmark"></span> Credit
									</label>
									<label class="custom_radio mb-0">
										<input type="radio" name="payment">
										<span class="checkmark"></span> Debit
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
					<button type="submit" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Add Ledger Modal -->



<!-- Add Vendor Modal -->
<div class="modal custom-modal fade" id="add_vendor" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header border-0 pb-0">
				<div class="form-header modal-header-title text-start mb-0">
					<h4 class="mb-0">Add Vendor</h4>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="addVendorForm" action="#">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>Name*</label>
								<input type="text" name="vendor_name" class="form-control string_valid required_valid" placeholder="Enter Name">
							</div>
						</div>
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>Email*</label>
								<input type="text" name="vendor_email" class="form-control email_valid required_valid" placeholder="Enter Email Address">
							</div>
						</div>
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>Phone Number*</label>
								<input type="number" name="vendor_phoneno" class="form-control phone_valid required_valid" placeholder="Enter Phone Number">
							</div>
						</div>
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-3">
								<label>Address</label>
								<input type="text" name="vendor_address" class="form-control" placeholder="Enter Address...">
							</div>
						</div>
						<div class="col-lg-12 col-sm-12">
							<div class="input-block mb-0">
								<label>GSTIN</label>
								<input type="text" name="vendor_gstin" class="form-control" placeholder="Enter GSTIN...">
							</div>
						</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
					<button type="submit" class="btn btn-primary paid-continue-btn">Add Vendor</button>
				</div>
			</form>
		</div>
	</div>
</div>



<!-- Import Vendor -->
<!-- Add Vendor Modal -->
<div class="modal custom-modal fade" id="import_vendor" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md">
		<div class="modal-content">
			<div class="modal-header border-0 pb-0">
				<div class="form-header modal-header-title text-start mb-0">
					<h4 class="mb-0">Add Vendor</h4>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="importVendorForm" action="#">
				<div class="modal-body">
					<div class="custom-file-container" data-upload-id="myFirstImage">
						<label>Upload (Single File) <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear data">x</a></label>
						<label class="custom-file-container__custom-file">
							<input name="importVendor" type="file" class="custom-file-container__custom-file__custom-file-input" accept=".xlsx, .xls">
							<input type="hidden" name="MAX_FILE_SIZE" value="10485760">
							<span class="custom-file-container__custom-file__custom-file-control"></span>
						</label>
						<div class="custom-file-container__image-preview"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
					<button type="submit" class="btn btn-primary paid-continue-btn">Add Vendor</button>
				</div>
			</form>
		</div>
	</div>
</div>





<script>

</script>

<style>
	.error {
		border: 2px solid red !important
	}

	.error:focus {
		outline: none;
		box-shadow: 0 0 5px red;
	}
</style>


<script src="./assets/js/helper/vendor.js"></script>

<?php include('./footer.php'); ?>