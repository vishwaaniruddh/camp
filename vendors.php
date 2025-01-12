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
											<a href="#" class="btn-filters" data-bs-toggle="dropdown" aria-expanded="false"><span><i class="fe fe-download"></i></span></a>
											<div class="dropdown-menu dropdown-menu-end">
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
										<a class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" title="print"><span><i class="fe fe-printer"></i></span> </a>
									</li>
									<li>
										<a class="btn btn-import" href="javascript:void(0);"><span><i class="fe fe-check-square me-2"></i>Import</span></a>
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
					
						<!-- Alert -->
						<div class="col-md-4">	
							<div class="card">
								<div class="card-header">
									<div class="card-title">Alert</div>
								</div>
								<div class="card-body">
									 <a href="javascript: void(0);" id="alert" class="btn btn-primary waves-effect waves-light">Click me</a>
								</div>
							</div>
						</div>
						<!-- /Alert -->
						
						<!-- Alert -->
						<div class="col-md-4">	
							<div class="card">
								<div class="card-header">
									<div class="card-title">Confirm</div>
								</div>
								<div class="card-body">
									  <a href="javascript: void(0);" id="alert-confirm" class="btn btn-primary waves-effect waves-light">Click me</a>
								</div>
							</div>
						</div>
						<!-- /Alert -->
						
						<!-- Alert -->
						<div class="col-md-4">	
							<div class="card">
								<div class="card-header">
									<div class="card-title">Prompt</div>
								</div>
								<div class="card-body">
									 <a href="javascript: void(0);" id="alert-prompt" class="btn btn-primary waves-effect waves-light">Click me</a>
								</div>
							</div>
						</div>
						<!-- /Alert -->
						
						<!-- Alert -->
						<div class="col-md-4">	
							<div class="card">
								<div class="card-header">
									<div class="card-title">Success Alert</div>
								</div>
								<div class="card-body">
									 <a href="javascript: void(0);" id="alert-success" class="btn btn-primary btn-sm waves-effect waves-light">Click me</a>
								</div>
							</div>
						</div>
						<!-- /Alert -->
						
						<!-- Alert -->
						<div class="col-md-4">	
							<div class="card">
								<div class="card-header">
									<div class="card-title">Error Alert</div>
								</div>
								<div class="card-body">
									 <a href="javascript: void(0);" id="alert-error" class="btn btn-primary btn-sm waves-effect waves-light">Click me</a>
								</div>
							</div>
						</div>
						<!-- /Alert -->
						
						<!-- Alert -->
						<div class="col-md-4">	
							<div class="card">
								<div class="card-header">
									<div class="card-title">Warnng Alert</div>
								</div>
								<div class="card-body">
									 <a href="javascript: void(0);" id="alert-warning" class="btn btn-primary btn-sm waves-effect waves-light">Click me</a>
								</div>
							</div>
						</div>
						<!-- /Alert -->
						
					</div>
					



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
					
					<div class="row">
						<div class="col-sm-12">
							<div class=" card-table">
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-center table-hover datatable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Created</th>
                                                    <th class="no-sort">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="vendorTableBody">
                                                <!-- Rows will be added dynamically -->
                                            </tbody>
                                        </table>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>


			<!-- Add Asset -->
			<div class="toggle-sidebar">
				<div class="sidebar-layout-filter">
					<div class="sidebar-header">
						<h5>Filter</h5>
						<a href="#" class="sidebar-closes"><i class="fa-regular fa-circle-xmark"></i></a>
					</div>
					<div class="sidebar-body">						
						<form action="#" autocomplete="off">
							<!-- Customer -->
							<div class="accordion accordion-last" id="accordionMain1">
								<div class="card-header-new" id="headingOne">
									<h6 class="filter-title">
									<a href="javascript:void(0);" class="w-100" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										Vendors	
										<span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
									</a> 
									</h6>
								</div>
							
								<div id="collapseOne" class="collapse show" aria-labelledby="headingOne"  data-bs-parent="#accordionExample1">
									<div class="card-body-chat">
										<div class="row">
											<div class="col-md-12">
												<div id="checkBoxes1">
													<div class="form-custom">														
														<input type="text" class="form-control" id="member_search1" placeholder="Search Customer">
														<span><img src="assets/img/icons/search.svg" alt="img"></span>
													</div>
													<div class="selectBox-cont">
														<label class="custom_check w-100">
															<input type="checkbox" name="username">
															<span class="checkmark"></span>  John Smith
														</label>
														<label class="custom_check w-100">
															<input type="checkbox" name="username">
															<span class="checkmark"></span>  Johnny Charles
														</label>
														<label class="custom_check w-100">
															<input type="checkbox" name="username">
															<span class="checkmark"></span>  Robert George
														</label>
														<label class="custom_check w-100">
															<input type="checkbox" name="username">
															<span class="checkmark"></span> Sharonda Letha
														</label>
														<!-- View All -->
														<div class="view-content">
															<div class="viewall-One">	
																<label class="custom_check w-100">
																	<input type="checkbox" name="username">
																	<span class="checkmark"></span> Pricilla Maureen
																</label>
																<label class="custom_check w-100">
																	<input type="checkbox" name="username">
																	<span class="checkmark"></span> Randall Hollis
																</label>
															</div>
															<div class="view-all">
																<a href="javascript:void(0);" class="viewall-button-One"><span class="me-2">View All</span><span><i class="fa fa-circle-chevron-down"></i></span></a>
															</div>
														</div>
														<!-- /View All -->
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Customer -->

							<div class="filter-buttons">
								<button type="submit" class="d-inline-flex align-items-center justify-content-center btn w-100 btn-primary">
									Apply
								</button>
								<button type="submit" class="d-inline-flex align-items-center justify-content-center btn w-100 btn-secondary">
									Reset
								</button>
							</div>
						</form>
						
					</div>
				</div>
			</div>	
			<!--/Add Asset -->


			<!-- Edit Vendor Modal -->
			<div class="modal custom-modal fade" id="edit_vendor" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Edit Vendor</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<form action="#">
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="input-block mb-3">
											<label>Name</label>
											<input type="text" name="vendor_name" class="form-control" placeholder="Enter Name">
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="input-block mb-3">
											<label>Email</label>
											<input type="text" name="vendor_email" class="form-control" placeholder="Select Date">
										</div>
									</div>
									<div class="col-lg-12 col-md-12">
										<div class="input-block mb-3">
											<label>Phone Number</label>
											<input type="text" class="form-control" name="vendor_phoneno" placeholder="Enter Reference Number">
										</div>
									</div>
									<div class="col-lg-12 col-sm-12">
                                        <div class="input-block mb-0">
                                            <label>Address</label>
                                            <input type="text" name="vendor_address" class="form-control" placeholder="Enter Address...">
                                        </div>
                                    </div>
									
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn me-2">Cancel</button>
								<button type="submit" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Update</button>
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
                            <div class="input-block mb-0">
                                <label>Address</label>
                                <input type="text" name="vendor_address" class="form-control" placeholder="Enter Address...">
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

<?php include('./footer.php'); ?>