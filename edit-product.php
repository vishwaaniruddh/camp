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

						<div id="pagination" class="pagination-container"></div>


					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Table -->

</div>



<script src="./assets/js/helper/inventory.js"></script>

<?php include('./footer.php'); ?>