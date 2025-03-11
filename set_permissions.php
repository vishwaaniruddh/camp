<?php include('./header.php'); ?>

<div class="content container-fluid">

    <div class="card mb-0">
        <div class="card-body">
            <!-- Page Header -->
            <div class="page-header">
                <div class="content-page-header ">
                    <h5>Step 3: Set User Permissions</h5>
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


                        <form>
                            <div class="card-table">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-stripped table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Modules</th>
                                                    <th>Sub Modules</th>
                                                    <th>Create</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                    <th>View</th>
                                                    <th>Allow All</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="role-data">Dashboard</td>
                                                    <td>Main</td>
                                                    <td><input type="checkbox"></td>
                                                    <td><input type="checkbox"></td>
                                                    <td><input type="checkbox"></td>
                                                    <td><input type="checkbox"></td>
                                                    <td><input type="checkbox"></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td class="role-data">Reports</td>
                                                    <td>Performance</td>
                                                    <td><input type="checkbox"></td>
                                                    <td><input type="checkbox"></td>
                                                    <td><input type="checkbox"></td>
                                                    <td><input type="checkbox"></td>
                                                    <td><input type="checkbox"></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div>

                            <!-- <button type="submit" class="btn btn-success">Save Permissions</button> -->
                            <div class="btn-center my-4">
						<button type="submit" class="btn btn-primary cancel me-2">Back</button>
						<button type="submit" class="btn btn-primary">Save Permissions</button>
					</div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Table -->
        </div>
    </div>


</div>


<script>
    document.getElementById("userForm").addEventListener("submit", function (event) {
        event.preventDefault();
        alertify.success("User Created! Redirecting to Permissions...");
        window.location.href = "assign_permissions.html"; // Redirect to Step 2
    });
</script>



<script src="./assets/js/helper/users_new.js"></script>
<?php include('./footer.php'); ?>