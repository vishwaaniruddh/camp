<?php include('./header.php'); ?>

<div class="content container-fluid">

	<!-- Page Header -->
	<div class="page-header">
		<div class="content-page-header ">
			<h5>Stock Overview</h5>
			<div class="list-btn">
				<ul class="filter-list">
					<li>
						<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip"
							data-bs-placement="bottom" data-bs-original-title="filter"><span class="me-2"><img
									src="assets/img/icons/filter-icon.svg" alt="filter"></span>Filter </a>
					</li>

					<li class="">
						<div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="top"
							data-bs-original-title="download">
							<a href="#" class="btn-filters" data-bs-toggle="dropdown" aria-expanded="false"><span><i
										class="fe fe-download"></i></span></a>

						</div>
					</li>
					<li>
						<a class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip"
							data-bs-placement="bottom" data-bs-original-title="print"><span><i
									class="fe fe-printer"></i></span> </a>
					</li>
					<li>
						<a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal"
							data-bs-target="#add_inventory"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add
							New</a>
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
									<th>Item</th>
									<th>Model</th>
									<th>Serial Number</th>
									<th>Purchase Price</th>
									<th>Working Status</th>
									<th>Entry Date</th>
									<th>Availibility</th>
									<th class="no-sort">Action</th>
								</tr>
							</thead>
							<tbody id="productInventory">

							</tbody>
						</table>



					</div>

					<div id="pagination" class="pagination-container"></div>

				</div>
			</div>
		</div>
	</div>
	<!-- /Table -->

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
				<!-- Product -->
				<div class="accordion" id="accordionMain1">
					<div class="card-header-new" id="headingOne">
						<h6 class="filter-title">
							<a href="javascript:void(0);" class="w-100" data-bs-toggle="collapse"
								data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								Product Name
								<span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
							</a>
						</h6>
					</div>

					<div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
						data-bs-parent="#accordionExample1">
						<div class="card-body-chat">
							<div class="row">
								<div class="col-md-12">

									<select class="js-example-basic-single select2">
										<option selected="selected">orange</option>
										<option>white</option>
										<option>purple</option>
									</select>


									<div id="checkBoxes1">


										<div class="form-custom">
											<input type="text" class="form-control" id="member_search1"
												placeholder="Search Product">
											<span><img src="assets/img/icons/search.svg" alt="img"></span>
										</div>
										<div class="selectBox-cont">
											<label class="custom_check w-100">
												<input type="checkbox" name="username">
												<span class="checkmark"></span> Lenovo 3rd Generation
											</label>
											<label class="custom_check w-100">
												<input type="checkbox" name="username">
												<span class="checkmark"></span> Nike Jordan
											</label>
											<label class="custom_check w-100">
												<input type="checkbox" name="username">
												<span class="checkmark"></span> Apple Series 5 Watch
											</label>
											<label class="custom_check w-100">
												<input type="checkbox" name="username">
												<span class="checkmark"></span> Amazon Echo Dot
											</label>
											<!-- View All -->
											<div class="view-content">
												<div class="viewall-One">
													<label class="custom_check w-100">
														<input type="checkbox" name="username">
														<span class="checkmark"></span> Lobar Handy
													</label>
													<label class="custom_check w-100">
														<input type="checkbox" name="username">
														<span class="checkmark"></span> Woodcraft Sandal
													</label>
												</div>
												<div class="view-all">
													<a href="javascript:void(0);" class="viewall-button-One"><span
															class="me-2">View All</span><span><i
																class="fa fa-circle-chevron-down"></i></span></a>
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
				<!-- /Product -->

				<!-- Product Code -->
				<div class="accordion" id="accordionMain4">
					<div class="card-header-new" id="headingFour">
						<h6 class="filter-title">
							<a href="javascript:void(0);" class="w-100 collapsed" data-bs-toggle="collapse"
								data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
								Product Code
								<span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
							</a>
						</h6>
					</div>

					<div id="collapseFour" class="collapse" aria-labelledby="headingFour"
						data-bs-parent="#accordionExample4">
						<div class="card-body-chat">
							<div id="checkBoxes3">
								<div class="selectBox-cont">
									<div class="form-custom">
										<input type="text" class="form-control" id="member_search2"
											placeholder="Search Invoice">
										<span><img src="assets/img/icons/search.svg" alt="img"></span>
									</div>
									<label class="custom_check w-100">
										<input type="checkbox" name="category">
										<span class="checkmark"></span> P125389
									</label>
									<label class="custom_check w-100">
										<input type="checkbox" name="category">
										<span class="checkmark"></span> P125390
									</label>
									<label class="custom_check w-100">
										<input type="checkbox" name="category">
										<span class="checkmark"></span> P125391
									</label>
									<label class="custom_check w-100">
										<input type="checkbox" name="category">
										<span class="checkmark"></span> P125392
									</label>
									<!-- View All -->
									<div class="view-content">
										<div class="viewall-Two">
											<label class="custom_check w-100">
												<input type="checkbox" name="username">
												<span class="checkmark"></span> P125393
											</label>
											<label class="custom_check w-100">
												<input type="checkbox" name="username">
												<span class="checkmark"></span> P125394
											</label>
											<label class="custom_check w-100">
												<input type="checkbox" name="username">
												<span class="checkmark"></span> P125395
											</label>
										</div>
										<div class="view-all">
											<a href="javascript:void(0);" class="viewall-button-Two"><span
													class="me-2">View All</span><span><i
														class="fa fa-circle-chevron-down"></i></span></a>
										</div>
									</div>
									<!-- /View All -->
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Product Code -->

				<!-- Unts -->
				<div class="accordion accordion-last" id="accordionMain3">
					<div class="card-header-new" id="headingThree">
						<h6 class="filter-title">
							<a href="javascript:void(0);" class="w-100 collapsed" data-bs-toggle="collapse"
								data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
								Units
								<span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
							</a>
						</h6>
					</div>

					<div id="collapseThree" class="collapse" aria-labelledby="headingThree"
						data-bs-parent="#accordionExample3">
						<div class="card-body-chat">
							<div id="checkBoxes2">
								<div class="selectBox-cont">
									<label class="custom_check w-100">
										<input type="checkbox" name="bystatus">
										<span class="checkmark"></span> Inches
									</label>
									<label class="custom_check w-100">
										<input type="checkbox" name="bystatus">
										<span class="checkmark"></span> Pieces
									</label>
									<label class="custom_check w-100">
										<input type="checkbox" name="bystatus">
										<span class="checkmark"></span> Hours
									</label>
									<label class="custom_check w-100">
										<input type="checkbox" name="bystatus">
										<span class="checkmark"></span> Box
									</label>
									<label class="custom_check w-100">
										<input type="checkbox" name="bystatus">
										<span class="checkmark"></span> Kilograms
									</label>
									<label class="custom_check w-100">
										<input type="checkbox" name="bystatus">
										<span class="checkmark"></span> Meter
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Units -->

				<div class="filter-buttons">
					<button type="submit"
						class="d-inline-flex align-items-center justify-content-center btn w-100 btn-primary">
						Apply
					</button>
					<button type="submit"
						class="d-inline-flex align-items-center justify-content-center btn w-100 btn-secondary">
						Reset
					</button>
				</div>
			</form>

		</div>
	</div>
