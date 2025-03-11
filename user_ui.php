<?php include('./header.php'); ?>

<div class="content container-fluid">

    <div class="card mb-0">
        <div class="card-body">
            <!-- Page Header -->
            <div class="page-header">
                <div class="content-page-header ">
                    <h5>Step - 1 : Add User Basic Details </h5>
                    <div class="list-btn">
                        <ul class="filter-list">
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->



            <!-- Table -->
            <div class="row">
                <div class="col-sm-12">
                    <div class=" card-table">

                        <form id="userForm">
                            <div class="row">
                                <!-- Full Name -->
                                <div class="col-md-12 mb-3">
                                    <div class="input-block">
                                        <label>Full Name</label>
                                        <input type="text" name="full_name" class="form-control" required>
                                    </div>
                                </div>

                            </div>

                            <div class="row password">

                            </div>

                            <div class="row">

                                <!-- Email -->

                                <div class="col-md-4 mb-3">
                                    <div class="input-block">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-4 mb-3">
                                    <div class="input-block">
                                        <label>Phone</label>
                                        <input type="tel" name="phone" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="col-md-4 mb-3">
                                    <div class="input-block">

                                        <label>Role</label>
                                        <select name="role" class="form-select" required>
                                            <option value="admin">Admin</option>
                                            <option value="service_team">Service Team</option>
                                            <option value="warehouse_team">Warehouse Team</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="input-block">

                                        <label>Bank Name</label>
                                        <input type="text" name="bank_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-block">

                                        <label>Account Number</label>
                                        <input type="text" name="account_number" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="input-block">

                                        <label>IFSC Code</label>
                                        <input type="text" name="ifsc_code" class="form-control">
                                    </div>

                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Save & Assign Permissions</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- /Table -->
        </div>
    </div>


</div>





<script src="./assets/js/helper/users_new.js"></script>
<?php include('./footer.php'); ?>