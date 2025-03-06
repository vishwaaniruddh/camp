<?php include('./header.php'); ?>

<style>
    #product-rows .product-row:first-child .remove-row {
        display: none;
    }
</style>


<div class="content container-fluid">

    <div class="card mb-0">
        <div class="card-body">
            <!-- Page Header -->
            <div class="page-header">
                <div class="content-page-header">
                    <h5>Update Customer Purchase Order (PO)</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <form id="updateCustomerPoFormData" enctype="multipart/form-data">
                    <input type="hidden" name="purchase_order_id" id="purchase_order_id" value="">
                    
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="input-block mb-3 add-products">
                                    <label>Purchase Order Number</label>
                                    <input type="text" class="form-control" name="po_number" id="po_number" placeholder="Enter PO Code"
                                        required>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Generate Serial Number"
                                        onclick="generatePONumber()"><i class="fas fa-cogs"></i></button>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="date">Customer:</label>
                                    <select class="form-select" name="customer" id="customer" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="bank">Bank:</label>
                                    <select class="form-select" name="bank" id="bank" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="date">Order Received Date:</label>
                                    <input type="date" class="form-control" id="order_received_date"
                                        name="order_received_date" value="<?php echo $date; ?>" required>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="date">Select BOQ:</label>
                                    <select class="form-select" name="boq" id="boq" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12" id="boq_items">
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <hr />
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12" id="add_info">
                            </div>


                        </div>








                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="notes">Notes:</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="reset" class="btn btn-primary cancel me-2">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Customer Purchase Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<script src="./assets/js/helper/customer-purchase-order.js"></script>


<?php include('./footer.php'); ?>