</div>
<!-- /Add Asset -->


</div>




<div class="modal fade" id="edit_inventory" tabindex="-1" aria-labelledby="editInventoryLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editInventoryLabel">Edit Product Information</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="edit_inventory_form">
					<input type="hidden" id="product_id" name="product_id">
					<div class="mb-3">
						<label for="product_name" class="form-label">Product Name</label>
						<input type="text" class="form-control" id="product_name" name="product_name">
					</div>
					<div class="mb-3">
						<label for="product_model" class="form-label">Product Model</label>
						<input type="text" class="form-control" id="product_model" name="product_model">
					</div>
					<div class="mb-3">
						<label for="serial_number" class="form-label">Serial Number</label>
						<input type="text" class="form-control" id="serial_number" name="serial_number">
					</div>
					<div class="mb-3">
						<label for="unit_price" class="form-label">Unit Price</label>
						<input type="text" class="form-control" id="unit_price" name="unit_price">
					</div>
					<div class="mb-3">
						<label for="working_status" class="form-label">Working Status</label>
						<select class="form-select" id="working_status" name="working_status">
							<option value="Working">Working</option>
							<option value="Not Working">Not Working</option>
						</select>
					</div>
					<div class="mb-3" id="not_working_type_block" style="display: none;">
						<label for="not_working_type" class="form-label">Not Working Type</label>
						<select class="form-select" id="not_working_type" name="not_working_type">
							<option value="Repairable">Repairable</option>
							<option value="Non-Repairable">Non-Repairable</option>
						</select>
					</div>
					<div class="mb-3" id="non_repairable_reason_block" style="display: none;">
						<label for="non_repairable_reason" class="form-label">Non-Repairable Reason</label>
						<select class="form-select" id="non_repairable_reason" name="non_repairable_reason">
							<option value="Scrapped">Scrapped</option>
							<option value="Discarded">Discarded</option>
						</select>
					</div>
					<div class="mb-3">
						<label for="material_tag" class="form-label">Material Tag</label>
						<select name="material_tag" class="form-select" id="material_tag">
							<option value="">Select</option>
							<option value="New">New</option>
							<option value="Refurbished">Refurbished</option>
						</select>
					</div>
					<div class="mb-3">
						<label for="status" class="form-label">Status</label>
						<select class="form-select" id="status" name="status">
							<option value="">Select</option>
							<option value="Available">Available</option>
							<option value="Not Available">Not Available</option>
						</select>
					</div>
					<div class="mb-3">
						<label for="remarks" class="form-label">Remarks</label>
						<textarea class="form-control" id="remarks" name="remarks"></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" data-bs-dismiss="modal"
							class="btn btn-back cancel-btn me-2">Cancel</button>
						<button type="submit" data-bs-dismiss="modal"
							class="btn btn-primary paid-continue-btn">Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



