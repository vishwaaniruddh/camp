<?php include('./header.php');  ?>


				<div class="content container-fluid">				
					<!-- Page Header -->
					<div class="page-header">
						<div class="content-page-header ">
							<h5>Users</h5>
							<div class="list-btn">
								<ul class="filter-list">
									<li>
										<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Filter"><span class="me-2"><img src="assets/img/icons/filter-icon.svg" alt="filter"></span>Filter </a>
									</li>
									<li>
										<a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_user"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add user</a>
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
													<th>#</th>
													<th>User Name</th>
													<th>Mobile Number</th>
													<th>Role </th>
													<th>Last Activity</th>
													<th>Created on</th>
													<th>Status</th>
													<th Class="no-sort">Actions</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-14.jpg" alt="User Image"></a>
															<a href="profile.html">John Smith <span><span class="__cf_email__" data-cfemail="355f5a5d5b75504d54584559501b565a58">[email&#160;protected]</span></span></a>
														</h2>
													</td>
													<td>+1 989-438-3131</td>
													<td>$4,220</td>
													<td><span class="badge  bg-ash-gray text-gray-light">10 mins ago</span></td>
													<td>19 Dec 2023, 06:12 PM</td>
													<td><span class="badge  bg-success-light">Active</span></td>
													<td class="d-flex align-items-center">
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>2</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-15.jpg" alt="User Image"></a>
															<a href="profile.html">Johnny <span><span class="__cf_email__" data-cfemail="0f6560676161764f6a776e627f636a216c6062">[email&#160;protected]</span></span></a>
														</h2>
													</td>
													<td>+1 843-443-3282</td>
													<td>$1,862</td>
													<td><span class="badge  bg-success-light">Online</span></td>
													<td>15 Dec 2023, 06:12 PM</td>
													<td><span class="badge  bg-success-light">Active</span></td>
													<td class="d-flex align-items-center">
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>3</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-16.jpg" alt="User Image"></a>
															<a href="profile.html">Robert <span><span class="__cf_email__" data-cfemail="84f6ebe6e1f6f0c4e1fce5e9f4e8e1aae7ebe9">[email&#160;protected]</span></span></a>
														</h2>
													</td>
													<td>+1 917-409-0861</td>
													<td>$2,789</td>
													<td><span class="badge  bg-success-light">Online</span></td>
													<td>04 Dec 2023, 12:38 PM</td>
													<td><span class="badge  bg-ash-gray text-gray-light">Restricted</span></td>
													<td class="d-flex align-items-center">
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>4</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-17.jpg" alt="User Image"></a>
															<a href="profile.html">Sharonda <span><span class="__cf_email__" data-cfemail="16657e7764797856736e777b667a733875797b">[email&#160;protected]</span></span></a>
														</h2>
													</td>
													<td>+1 956-623-2880</td>
													<td>$6,789</td>
													<td><span class="badge  bg-ash-gray text-gray-light">1 hour ago</span></td>
													<td>14 Dec 2023, 12:38 PM</td>
													<td><span class="badge  bg-success-light">Active</span></td>
													<td class="d-flex align-items-center">
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>5</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-18.jpg" alt="User Image"></a>
															<a href="profile.html">Pricilla <span><span class="__cf_email__" data-cfemail="8afaf8e3e9e3e6e6ebcaeff2ebe7fae6efa4e9e5e7">[email&#160;protected]</span></span></a>
														</h2>
													</td>
													<td>+1 956-613-2880</td>
													<td>$1,789</td>
													<td><span class="badge  bg-success-light">Online</span></td>
													<td>12 Dec 2023, 12:38 PM</td>
													<td><span class="badge  bg-success-light">Active</span></td>
													<td class="d-flex align-items-center">
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>6</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-19.jpg" alt="User Image"></a>
															<a href="profile.html">Randall <span><span class="__cf_email__" data-cfemail="f587949b91949999b5908d9498859990db969a98">[email&#160;protected]</span></span></a>
														</h2>
													</td>
													<td>+1 117-409-0861</td>
													<td>$1,789</td>
													<td><span class="badge  bg-ash-gray text-gray-light">2 days ago</span></td>
													<td>04 Dec 2023, 12:38 PM</td>
													<td><span class="badge  bg-ash-gray text-gray-light">Restricted</span></td>
													<td class="d-flex align-items-center">
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_user"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			<!-- Add User -->
			<div class="modal custom-modal modal-lg fade" id="add_user" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Add User</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<form action="#">
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<div class="card-body">
											<div class="form-groups-item">
												<h5 class="form-title">Profile Picture</h5>
												<div class="profile-picture">
													<div class="upload-profile">
														<div class="profile-img">
															<img id="blah" class="avatar" src="assets/img/profiles/avatar-10.jpg" alt="profile-img">
														</div>
														<div class="add-profile">
															<h5>Upload a New Photo</h5>
															<span>Profile-pic.jpg</span>
														</div>
													</div>
													<div class="img-upload">
														<a class="btn btn-primary me-2">Upload</a>
														<a class="btn btn-remove">Remove</a>
													</div>										
												</div>
												<div class="row">
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>First Name</label>
															<input type="text" class="form-control" placeholder="Enter First Name">
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>Last Name</label>
															<input type="text" class="form-control" placeholder="Enter Last Name">
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>User Name</label>
															<input type="text" class="form-control" placeholder="Enter User Name">
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>Email</label>
															<input type="email" class="form-control" placeholder="Enter Email Address">
														</div>											
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>Phone Number</label>
															<input type="text" class="form-control" placeholder="Enter Phone Number" name="name">
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">											
														<div class="input-block mb-3">
															<label>Role</label>
															<select class="select">
																<option>Select Role</option>
																<option>Role 1</option>
																<option>Role 2</option>
															</select>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="pass-group" id="3">
															<div class="input-block">
																<label>Password</label>
																<input type="password" class="form-control pass-input" placeholder="">
																<span class="toggle-password feather-eye"></span>
															</div>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="pass-group" id="passwordInput2">
															<div class="input-block">
																<label>Confirm Password</label>
																<input type="password" class="form-control pass-input" placeholder="">
																<span class="toggle-password feather-eye"></span>
															</div>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">											
														<div class="input-block ">
															<label>Status</label>
															<select class="select">
																<option>Select Status</option>
																<option>Active</option>
																<option>Inactive</option>
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
								<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
								<button type="submit" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Add User</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Add User -->

			<!-- Add User -->
			<div class="modal custom-modal modal-lg fade" id="edit_user" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Edit User</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<form action="#">
							<div class="modal-body">
								<div class="row">
									<div class="col-md-12">
										<div class="card-body">
											<div class="form-groups-item">
												<h5 class="form-title">Profile Picture</h5>
												<div class="profile-picture">
													<div class="upload-profile">
														<div class="profile-img">
															<img id="blah2" class="avatar" src="assets/img/profiles/avatar-10.jpg" alt="profile-img">
														</div>
														<div class="add-profile">
															<h5>Upload a New Photo</h5>
															<span>Profile-pic.jpg</span>
														</div>
													</div>
													<div class="img-upload">
														<label class="btn btn-primary">
															Upload <input type="file">
														</label>
														<a class="btn btn-remove">Remove</a>
													</div>										
												</div>
												<div class="row">
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>First Name</label>
															<input type="text" value="John" class="form-control" placeholder="Enter First Name">
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>Last Name</label>
															<input type="text" class="form-control" value="Smith" placeholder="Enter Last Name">
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>User Name</label>
															<input type="text" class="form-control" value="John Smith" placeholder="Enter User Name">
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>Email</label>
															<input type="email" class="form-control" value="john@example.com" placeholder="Enter Email Address">
														</div>											
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="input-block mb-3">
															<label>Phone Number</label>
															<input type="text" class="form-control" value="+1 989-438-3131" placeholder="Enter Phone Number" name="name">
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">											
														<div class="input-block mb-3">
															<label>Role</label>
															<select class="select">
																<option>Select Role</option>
																<option selected>Role 1</option>
																<option>Role 2</option>
															</select>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="pass-group" id="passwordInput1">
															<div class="input-block">
																<label>Password</label>
																<input type="password" class="form-control pass-input" value="12345678" placeholder="">
																<span class="toggle-password feather-eye"></span>
															</div>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">
														<div class="pass-group" id="passwordInput4">
															<div class="input-block">
																<label>Confirm Password</label>
																<input type="password" class="form-control pass-input" value="12345678" placeholder="">
																<span class="toggle-password feather-eye"></span>
															</div>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12">											
														<div class="input-block ">
															<label>Status</label>
															<select class="select">
																<option>Select Status</option>
																<option selected>Active</option>
																<option>Inactive</option>
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
								<button type="submit" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Edit User -->

			<!-- Delete Items Modal -->
			<div class="modal custom-modal fade" id="delete_modal" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-body">
							<div class="form-header">
								<h3>Delete Users</h3>
								<p>Are you sure want to delete?</p>
							</div>
							<div class="modal-btn delete-action">
								<div class="row">
									<div class="col-6">
										<a href="#" class="btn btn-primary paid-continue-btn">Delete</a>
									</div>
									<div class="col-6">
										<a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /Delete Items Modal -->
			
	
			

<script src="./assets/js/helper/inventory.js"></script>

<?php include('./footer.php'); ?>