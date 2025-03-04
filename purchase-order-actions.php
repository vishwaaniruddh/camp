<?php include('./header.php'); ?>
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="content-page-header">
            <h5>Purchase Orders Actions</h5>
            <!-- <div class="list-btn">
                <ul class="filter-list">

                    <li>
                        <a class="btn-filters" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Settings"><span><i class="fe fe-settings"></i></span> </a>
                    </li>
                    <li>
                        <a class="btn btn-primary" href="add-purchase-orders.php"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Purchases Order</a>
                    </li>
                </ul>
            </div> -->
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Table -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-stripped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Purchase ID</th>
                                    <th>Vendor</th>
                                    <th>Amount</th>
                                    <th>Order Date</th>
                                    <th>Expected Delivery Date</th>
                                    <th>Current Status</th>
                                    <th>Created At</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody id="purchaseOrderActionTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Table -->

</div>


<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <div class="form-header modal-header-title text-start mb-0">
                    <h4 class="mb-0">Update Purchase Order</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateActionsPurchaseOrder">
                <input type="hidden" name="request_id" id="request_id" value="">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Status</label>
                            <select name="approvalStatus" id="approvalStatus" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Approved">Approve</option>
                                <option value="Cancelled">Cancel</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-4" id="showPurchaseOrderDetails"></div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    &nbsp;&nbsp;&nbsp;
                    <input type="submit" class="btn btn-primary" id="submit" value="Update">
                </div>
            </form>


        </div>
    </div>
</div>

<!-- /Page Wrapper -->

<script src="./assets/js/helper/purchase-order.js"></script>


<?php include('./footer.php'); ?>