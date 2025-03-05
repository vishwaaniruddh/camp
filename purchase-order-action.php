<?php include('./header.php');

$purchase_order = $_REQUEST['purchase-order'];
?>

<style>
    .remove-row {
        display: none;
    }

    label,
    th {
        font-weight: 700 !important;
    }
</style>




<div class="content container-fluid" id="edit-po-container">

    <div class="card mb-0">
        <div class="card-body">
            <!-- Page Header -->
            <div class="page-header">
                <div class="content-page-header">
                    <h5>Edit - Customer Purchase Order (PO)</h5>
                </div>
            </div>
            <!-- /Page Header -->

            <div class="row">
                <div class="col-sm-12">
                    <form id="editPoActions" enctype="multipart/form-data">

                        <div class="row">

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3 add-products">
                                    <label>Purchase Order Number</label>
                                    <p id="po_number"></p>

                                    <!-- <input type="text" class="form-control" name="po_number"  placeholder="Enter PO Code" readonly> -->
                                    <!-- <button type="button" class="btn btn-primary" onclick="generatePONumber()">Generate Code</button> -->
                                </div>
                            </div>



                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">

                                    <label for="vendor">Vendor:</label>
                                    <p id="vendor"></p>


                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="date">Order Date:</label>
                                    <p id="order_date"></p>
                                </div>
                            </div>


                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="date">Expected Date of delivery:</label>
                                    <p id="expected_delivery_date"></p>

                                </div>
                            </div>



                        </div>

                        <!-- New  -->
                        <div class="form-group-item">
                            <label for="products">Products:</label>
                            <table class="table table-bordered" id="product-table">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Product --- Model</th>
                                        <th>Is Received</th>
                                        <th>Received Date</th>
                                        <th>Serial Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="product-rows"></tbody>
                            </table>

                        </div>




                        <!-- Old -->
                        <!-- <div class="form-group-item">
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
                                    <tr class="product-row purchase-order-action">
                                        <td class="serial-number">1</td>
                                        <td><span class="form-control" name="product_name[]"></span></td>
                                        <td><input type="number" class="form-control stock" name="quantity[]" required>
                                        </td>
                                        <td><input type="number" step="0.01" class="form-control unit-cost"
                                                name="unit_cost[]" required></td>
                                        <td>
                                            saa
                                        </td>

                                    </tr>
                                </tbody>
                            </table>


                        </div> -->

                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="total_cost">Total Cost:</label>
                                    <p id="total_cost"></p>
                                    <!-- <input type="number" step="0.01" class="form-control" id="total_cost" name="total_cost" readonly> -->
                                </div>
                            </div>

                            <div class="col-lg-8 col-md-6 col-sm-12">
                                <div class="input-block mb-3">
                                    <label for="notes">Notes:</label>
                                    <p id="notes"></p>
                                </div>
                            </div>



                        </div>
                        <!-- 'Pending','Approved','Fulfilled','Cancelled','Deleted' -->
                        <div class="text-end">
                            <a href="./purchase-orders.php" class="btn btn-primary cancel me-2"> Cancel </a>
                            <a href="./pdf/generate-receipt.php?purchase-order=<?php echo $purchase_order; ?>"
                                class="btn btn-primary"> Make Receipt </a>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<script src="./assets/js/helper/purchase-order.js"></script>


<?php include('./footer.php'); ?>