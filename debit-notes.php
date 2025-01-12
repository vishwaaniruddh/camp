<?php include('./header.php'); ?>
				<div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="content-page-header">
							<h5>Purchase Returns / Debit Notes</h5>
							<div class="list-btn">
								<ul class="filter-list">
									<li>
										<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Filter"><span class="me-2"><img src="assets/img/icons/filter-icon.svg" alt="filter"></span>Filter </a>
									</li>
									<li>
										<a class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Settings"><span><i class="fe fe-settings"></i></span> </a>
									</li>
									<li>
										<a class="btn btn-primary" href="add-purchase-return.html"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Purchase Returns / Debit Notes</a>
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
										<table class="table table-stripped table-hover datatable">
											<thead class="thead-light">
												<tr>
												   <th>#</th>
												   <th>Debit Notes ID</th>
												   <th>Vendor</th>
												   <th>Amount</th>
												   <th>Payment Mode</th>
												   <th>Created On</th>	
												   <th>Status</th>
												   <th class="no-sort">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>	
													<td>
														<a href="invoice-details.html" class="invoice-link">#4905681</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-14.jpg" alt="User Image"></a>
															<a href="profile.html">John Smith <span>+1 843-443-3282</span></a>
														</h2>
													</td>
													<td>$1,54,220</td>													
													<td>Cash</td>
													<td>19 Dec 2023, 06:12 PM</td>
													<td><span class="badge bg-success-light text-success-light">Paid</span></td>
													<td class="d-flex align-items-center">
														<a class=" btn-action-icon me-2" href="javascript:void(0);" download><i class="fe fe-download"></i></a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="edit-purchase-return.html"><i class="far fa-edit me-2"></i>Edit</a>	
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="far fa-eye me-2"></i>View</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-send me-2"></i>Send</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-copy me-2"></i>Clone</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>2</td>	
													<td>
														<a href="invoice-details.html" class="invoice-link">#4905682</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-15.jpg" alt="User Image"></a>
															<a href="profile.html">Johnny <span>+1 917-409-0861</span></a>
														</h2>
													</td>
													<td>$1,54,220</td>													
													<td>Cash</td>
													<td>15 Dec 2023, 04:35 PM</td>
													<td><span class="badge bg-warning-light text-warning-light">Pending</span></td>
													<td class="d-flex align-items-center">
														<a class=" btn-action-icon me-2" href="javascript:void(0);" download><i class="fe fe-download"></i></a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="edit-purchase-return.html"><i class="far fa-edit me-2"></i>Edit</a>	
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="far fa-eye me-2"></i>View</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-send me-2"></i>Send</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-copy me-2"></i>Clone</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>3</td>	
													<td>
														<a href="invoice-details.html" class="invoice-link">#4905683</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-16.jpg" alt="User Image"></a>
															<a href="profile.html">Robert<span>+1 956-623-2880</span></a>
														</h2>
													</td>
													<td>$1,54,220</td>													
													<td>Cash</td>
													<td>04 Dec 2023, 12:38 PM</td>
													<td><span class="badge bg-danger-light">Cancelled</span></td>
													<td class="d-flex align-items-center">
														<a class=" btn-action-icon me-2" href="javascript:void(0);" download><i class="fe fe-download"></i></a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="edit-purchase-return.html"><i class="far fa-edit me-2"></i>Edit</a>	
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="far fa-eye me-2"></i>View</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-send me-2"></i>Send</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-copy me-2"></i>Clone</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>4</td>	
													<td>
														<a href="invoice-details.html" class="invoice-link">#4905684</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-17.jpg" alt="User Image"></a>
															<a href="profile.html">Sharonda<span>+1 707-439-1732</span></a>
														</h2>
													</td>
													<td>$1,54,220</td>													
													<td>Cash</td>
													<td>28 Nov 2023, 03:25 PM</td>
													<td><span class="badge bg-success-light text-success-light">Paid</span></td>
													<td class="d-flex align-items-center">
														<a class=" btn-action-icon me-2" href="javascript:void(0);" download><i class="fe fe-download"></i></a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="edit-purchase-return.html"><i class="far fa-edit me-2"></i>Edit</a>	
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="far fa-eye me-2"></i>View</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-send me-2"></i>Send</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-copy me-2"></i>Clone</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>5</td>	
													<td>
														<a href="invoice-details.html" class="invoice-link">#4905685</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-18.jpg" alt="User Image"></a>
															<a href="profile.html">Pricilla<span>+1 559-741-9672</span></a>
														</h2>
													</td>
													<td>$1,54,220</td>													
													<td>Cash</td>
													<td>20 Nov 2022, 02:47 PM</td>
													<td><span class="badge bg-warning-light text-warning-light">Pending</span></td>
													<td class="d-flex align-items-center">
														<a class=" btn-action-icon me-2" href="javascript:void(0);" download><i class="fe fe-download"></i></a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="edit-purchase-return.html"><i class="far fa-edit me-2"></i>Edit</a>	
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="far fa-eye me-2"></i>View</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-send me-2"></i>Send</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-copy me-2"></i>Clone</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>6</td>	
													<td>
														<a href="invoice-details.html" class="invoice-link">#4905686</a>
													</td>
													<td>
														<h2 class="table-avatar">
															<a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-19.jpg" alt="User Image"></a>
															<a href="profile.html">Randalll<span>+1 989-438-3131</span></a>
														</h2>
													</td>
													<td>$1,54,220</td>													
													<td>Cash</td>
													<td>15 Nov 2022, 10:42 AM</td>
													<td><span class="badge bg-danger-light">Cancelled</span></td>
													<td class="d-flex align-items-center">
														<a class=" btn-action-icon me-2" href="javascript:void(0);" download><i class="fe fe-download"></i></a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="edit-purchase-return.html"><i class="far fa-edit me-2"></i>Edit</a>	
																	</li>
																	<li>
																		<a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="far fa-eye me-2"></i>View</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-send me-2"></i>Send</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#"><i class="fe fe-copy me-2"></i>Clone</a>
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
					<!-- /Table -->

				</div>
		
			<!-- Delete Items Modal -->
			<div class="modal custom-modal fade" id="delete_modal" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-body">
							<div class="form-header">
								<h3>Delete Debit Notes</h3>
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
		
		
<?php include('./footer.php'); ?>