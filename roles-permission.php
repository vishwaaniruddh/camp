<?php include('./header.php');  ?>

				<div class="content container-fluid">				
					<!-- Page Header -->
					<div class="page-header">
						<div class="content-page-header ">
							<h5>Roles & Permission</h5>
							<div class="list-btn">
								<ul class="filter-list">
									<li>
										<div class="short-filter">
											<img class="me-2" src="assets/img/icons/sort.svg" alt="Sort by select">
											<div class="sort-by sort-by-ticket">
												<select class="sort select">
												<option>Sort by: Date</option>
												<option>Sort by: Date 1</option>
												<option>Sort by: Date 2</option>
												</select>
											</div>
										</div>
									</li>
									<li>
										<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Filter"><span class="me-2"><img src="assets/img/icons/filter-icon.svg" alt="filter"></span>Filter </a>
									</li>
									<li>
										<a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#add_role"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Roles</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card-table">
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-center table-hover datatable">
											<thead class="thead-light">
												<tr>
													<th>ID</th>
													<th>Role Name</th>
													<th>Created at</th>
													<th Class="no-sort">Actions</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>Admin</td>
													<td>19 Dec 2023, 06:12 PM</td>
													<td class="d-flex align-items-center">
														<a href="#" class="btn btn-greys me-2" data-bs-toggle="modal" data-bs-target="#edit_role"><i class="fa fa-edit me-1"></i> Edit Role</a> 
														<a href="permission.html" class="btn btn-greys me-2"><i class="fa fa-shield me-1"></i> Permissions</a> 
													</td>
												</tr>
												<tr>
													<td>2</td>
													<td>Customer</td>
													<td>28 Nov 2023, 03:25 PM</td>
													<td class="d-flex align-items-center">
														<a href="#" class="btn btn-greys me-2" data-bs-toggle="modal" data-bs-target="#edit_role"><i class="fa fa-edit me-1"></i> Edit Role</a> 
														<a href="permission.html" class="btn btn-greys me-2"><i class="fa fa-shield me-1"></i> Permissions</a>  
													</td>
												</tr>
												<tr>
													<td>3</td>
													<td>Shop Owner</td>
													<td>19 Dec 2023, 06:12 PM</td>
													<td class="d-flex align-items-center">
														<a href="#" class="btn btn-greys me-2" data-bs-toggle="modal" data-bs-target="#edit_role"><i class="fa fa-edit me-1"></i> Edit Role</a> 
														<a href="permission.html" class="btn btn-greys me-2"><i class="fa fa-shield me-1"></i> Permissions</a>  
													</td>
												</tr>
												<tr>
													<td>4</td>
													<td>Receptionist</td>
													<td>9 Dec 2023, 06:12 PM</td>
													<td class="d-flex align-items-center">
														<a href="#" class="btn btn-greys me-2" data-bs-toggle="modal" data-bs-target="#edit_role"><i class="fa fa-edit me-1"></i> Edit Role</a> 
														<a href="permission.html" class="btn btn-greys me-2"><i class="fa fa-shield me-1"></i> Permissions</a>  
													</td>
												</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			

			<!-- Add Role Modal -->
			<div class="modal custom-modal fade" id="add_role" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Add Role</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<form action="#">
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="input-block mb-0">
											<label>Role Name <span class="text-danger">*</span></label>
											<input type="text" class="form-control" placeholder="Enter Role Name">
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Close</button>
								<button type="submit" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Add Role Modal -->

			<!-- Edit Role Modal -->
			<div class="modal custom-modal fade" id="edit_role" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Edit Role</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<form action="#">
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="input-block mb-0">
											<label>Role Name <span class="text-danger">*</span></label>
											<input type="text" class="form-control" Value="Admin" placeholder="Enter Role Name">
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Close</button>
								<button type="submit" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Edit Role Modal -->
		

			
<script src="./assets/js/helper/inventory.js"></script>

<?php include('./footer.php'); ?>