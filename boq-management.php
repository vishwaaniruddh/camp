<?php include('./header.php'); ?>


<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="content-page-header ">
            <h5>BOQ Management</h5>
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

                        <button style="border:none;" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                            class="btn btn-primary view-request-btn" data-request-id="${requestData.mis_id}"><i
                                class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add New BOQ</button>

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

                        <table class="table table-center table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>BOQ Number</th>
                                    <th>Customer</th>
                                    <th>Bank</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody id="boqTableBody"></tbody>
                        </table>
                    </div>

                </div>
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
                    <h4 class="mb-0">Add New BOQ</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="submit_adding_new_boq">
                <div class="modal-body">
                    <div class="row">
                        <div class="mt-2 col-md-6">
                            <div class="form-group">
                                <label>Customer</label>
                                <select class="form-control" name="customer" id="customer">
                                    <option value="">Select Customer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class=" form-group">
                                <label>Bank</label>
                                <select class="form-control" name="bank" id="bank">
                                    <option value="">Select Bank</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-2 col-md-12">
                            <div class="form-group">
                                <label>BOQ Name</label>
                                <input type="text" class="form-control" name="boq_name" id="boq_name"
                                    placeholder="Enter BOQ Name">
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h5>BOQ Items</h5>
                            <table class="table table-bordered" id="boq_items_table" border="1">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                    </tr>
                                </thead>
                                <tbody id="product-rows">
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success" id="addRow"><i class="fa fa-plus"></i> Add
                                Row</button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary save-boq-items">Save</button>
                </div>
                
            </form>

        </div>
    </div>
</div>



<div class="modal custom-modal fade" id="view_boq_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="form-header modal-header-title text-start mb-0">
                    <h4 class="mb-0">BOQ Items - <span id="boq_number" style="font-size:12px;color:red;"></span> </h4>

                    <button class="btn btn-success btn-sm" id="add_item_btn" data-boq-number="">Add Item</button>

                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="boqItems"></div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn me-2">Cancel</button>
            </div>
        </div>
    </div>
</div>


<script src="./assets/js/helper/boq-management.js"></script>

<?php include('./footer.php'); ?>