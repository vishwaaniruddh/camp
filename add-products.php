<?php include('./header.php'); ?>

<div class="content container-fluid">
    <div class="card mb-0">
        <div class="card-body">
            <div class="page-header">
                <div class="content-page-header">
                    <h5>Add Products / Services</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form id="addProductForm" enctype="multipart/form-data">
                        <div class="form-group-item">
                            <h5 class="form-title">Basic Details</h5>
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Product Name <span class="text-danger"> *</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Product Name" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3 add-products">
                                        <label>Product Code (SKU)<span class="text-danger"> *</span></label>
                                        <input type="text" class="form-control" name="sku" placeholder="Enter Product Code" required>
                                        <button type="button" class="btn btn-primary" onclick="generateSKU()">Generate Code</button>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Category <span class="text-danger"> *</span></label>
                                        <select class="form-select" name="category" id="category" required>
                                            <!-- Options will be populated by JavaScript -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Purchase Price <span class="text-danger"> *</span></label>
                                        <input type="number" class="form-control" name="purchase_price" placeholder="Enter Purchase Price" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Quantity <span class="text-danger"> *</span></label>
                                        <input type="number" class="form-control" name="quantity" placeholder="Enter Quantity" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Units</label>
                                        <select class="form-select" name="units" id="units">
                                            <!-- Options will be populated by JavaScript -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3 add-products">
                                        <label>Generate Barcode</label>
                                        <input type="text" class="form-control" name="barcode" placeholder="Enter Barcode Code">
                                        <button type="button" class="btn btn-primary" onclick="generateBarcode()">Generate Code</button>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="input-block mb-3">
                                        <label>Alert Quantity</label>
                                        <input type="number" class="form-control" name="alert_quantity" placeholder="Enter Alert Quantity">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-item">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 description-box">
                                    <div class="input-block mb-3" id="summernote_container">
                                        <label class="form-control-label">Product Descriptions</label>
                                        <textarea class="summernote form-control" name="description" placeholder="Type your message"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                    <div class="input-block mb-3">
                                        <label>Product Image</label>
                                        <div class="input-block mb-3 service-upload mb-0">
                                            <span><img src="assets/img/icons/drop-icon.svg" alt="upload"></span>
                                            <h6 class="drop-browse align-center">
                                                Drop your files here or<span class="text-primary ms-1">browse</span>
                                            </h6>
                                            <p class="text-muted">Maximum size: 50MB</p>
                                            <input type="file" name="image" id="image_sign">
                                            <div id="frames"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="reset" class="btn btn-primary cancel me-2">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="./assets/js/helper/add-product.js"></script>

<?php include('./footer.php'); ?>