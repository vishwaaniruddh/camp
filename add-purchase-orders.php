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
                    <h5>Purchase Order (PO)</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <form id="addPoFormData" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3 add-products">
                                    <label>Purchase Order Number</label>
                                    <input type="text" class="form-control" name="po_number"
                                        placeholder="Enter PO Code" required>
                                    <button type="button" class="btn btn-primary" onclick="generatePONumber()">Generate
                                        Code</button>
                                </div>
                            </div>



                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">

                                    <label for="vendor">Vendor:</label>
                                    <select class="form-select" name="vendor_id" id="vendor" required>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="date">Order Date:</label>
                                    <input type="date" class="form-control" id="date" name="order_date"
                                        value="<?php echo $date; ?>" required>
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="date">Expected Date of delivery:</label>
                                    <input type="date" class="form-control" id="expected_delivery_date"
                                        name="expected_delivery_date" value="<?php echo $date; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group-item">
                            <label for="products">Products:</label>
                            <table class="table table-bordered" id="product-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Stock (Qty)</th>
                                        <th>Unit Cost</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="product-rows">
                                    <tr class="product-row">
                                        <td class="serial-number">1</td>
                                        <td>
                                        <select class="form-control product_name_model" name="product_name[]" required></select>
    
                                             </td>
                                        <td><input type="number" class="form-control stock" name="quantity[]" required>
                                        </td>
                                        <td><input type="number" step="0.01" class="form-control unit-cost"
                                                name="unit_cost[]" required></td>
                                        <td>
                                            <i class="fa fa-minus-circle me-1 remove-row"></i>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                            <a href="#" class="btn btn-greys bg-success-light me-2" id="add-row">
                                <i class="fa fa-plus-circle me-1"></i> Add Product
                            </a>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="total_cost">Total Cost:</label>
                                    <input type="number" step="0.01" class="form-control" id="total_cost"
                                        name="total_cost" readonly>
                                </div>
                            </div>

                            <div class="col-lg-8 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="notes">Notes:</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="reset" class="btn btn-primary cancel me-2">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Purchase Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<script src="./assets/js/helper/purchase-order.js"></script>


<?php include('./footer.php'); ?>