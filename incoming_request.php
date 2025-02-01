<?php include('./header.php');

$statuses = [
    0 => "Select",
    1 => "Material Requirement",
    2 => "Available",
    3 => "Not Available",
    4 => "Dispatched",
    5 => "Confirm Processed",
    6 => "Cancelled",
];
$selectedStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : null;

?>


<div class="content container-fluid">

<div class="page-header">
		<div class="content-page-header ">
			<h5>Material Request
                <span id="currentSelectedStatus" style="font-size:12px; color:red;"></span>
            </h5>
			<div class="list-btn">
				<ul class="filter-list">
					<li>
						<a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="filter"><span class="me-2"><img src="assets/img/icons/filter-icon.svg" alt="filter"></span>Filter </a>
					</li>

					<li class="">
						<div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="top" title="download">
							<a href="javascript:void(0);" id="downloadExcel" class="btn-filters download-item"><span><i class="fe fe-download"></i></span></a>

						</div>
					</li>

				</ul>
			</div>
		</div>
	</div>


    <div class="row">
        <div class="col-sm-12">



            <div class="row">
                <div class="col-sm-12">
                    <div class=" card-table">
                    <h6 style="text-align: right; font-size: 12px; color: #000; margin-bottom: 0px;">Total Records: <span id="count">0</span></h6>
                    <br/>
                        <div class="card-body">
                            <div class="table-responsive">
                                
                                
                                <table class="table table-center table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Actions</th>
                                            <th>Ticket ID</th>
                                            <th>Customer</th>

                                            <th>Bank</th>
                                            <th>ATM ID</th>
                                            <th>Material Condition</th>
                                            <th>Require Material Name</th>
                                            <th>Dispatch Address</th>
                                            <th>Contact Person</th>
                                            <th>Remark</th>
                                            <th>Requested At</th>
                                            <th>Location</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Zone</th>
                                            <th>MIS ID</th>
                                            <th>Created By</th>
                                        </tr>
                                    </thead>
                                    <tbody id="requestTableBody">

                                    </tbody>
                                </table>



                            </div>
                            <div id="pagination" class="pagination-container"></div>

                        </div>
                    </div>
                </div>
            </div>

            <div id="pagination" class="pagination-container"></div>

        </div>
    </div>

</div>


<div class="toggle-sidebar">
    <div class="sidebar-layout-filter">
        <div class="sidebar-header">
            <h5>Filter</h5>
            <a href="#" class="sidebar-closes"><i class="fa-regular fa-circle-xmark"></i></a>
        </div>
        <div class="sidebar-body">
            <div class="filters">
                <div class="form-custom mb-3">
                    <select id="status" class="form-control" name="status">
                        <?php foreach ($statuses as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php echo ($selectedStatus == $value) ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>



                <button id="applyFilters" class="btn btn-primary sidebar-closes">Apply Filters</button>
            </div>
        </div>
    </div>
</div>


<script src="./assets/js/helper/request.js"></script>

<?php include('./footer.php'); ?>