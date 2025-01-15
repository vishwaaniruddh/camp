<?php include('./header.php');  ?>

				<div class="content container-fluid">
				
					<!-- Page Header -->
					<div class="page-header">
						<div class="content-page-header ">
							<h5>Inventory</h5>
							<div class="list-btn">
								<ul class="filter-list">
									<li>
										<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="filter"><span class="me-2"><img src="assets/img/icons/filter-icon.svg" alt="filter"></span>Filter </a>
									</li>
									<li class="">
										<div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="download">
											<a href="#" class="btn-filters" data-bs-toggle="dropdown" aria-expanded="false"><span><i class="fe fe-download"></i></span></a>
											<div class="dropdown-menu dropdown-menu-right">
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
										<a class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="print"><span><i class="fe fe-printer"></i></span> </a>
									</li>
									<li>
										<a class="btn btn-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_inventory"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add New</a>
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
										<table class="table table-center table-hover datatable">
											<thead class="thead-light">
												<tr>
													<th>#</th>
													<th>Item</th>
													<th>Code</th>
													<th>Units</th>
													<th>Quantity</th>
													<th>Selling Price</th>
													<th>Purchase Price</th>
													<th class="no-sort">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>Lenovo 3rd Generation</td>
													<td>P125389</td>
													<td>Inches</td>
													<td>2</td>
													<td>$253.00</td>
													<td>$248.00</td>
													<td class="d-flex align-items-center">
														<a href="#" class="btn btn-greys bg-history-light me-2" data-bs-toggle="modal" data-bs-target="#inventory_history">
															<i class="far fa-eye me-1"></i> History
														</a> 
														<a href="#" class="btn btn-greys bg-success-light me-2" data-bs-toggle="modal" data-bs-target="#stock_in">
															<i class="fa fa-plus-circle me-1"></i> Stock in
														</a> 
														<a href="#" class="btn btn-greys bg-danger-light me-2" data-bs-toggle="modal" data-bs-target="#stock_out">
															<i class="fa fa-plus-circle me-1"></i> Stock out
														</a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_inventory"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_stock"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>2</td>
													<td>Nike Jordan</td>
													<td>P125390</td>
													<td>Pieces</td>
													<td>4</td>
													<td>$360.00</td>
													<td>$350.00</td>
													<td class="d-flex align-items-center">
														<a href="#" class="btn btn-greys bg-history-light me-2" data-bs-toggle="modal" data-bs-target="#inventory_history">
															<i class="far fa-eye me-1"></i> History
														</a> 
														<a href="#" class="btn btn-greys bg-success-light me-2" data-bs-toggle="modal" data-bs-target="#stock_in">
															<i class="fa fa-plus-circle me-1"></i> Stock in
														</a> 
														<a href="#" class="btn btn-greys bg-danger-light me-2" data-bs-toggle="modal" data-bs-target="#stock_out">
															<i class="fa fa-plus-circle me-1"></i> Stock out
														</a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_inventory"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_stock"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>3</td>
													<td>Apple Series 5 Watch</td>
													<td>P125391</td>
													<td>Inches</td>
													<td>7</td>
													<td>$724.00</td>
													<td>$700.00</td>
													<td class="d-flex align-items-center">
														<a href="#" class="btn btn-greys bg-history-light me-2" data-bs-toggle="modal" data-bs-target="#inventory_history">
															<i class="far fa-eye me-1"></i> History
														</a> 
														<a href="#" class="btn btn-greys bg-success-light me-2" data-bs-toggle="modal" data-bs-target="#stock_in">
															<i class="fa fa-plus-circle me-1"></i> Stock in
														</a> 
														<a href="#" class="btn btn-greys bg-danger-light me-2" data-bs-toggle="modal" data-bs-target="#stock_out">
															<i class="fa fa-plus-circle me-1"></i> Stock out
														</a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_inventory"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_stock"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>4</td>
													<td>Amazon Echo Dot</td>
													<td>P125392</td>
													<td>Box</td>
													<td>3</td>
													<td>$210.00</td>
													<td>$200.00</td>
													<td class="d-flex align-items-center">
														<a href="#" class="btn btn-greys bg-history-light me-2" data-bs-toggle="modal" data-bs-target="#inventory_history">
															<i class="far fa-eye me-1"></i> History
														</a> 
														<a href="#" class="btn btn-greys bg-success-light me-2" data-bs-toggle="modal" data-bs-target="#stock_in">
															<i class="fa fa-plus-circle me-1"></i> Stock in
														</a> 
														<a href="#" class="btn btn-greys bg-danger-light me-2" data-bs-toggle="modal" data-bs-target="#stock_out">
															<i class="fa fa-plus-circle me-1"></i> Stock out
														</a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_inventory"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_stock"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>5</td>
													<td>Lobar Handy</td>
													<td>P125393</td>
													<td>Kilograms</td>
													<td>1</td>
													<td>$155.00</td>
													<td>$150.00</td>
													<td class="d-flex align-items-center">
														<a href="#" class="btn btn-greys bg-history-light me-2" data-bs-toggle="modal" data-bs-target="#inventory_history">
															<i class="far fa-eye me-1"></i> History
														</a> 
														<a href="#" class="btn btn-greys bg-success-light me-2" data-bs-toggle="modal" data-bs-target="#stock_in">
															<i class="fa fa-plus-circle me-1"></i> Stock in
														</a> 
														<a href="#" class="btn btn-greys bg-danger-light me-2" data-bs-toggle="modal" data-bs-target="#stock_out">
															<i class="fa fa-plus-circle me-1"></i> Stock out
														</a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_inventory"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_stock"><i class="far fa-trash-alt me-2"></i>Delete</a>
																	</li>
																</ul>
															</div>
														</div>
													</td>
												</tr>
												<tr>
													<td>6</td>
													<td>Woodcraft Sandal</td>
													<td>P125389</td>
													<td>Inches</td>
													<td>2</td>
													<td>$253.00</td>
													<td>$248.00</td>
													<td class="d-flex align-items-center">
														<a href="#" class="btn btn-greys bg-history-light me-2" data-bs-toggle="modal" data-bs-target="#inventory_history">
															<i class="far fa-eye me-1"></i> History
														</a> 
														<a href="#" class="btn btn-greys bg-success-light me-2" data-bs-toggle="modal" data-bs-target="#stock_in">
															<i class="fa fa-plus-circle me-1"></i> Stock in
														</a> 
														<a href="#" class="btn btn-greys bg-danger-light me-2" data-bs-toggle="modal" data-bs-target="#stock_out">
															<i class="fa fa-plus-circle me-1"></i> Stock out
														</a> 
														<div class="dropdown dropdown-action">
															<a href="#" class=" btn-action-icon " data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
															<div class="dropdown-menu dropdown-menu-right">
																<ul>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_inventory"><i class="far fa-edit me-2"></i>Edit</a>
																	</li>
																	<li>
																		<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#delete_stock"><i class="far fa-trash-alt me-2"></i>Delete</a>
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
									<a href="javascript:void(0);" class="w-100" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										Product Name
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
														<input type="text" class="form-control" id="member_search1" placeholder="Search Product">
														<span><img src="assets/img/icons/search.svg" alt="img"></span>
													</div>
													<div class="selectBox-cont">
														<label class="custom_check w-100">
															<input type="checkbox" name="username">
															<span class="checkmark"></span>  Lenovo 3rd Generation
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
							<!-- /Product -->							

							<!-- Product Code -->
							<div class="accordion" id="accordionMain4">
								<div class="card-header-new" id="headingFour">
									<h6 class="filter-title">
									<a href="javascript:void(0);" class="w-100 collapsed"  data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
										Product Code
										<span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
									</a> 
									</h6>
								</div>
							
								<div id="collapseFour" class="collapse" aria-labelledby="headingFour"  data-bs-parent="#accordionExample4">
									<div class="card-body-chat">
										<div id="checkBoxes3">
											<div class="selectBox-cont">
												<div class="form-custom">														
													<input type="text" class="form-control" id="member_search2" placeholder="Search Invoice">
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
													<span class="checkmark"></span>  P125391
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
														<a href="javascript:void(0);" class="viewall-button-Two"><span class="me-2">View All</span><span><i class="fa fa-circle-chevron-down"></i></span></a>
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
									<a href="javascript:void(0);" class="w-100 collapsed"  data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
										Units
										<span class="float-end"><i class="fa-solid fa-chevron-down"></i></span>
									</a> 
									</h6>
								</div>
							
								<div id="collapseThree" class="collapse" aria-labelledby="headingThree"  data-bs-parent="#accordionExample3">
									<div class="card-body-chat">
										<div id="checkBoxes2">										
											<div class="selectBox-cont">
												<label class="custom_check w-100">
													<input type="checkbox" name="bystatus">
													<span class="checkmark"></span> Inches
												</label>
												<label class="custom_check w-100">
													<input type="checkbox" name="bystatus">
													<span class="checkmark"></span>  Pieces
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
			<!-- /Add Asset -->

			<!-- Add Stock in Modal -->
			<div class="modal custom-modal fade" id="stock_in" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Add Stock in</h4>
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
											<input type="text" class="bg-white-smoke form-control" placeholder="SEO Service">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Quantity</label>
											<input type="number" class="form-control" placeholder="0">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-0">
											<label>Units</label>
											<select class="select">
												<option>Pieces</option>
												<option>Inches</option>
												<option>Kilograms</option>
												<option>Inches</option>
												<option>Box</option>
											</select>
										</div>
									</div>								
									<div class="col-lg-12">
										<div class="input-block mb-0">
											<label>Notes</label>
											<textarea rows="3" cols="3" class="form-control" placeholder="Enter Notes"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
								<button type="submit" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Add Quantity</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Add Stock in Modal -->

			<!-- Remove Stock Modal -->
			<div class="modal custom-modal fade" id="stock_out" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Remove Stock</h4>
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
											<input type="text" class="bg-white-smoke form-control" placeholder="SEO Service">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Quantity</label>
											<input type="number" class="form-control" placeholder="0">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-0">
											<label>Units</label>
											<select class="select">
												<option>Pieces</option>
												<option>Inches</option>
												<option>Kilograms</option>
												<option>Inches</option>
												<option>Box</option>
											</select>
										</div>
									</div>								
									<div class="col-lg-12">
										<div class="input-block mb-0">
											<label>Notes</label>
											<textarea rows="3" cols="3" class="form-control" placeholder="Enter Notes"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
								<button type="submit" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Remove Quantity</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Remove Stock Modal -->

			<!-- Add Inventory -->
			<div class="modal custom-modal fade" id="add_inventory" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Add Inventory</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<form action="#">
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Name</label>
											<input type="text" class="form-control" placeholder="Enter Name">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Code</label>
											<input type="text" class="form-control" placeholder="Enter Code">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Units</label>
											<input type="text" class="form-control" placeholder="Enter Units">
										</div>
									</div>							
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Quantity</label>
											<input type="text" class="form-control" placeholder="Enter Quantity">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Selling Price</label>
											<input type="text" class="form-control" placeholder="Enter Selling Price">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Purchase Price</label>
											<input type="text" class="form-control" placeholder="Enter Purchase Price">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-0">
											<label>Status</label>
											<input type="text" class="form-control" placeholder="Enter Status">
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
								<button type="submit" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Add Inventory -->

			<!-- Edit Inventory -->
			<div class="modal custom-modal fade" id="edit_inventory" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Edit Inventory</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<form action="#">
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Name</label>
											<input type="text" class="form-control" value="Lorem ipsum dolor sit">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Code</label>
											<input type="text" class="form-control" value="P125389">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Units</label>
											<input type="text" class="form-control" value="Box">
										</div>
									</div>							
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Quantity</label>
											<input type="text" class="form-control" value="3">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Selling Price</label>
											<input type="text" class="form-control" value="$155.00">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-3">
											<label>Purchase Price</label>
											<input type="text" class="form-control" value="$150.00">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="input-block mb-0">
											<label>Status</label>
											<input type="text" class="form-control" value="Stock in">
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-bs-dismiss="modal" class="btn btn-back cancel-btn me-2">Cancel</button>
								<button type="submit" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Edit Inventory -->

			<!-- Delete Stock Modal -->
			<div class="modal custom-modal fade" id="delete_stock" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-body">
							<div class="form-header">
								<h3>Delete Inventory</h3>
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
			<!-- /Delete Stock Modal -->

			<!-- Inventory History Modal -->
			<div class="modal custom-modal fade" id="inventory_history" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-xl">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Inventory History</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<div class="modal-body">
							<!-- Table -->
							<div class="row">
								<div class="col-sm-12">
									<div class=" card-table">
										<div class="modal-card-table-head d-flex align-items-center justify-content-between mb-3">
											<div class="item-name">
												<h6>Nike Jordan</h6>
												<span>Item Code : P125390</span>
											</div>
											<div class="list-btn">
												<ul class="filter-list">
													<li class="">
														<div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="download">
															<a href="#" class="btn-filters" data-bs-toggle="dropdown" aria-expanded="false"><span><i class="fe fe-download"></i></span></a>
															<div class="dropdown-menu dropdown-menu-right">
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
														<a class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="print"><span><i class="fe fe-printer"></i></span> </a>
													</li>
												</ul>	
											</div>
										</div>
										<div class="card-body">
											<div class="table-responsive">
												<table class="table table-center table-hover datatable">
													<thead class="thead-light">
														<tr>
															<th>Date</th>
															<th>Units</th>
															<th>Adjustment</th>
															<th>Stock After</th>
															<th class="no-sort">Reason</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>16 Jun 2024, 04:12AM</td>
															<td>Inches</td>
															<td class="text-success">+20</td>
															<td>159</td>
															<td>Sale</td>
														</tr>
														<tr>
															<td>15 Jun 2024, 03:12AM</td>
															<td>Inches</td>
															<td class="text-danger">-15</td>
															<td>145</td>
															<td>Transfer</td>
														</tr>	
														<tr>
															<td>14 Jun 2024, 02:12AM</td>
															<td>Inches</td>
															<td class="text-success">+16</td>
															<td>125</td>
															<td>Damage</td>
														</tr>
														<tr>
															<td>13Jun 2024, 01:12AM</td>
															<td>Inches</td>
															<td class="text-success">+21</td>
															<td>95</td>
															<td>Sale</td>
														</tr>	
														<tr>
															<td>12 Jun 2024, 12:12 PM</td>
															<td>Inches</td>
															<td class="text-success">+54</td>
															<td>87</td>
															<td>Sale</td>
														</tr>	
														<tr>
															<td>11 Jun 2024, 04:12 AM</td>
															<td>Inches</td>
															<td class="text-danger">-09</td>
															<td>54</td>
															<td>Damage</td>
														</tr>	
														<tr>
															<td>09 Aug 2024, 12:12 PM</td>
															<td>Inches</td>
															<td class="text-success">+12</td>
															<td>210</td>
															<td>Sale</td>
														</tr>	
														<tr>
															<td>08 Jun 2024, 03:12AM</td>
															<td>Inches</td>
															<td class="text-success">+06</td>
															<td>200</td>
															<td>Transfer</td>
														</tr>	
														<tr>
															<td>07 Jun 2024, 03:12AM</td>
															<td>Inches</td>
															<td class="text-danger">-20</td>
															<td>145</td>
															<td>Sale</td>
														</tr>	
														<tr>
															<td>06 Jun 2024, 04:12 AM</td>
															<td>Inches</td>
															<td class="text-success">+12</td>
															<td>988</td>
															<td>Transfer</td>
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
					</div>
				</div>
			</div>
			<!-- /Inventory History Modal -->
	
<?php include('./footer.php'); ?>