<!-- Add Product Modal -->
<div class="modal fade" id="add_inventory" tabindex="-1" aria-labelledby="addInventoryLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addInventoryLabel">Add New Product</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="add_inventory_form">
					<div class="mb-3">
						<label for="add_product_name" class="form-label">Product Name</label>
						<input type="text" class="form-control" id="add_product_name" name="product_name">
					</div>
					<div class="mb-3">
						<label for="add_product_model" class="form-label">Product Model</label>
						<input type="text" class="form-control" id="add_product_model" name="product_model">
					</div>
					<div class="mb-3">
						<label for="add_serial_number" class="form-label">Serial Number</label>
						<input type="text" class="form-control" id="add_serial_number" name="serial_number">
					</div>
					<div class="mb-3">
						<label for="add_unit_price" class="form-label">Unit Price</label>
						<input type="text" class="form-control" id="add_unit_price" name="unit_price">
					</div>
					<div class="mb-3">
						<label for="add_working_status" class="form-label">Working Status</label>
						<select class="form-select" id="add_working_status" name="working_status">
							<option value="Working">Working</option>
							<option value="Not Working">Not Working</option>
						</select>
					</div>
					<div class="mb-3" id="add_not_working_type_block" style="display: none;">
						<label for="add_not_working_type" class="form-label">Not Working Type</label>
						<select class="form-select" id="add_not_working_type" name="not_working_type">
							<option value="Repairable">Repairable</option>
							<option value="Non-Repairable">Non-Repairable</option>
						</select>
					</div>
					<div class="mb-3" id="add_non_repairable_reason_block" style="display: none;">
						<label for="add_non_repairable_reason" class="form-label">Non-Repairable Reason</label>
						<select class="form-select" id="add_non_repairable_reason" name="non_repairable_reason">
							<option value="Scrapped">Scrapped</option>
							<option value="Discarded">Discarded</option>
						</select>
					</div>
					<div class="mb-3">
						<label for="add_material_tag" class="form-label">Material Tag</label>
						<select name="material_tag" class="form-select" id="add_material_tag">
							<option value="">Select</option>
							<option value="New">New</option>
							<option value="Refurbished">Refurbished</option>
						</select>
					</div>
					<div class="mb-3">
						<label for="add_status" class="form-label">Status</label>
						<select class="form-select" id="add_status" name="status">
							<option value="">Select</option>
							<option value="Available">Available</option>
							<option value="Not Available">Not Available</option>
						</select>
					</div>
					<div class="mb-3">
						<label for="add_remarks" class="form-label">Remarks</label>
						<textarea class="form-control" id="add_remarks" name="remarks"></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" data-bs-dismiss="modal"
							class="btn btn-back cancel-btn me-2">Cancel</button>
						<button type="submit" data-bs-dismiss="modal"
							class="btn btn-primary paid-continue-btn">Add</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script src="./assets/js/helper/inventory.js"></script>

<?php include('./footer.php'); ?>