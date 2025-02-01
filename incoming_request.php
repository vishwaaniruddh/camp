<?php include('./header.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

function get_material($id)
{
    global $con;

    $sql = mysqli_query($con, "Select * from material where id='" . $id . "'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['material'];
}

function mis_details_data($parameter, $id)
{
    global $con;

    $sql = mysqli_query($con, "select $parameter from mis_details where id='" . $id . "'");
    $sql_result = mysqli_fetch_assoc($sql);

    return $sql_result[$parameter];
}

function mis_history_data($parameter, $id)
{
    global $con;
    // echo "select $parameter from mis_history where mis_id='".$id."' and $parameter is not null and $parameter <> '' order by id desc" ; 
    $sql = mysqli_query($con, "select $parameter from mis_history where mis_id='" . $id . "' and $parameter is not null and $parameter <> '' order by id desc");
    $sql_result = mysqli_fetch_assoc($sql);

    return $sql_result[$parameter];
}


?>


<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="content-page-header">
            <h5>Incoming Request </h5>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-sm-12">


            <div class="container-fluid">
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-9">

                                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                    <div class="col-md-6">
                                        <select id="status" class="form-control" name="status">
                                            <option value="1" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '1') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Material Requirement</option>
                                            <option value="5" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '5') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Confirm Processed</option>
                                            <option value="2" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '2') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Available</option>

                                            <option value="0" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '0') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Cancelled</option>
                                            <option value="3" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '3') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Not Available</option>
                                            <option value="4" <? if (isset($_REQUEST['status'])) {
                                                                    if ($_REQUEST['status'] == '4') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>Dispatched</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="submit" value="Search">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Actions</th>
                                                <th>Ticket ID</th>
                                                <th>Customer</th>
                                                <th>Bank</th>
                                                <th>ATM ID</th>
                                                <th>CTS BM</th>
                                                <th>Material Condition</th>
                                                <th>Require Material Name</th>
                                                <th>Dispatch Address</th>
                                                <th>Contact Person Name</th>
                                                <th>Contact Person Mobile</th>
                                                <th>Remark</th>
                                                <th>Created Date</th>
                                                <th>Location</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Zone</th>
                                                <th>MIS ID</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? $view = 0;
                                            if (isset($_REQUEST['status'])) {
                                                $_status = $_REQUEST['status'];
                                                //  SELECT * FROM `material_inventory` WHERE status=1 and mis_id IN (select mis_id from mis_details)
                                                if ($_status == 1) {
                                                    $query = "SELECT * FROM `material_inventory` WHERE status='" . $_status . "' AND material_inventory.mis_id IN (select mis_details.id from mis_details, mis WHERE mis.id = mis_details.mis_id and mis_details.status='material_requirement') order by id desc";
                                                } else {
                                                    $query = "select * from material_inventory where status='" . $_status . "' group by mis_id order by id desc";
                                                }

                                                $view = 1;
                                            } else {
                                                // $query = "select * from material_inventory where status=2 order by id desc";
                                                $query = "";
                                            }

                                            // echo $query ; 
                                            if ($view == 1) {
                                                $i = 1;
                                                $sql = mysqli_query($con, $query);

                                                // echo mysqli_num_rows($sql);
                                                if (mysqli_num_rows($sql) > 0) {
                                                    while ($sql_result = mysqli_fetch_assoc($sql)) {
                                                        $id = $sql_result['id'];
                                                        $mis_id = $sql_result['mis_id'];

                                                        $misdetail_sql = mysqli_query($con, "select * from mis_details where id='" . $mis_id . "'");
                                                        $count = mysqli_num_rows($misdetail_sql);
                                                        $misdetail_sql_result = mysqli_fetch_assoc($misdetail_sql);
                                                        $main_mis = $misdetail_sql_result['mis_id'];

                                                        $current_status = $misdetail_sql_result['status'];

                                                        $mis_sql = mysqli_query($con, "select * from mis where id='" . $main_mis . "'");
                                                        $mis_sql_result = mysqli_fetch_assoc($mis_sql);
                                                        $location = $mis_sql_result['location'];
                                                        $state = $mis_sql_result['state'];
                                                        $zone = $mis_sql_result['zone'];
                                                        $city = $mis_sql_result['city'];
                                                        $customer = $mis_sql_result['customer'];
                                                        $bank = $mis_sql_result['bank'];
                                                        $_atmid = $mis_sql_result['atmid'];
                                                        // $_atmid = mis_details_data('atmid',$sql_result['mis_id']);
                                                        $bm_sql = mysqli_query($con, "select bm from atm_info where atmid like '" . $_atmid . "'");
                                                        $bm_sql_result = mysqli_fetch_assoc($bm_sql);
                                                        $bm = $bm_sql_result['bm'];

                                                        $mis_history = mysqli_query($con, "select material_condition,created_by from mis_history where mis_id='" . $mis_id . "' AND type='" . $current_status . "'");
                                                        $mis_his_count = mysqli_num_rows($mis_history);
                                                        $user_created_by = "";
                                                        if ($mis_his_count > 0) {
                                                            $mis_his_sql_result = mysqli_fetch_assoc($mis_history);
                                                            $created_by_id = $mis_his_sql_result['created_by'];
                                                            if ($created_by_id > 0) {
                                                                $mis_created_by_sql = mysqli_query($con, "select name from mis_loginusers where id='" . $created_by_id . "'");
                                                                $mis_created_by_count = mysqli_num_rows($mis_created_by_sql);
                                                                if ($mis_created_by_count > 0) {
                                                                    $mis_user_sql_result = mysqli_fetch_assoc($mis_created_by_sql);
                                                                    $user_created_by = $mis_user_sql_result['name'];
                                                                }
                                                            }

                                                            $material_condition = $mis_his_sql_result['material_condition'];
                                                            $contact_person_name = $mis_his_sql_result['contact_person_name'];
                                                        }

                                                        if ($count > 0) {
                                            ?>
                                                            <tr>
                                                                <td><? echo $i; ?></td>
                                                                <td>
                                                                    <a target="_blank" class="btn btn-info" href="material_update.php?id=<? echo $sql_result['mis_id']; ?>">View</a>
                                                                    <?php if ($sql_result['status'] == 1) { ?>
                                                                        <a data-id="<? echo $sql_result['mis_id']; ?>" class="open-Accept btn btn-success">Accept</a>
                                                                    <?php } ?>
                                                                    <?php if ($sql_result['status'] == 1 || $sql_result['status'] == 2) { ?>
                                                                        <!--<a data-toggle="modal" data-id="<? echo $id; ?>" class="open-DetailDialog btn btn-danger" href="#myModal">Cancel</a>    -->
                                                                    <?php }
                                                                    if ($sql_result['status'] == 2) { ?>
                                                                        <a data-toggle="modal" data-misid="<? echo $mis_id; ?>" data-id="<? echo $id; ?>" class="open-DetailPOD-Dialog btn btn-success" href="#myPODModal">POD</a>
                                                                    <?php } ?>
                                                                </td>

                                                                <td><? echo mis_details_data('ticket_id', $sql_result['mis_id']); ?></td>
                                                                <td><? echo $customer; ?></td>
                                                                <td><? echo $bank; ?></td>
                                                                <td><? echo mis_details_data('atmid', $sql_result['mis_id']); ?></td>
                                                                <td><? echo $bm; ?></td>
                                                                <td><? echo $material_condition; ?></td>
                                                                <td><? echo $sql_result['material']; ?><? // echo get_material($sql_result['material']);
                                                                                                        ?></td> <? //echo mis_history_data('material',$mis_id);
                                                                                                                                                                ?>
                                                                <td><? echo mis_history_data('delivery_address', $sql_result['mis_id']); ?></td>
                                                                <td><? echo mis_history_data('contact_person_name', $sql_result['mis_id']); ?></td>
                                                                <td><? echo mis_history_data('contact_person_mob', $sql_result['mis_id']); ?></td>

                                                                <td><? echo mis_history_data('remark', $sql_result['mis_id']); ?></td>
                                                                <td><? echo $sql_result['created_at']; ?></td>
                                                                <td><? echo $location; ?></td>
                                                                <td><? echo $city; ?></td>
                                                                <td><? echo $state; ?></td>
                                                                <td><? echo $zone; ?></td>
                                                                <!-- <td>
                                            <tr>
                                            <td><a target="_blank" class="btn btn-info" href="material_update.php?id=<? echo $sql_result['mis_id']; ?>">View</a></td>
                                            <?php if ($sql_result['status'] == 1 || $sql_result['status'] == 2) { ?>
                                            <td><a data-toggle="modal" data-id="<? echo $id; ?>" class="open-DetailDialog btn btn-danger" href="#myModal">Cancel</a></td>    
                                            <?php }
                                                            if ($sql_result['status'] == 2) { ?>
                                            <td><a data-toggle="modal" data-misid="<? echo $mis_id; ?>" data-id="<? echo $id; ?>" class="open-DetailPOD-Dialog btn btn-success" href="#myPODModal">POD</a></td>    
                                            <?php } ?>
                                            </tr> 
                                        </td> -->
                                                                <td><? echo $sql_result['mis_id']; ?></td>
                                                                <td><? echo $user_created_by; ?></td>
                                                            </tr>
                                            <? $i++;
                                                        }
                                                    }
                                                }
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>

</div>

<?php include('./footer.php');
