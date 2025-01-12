<?php include('./header.php'); ?>
				<div class="content container-fluid">
					<div class="card mb-0">
						<div class="card-body">
							<div class="content-page-header">
								<h5>Add Purchases</h5>
							</div>					
							<div class="row">
								<div class="col-md-12">
									<div class="form-group-item border-0 mb-0">
										<div class="row align-item-center">
											<div class="col-lg-4 col-md-6 col-sm-12">
												<div class="input-block mb-3">
													<label>Purchases Id</label>
													<input type="text" class="form-control" placeholder="Enter Purchases Id">
												</div>
											</div>										
											<div class="col-lg-4 col-md-6 col-sm-12">											
												<div class="input-block mb-3">
													<label>Select Vendor</label>
													<ul class="form-group-plus css-equal-heights">
														<li>
															<select class="select">
																<option>Choose Vendor</option>
																<option>Vendor 1</option>
																<option>vendor 2</option>
																<option>vendor 3</option>
															</select>
														</li>
														<li>    
															<a class="btn btn-primary form-plus-btn" href="add-customer.php"><i class="fas fa-plus-circle"></i></a>
														</li>
													</ul>												
												</div>									
											</div>
											<div class="col-lg-4 col-md-6 col-sm-12">
												<div class="input-block mb-3">
													<label>Purchases Date</label>
													<input type="text" class="datetimepicker form-control" placeholder="Select Date">
												</div>											
											</div>
											<div class="col-lg-4 col-md-6 col-sm-12">
												<div class="input-block mb-3">
													<label>Due Date</label>
													<input type="text" class="datetimepicker form-control" placeholder="Select Date">
												</div>											
											</div>
											<div class="col-lg-4 col-md-6 col-sm-12">
												<div class="input-block mb-3">
													<label>Reference No</label>
													<input type="text" class="form-control" placeholder="Enter Reference Number">
												</div>
											</div>
											<div class="col-lg-4 col-md-6 col-sm-12">
												<div class="input-block mb-3">
													<label>Supplier Invoice Serial No</label>
													<input type="text" class="form-control" placeholder="Enter Supplier Invoice Serial No">
												</div>
											</div>
											<div class="col-lg-12">											
												<div class="input-block mb-3">
													<label>Products</label>
													<ul class="form-group-plus css-equal-heights">
														<li>
															<select class="select">
																<option>Select Product</option>
																<option>Product 1</option>
																<option>Product 2</option>
																<option>Product 3</option>
															</select>
														</li>
														<li>    
															<a class="btn btn-primary form-plus-btn" href="add-products.html"><i class="fas fa-plus-circle"></i></a>
														</li>
													</ul>												
												</div>									
											</div>
										</div>
									</div>
									<div class="form-group-item">
										<div class="card-table">
											<div class="card-body">
												<div class="table-responsive no-pagination">
													<table class="table table-center table-hover datatable">
														<thead class="thead-light">
															<tr>
																<th>Product / Service</th>
																<th>Quantity</th>
																<th>Unit</th>
																<th>Rate</th>
																<th>Discount</th>
																<th>Tax</th>
																<th>Amount</th>
																<th class="no-sort">Action</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Nike Jordan</td>
																<td>1</td>
																<td>Pcs</td>
																<td>$1360.00</td>
																<td>0</td>
																<td>0</td>
																<td>$1360.00</td>
																<td class="d-flex align-items-center">
																	<a href="#" class="btn-action-icon me-2" data-bs-toggle="modal" data-bs-target="#add_discount"><span><i class="fe fe-edit"></i></span></a>
																	<a href="#" class="btn-action-icon" data-bs-toggle="modal" data-bs-target="#delete_discount"><span><i class="fe fe-trash-2"></i></span></a>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="row">
												<div class="col-lg-7">
													<div class="input-block mb-3">
														<label>Discount Type</label>
														<select class="select">
															<option>Percentage(%)</option>
															<option>Fixed</option>
														</select>
													</div>
												</div>
												<div class="col-lg-5">
													<div class="input-block mb-3">
														<label>Discount(%)</label>
														<input type="text" class="form-control" placeholder="10">
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="input-block mb-3">
												<label>Tax</label>
												<select class="select">
													<option>No Tax</option>
													<option>IVA - (21%)</option>
													<option>IRPF - (-15%)</option>
													<option>PDV - (20%)</option>
												</select>
											</div>
										</div>
										<div class="col-md-4"></div>
									</div>
									<div class="form-group-item border-0 p-0">
										<div class="row">
											<div class="col-xl-6 col-lg-12">
												<div class="form-group-bank">
													<div class="row align-items-center">
														<div class="col-md-8">
															<div class="input-block mb-3">
																<label>Select Bank</label>
																<select class="select">
																	<option>Select Bank</option>
																	<option>SBI</option>
																	<option>IOB</option>
																	<option>Canara</option>
																</select>
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-groups">
																<a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#bank_details">Add Bank</a>
															</div>
														</div>
													</div>
													
													<div class="input-block mb-3 notes-form-group-info">
														<label>Notes</label>
														<textarea class="form-control" placeholder="Enter Notes"></textarea>
													</div>
													<div class="input-block notes-form-group-info mb-0">
														<label>Terms and Conditions</label>
														<textarea class="form-control" placeholder="Enter Terms and Conditions"></textarea>
													</div>
												</div>
											</div>
											<div class="col-xl-6 col-lg-12">
												<div class="form-group-bank">
													<div class="invoice-total-box">
														<div class="invoice-total-inner">
															<p>Taxable Amount <span>$1360.00</span></p>
															<p>Discount <span>$136.00</span></p>
															<p>Vat <span>$0.00</span></p>
															<div class="status-toggle justify-content-between">
																<div class="d-flex align-center">
																	<p>Round Off </p>
																	<input id="rating_1" class="check" type="checkbox" checked="">
																	<label for="rating_1" class="checktoggle checkbox-bg">checkbox</label>
																</div>
																<span>$0.00</span>
															</div>																
														</div>
														<div class="invoice-total-footer">
															<h4>Total Amount <span>$1224.00</span></h4>
														</div>
													</div>
													<div class="input-block mb-3">
														<label>Signature Name</label>
														<input type="text" class="form-control" placeholder="Enter Signature Name">
													</div>
													<div class="input-block mb-0">
														<label>Signature Image</label>
														<div class="input-block service-upload service-upload-info mb-0">
															<span><i class="fe fe-upload-cloud me-1"></i>Upload Signature</span>
															<input type="file" multiple="" id="image_sign">
															<div id="frames"></div>
														</div>
													</div>
												</div>
											</div>
										</div>	
									</div>								
									<form action="https://kanakku.dreamstechnologies.com/html/template/purchases.html" class="text-end">
										<button type="reset" class="btn btn-primary cancel me-2">Cancel</button>
										<button type="submit" class="btn btn-primary">Save</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>


			<!-- Add Tax & Discount Modal -->
			<div class="modal custom-modal fade" id="add_discount" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Add Tax & Discount</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-3">
										<label>Rate</label>
										<input type="number" class="form-control" placeholder="120">
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-3">
										<label>Discount Amount</label>
										<input type="number" class="form-control" placeholder="0">
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-0">
										<label>Tax</label>
										<select class="select">
											<option>N/A</option>
											<option>5%</option>
											<option>10%</option>
											<option>15%</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn me-2">Back</a>
							<a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Save</a>
						</div>
					</div>
				</div>
			</div>
			<!-- /Add Tax & Discount Modal -->

			<!-- Delete Items Modal -->
			<div class="modal custom-modal fade" id="delete_discount" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-body">
							<div class="form-header">
								<h3>Delete Product / Services</h3>
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

			<!-- Add Bank Details Modal -->
			<div class="modal custom-modal fade" id="bank_details" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-md">
					<div class="modal-content">
						<div class="modal-header border-0 pb-0">
							<div class="form-header modal-header-title text-start mb-0">
								<h4 class="mb-0">Add Bank Details</h4>
							</div>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
								
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-3">
										<label>Bank Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" placeholder="Enter Bank Name">
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-3">
										<label>Account Number <span class="text-danger">*</span></label>
										<input type="number" class="form-control" placeholder="Enter Account Number">
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-3">
										<label>Branch Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" placeholder="Enter Branch Name">
									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="input-block mb-0">
										<label>IFSC Code <span class="text-danger">*</span></label>
										<input type="number" class="form-control" placeholder="Enter IFSC COde">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn me-2">Back</a>
							<a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Save</a>
						</div>
					</div>
				</div>
			</div>
			<!-- /Add Bank Details Modal -->
	
	
	
<?php include('./footer.php'); ?>