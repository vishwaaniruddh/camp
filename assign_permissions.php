<?php include('./header.php'); ?>

<style>
    .grid-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 columns */
    gap: 10px; /* Spacing between checkboxes */
}

.grid-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

input[type="checkbox"] {
    margin-right: 5px;
}

</style>
<div class="content container-fluid">

    <div class="card mb-0">
        <div class="card-body">
            <!-- Page Header -->
            <div class="page-header">
                <div class="content-page-header">
                    <h5>Step 2: Assign User Permissions</h5>
                </div>
            </div>
            <!-- /Page Header -->

            <!-- Master Selection -->
            <div class="mb-3 input-block">
                <label class="form-label"><strong>Select All</strong></label>
                <input type="checkbox" id="selectAllPermissions">
                <label for="selectAllPermissions">Check All (Customers, Banks & Zones)</label>
            </div>

            <!-- Customers Selection -->
            <div class="mb-3  input-block">
                <label class="form-label"><strong>Select Customers</strong></label>
                <input type="checkbox" id="selectAllCustomers">
                <label for="selectAllCustomers">Check All Customers</label>
                <div id="multiselect_customers" class="grid-container"></div>
            </div>

            <!-- Banks Selection -->
            <div class="mb-3 input-block">
                <label class="form-label"><strong>Select Banks</strong></label>
                <input type="checkbox" id="selectAllBanks">
                <label for="selectAllBanks">Check All Banks</label>
                <div id="multiselect_banks" class="grid-container"></div>
            </div>

            <!-- Zones Selection -->
            <h5 class="mt-4  input-block"><strong>Select Zones</strong></h5>
            <input type="checkbox" id="selectAllZones">
            <label for="selectAllZones">Check All Zones</label>
            <table id="zonesTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Zone Name</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" name="zones[]" value="north"> North Zone</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="zones[]" value="south"> South Zone</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" name="zones[]" value="east"> East Zone</td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Next: Set Permissions</button>

        </div>
    </div>
</div>

<script src="./assets/js/helper/users_new.js"></script>
<?php include('./footer.php'); ?>
