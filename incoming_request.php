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
                        <a class="btn btn-filters w-auto popup-toggle" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" title="Advance filter"><span class="me-2"><img
                                    src="assets/img/icons/filter-icon.svg" alt="filter"></span>Advance Filter </a>
                    </li>

                    <li class="">
                        <div class="dropdown dropdown-action" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="download">
                            <a href="javascript:void(0);" id="downloadExcel" class="btn-filters download-item"><span><i
                                        class="fe fe-download"></i></span></a>

                        </div>
                    </li>

                </ul>
            </div>
        </div>

        <?php
        foreach ($statuses as $key => $value) {
            if ($key > 0) {
                echo '<a class="btn btn-outline-primary" href="./incoming_request.php?status=' . $key . '" data-bs-toggle="tooltip" data-bs-placement="bottom">' . $value . '</a> &nbsp;&nbsp;&nbsp;';
            }
        }

        ?>
    </div>


    <div class="row">
        <div class="col-sm-12">



            <div class="row">
                <div class="col-sm-12">
                    <div class=" card-table">
                        <h6 style="text-align: right; font-size: 12px; color: #000; margin-bottom: 0px;">Total Records:
                            <span id="count">0</span>
                        </h6>
                        <br />
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



<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="form-header modal-header-title text-start mb-0">
                    <h4 class="mb-0">Enter Dispatch Information</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                </button>
            </div>
            <form id="submit_dispatch_info_form">
                <input type="hidden" name="request_id" id="request_id" value="">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <label>Availability</label>
                            <select class="form-control" name="availability" id="availability" required="">
                                <option value="">Select</option>
                                <option value="available">Material Dispatch</option>
                                <option value="not_available">Material Not Available</option>
                            </select>
                        </div>

                    </div>
                    <!--onchange="setaddress()"-->
                    <br>
                    <div class="row address_type">
                        <div class="col-sm-4">
                            <label>Address Type</label>
                            <select class="form-control" id="address_type" name="address_type">
                                <option value="Branch" id="Branch">Branch</option>
                            </select>
                        </div>
                        <div class="col-sm-8">
                            <label>Address</label>
                            <input class="form-control" name="address" id="address" value="Loading...">
                        </div>
                    </div>
                    <br>
                    <div class="row contact">
                        <div class="col-sm-6" id="Contactperson_name">
                            <label for="Contactperson_name">Contact Person Name</label>
                            <input type="text" class="form-control" name="Contactperson_name" value="Loading..."
                                id="contact_person_name">
                        </div>
                        <div class="col-sm-6" id="Contactperson_mob">
                            <label for="Contactperson_mob">Contact Person Mobile</label>
                            <input type="text" class="form-control" name="Contactperson_mob" value="Loading..."
                                id="contact_person_mobile">
                        </div>
                    </div>
                    <br>

                    <div class="row cust_hide">

                        <div class="col-sm-12 mb-3">
                            <div class="row">

                                <div class="col-sm-6">
                                    <label>Courier Name</label>
                                    <select name="courier_name" id="fetch_courier_dropdown" class="form-control">
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label>POD</label>
                                    <input type="text" name="pod" id="dispatch_pod" class="form-control" placeholder="Enter POD ..">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Dispatch Date</label>
                                    <input type="date" name="dispatch_date" class="form-control"
                                        value="<?php echo $date; ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label>Serial Number</label>
                                    <input type="text" name="serial_number" id="serial_number" class="form-control"
                                        required="">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Remark</label>
                            <input type="text" name="remark" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    &nbsp;&nbsp;&nbsp;
                    <input type="submit" class="btn btn-primary" id="submit_dispatch_info" value="Dispatch">
                </div>
            </form>


        </div>
    </div>
</div>



<script src="./assets/js/helper/request.js"></script>

<?php include('./footer.php'); ?>