<?php
include('../config.php');

header('Content-Type: application/json');

function get_material($id)
{
    global $con;
    $sql = mysqli_query($con, "SELECT * FROM material WHERE id='" . $id . "'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['material'];
}

function mis_details_data($parameter, $id)
{
    global $con;
    $sql = mysqli_query($con, "SELECT $parameter FROM mis_details WHERE id='" . $id . "'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result[$parameter];
}

function mis_history_data($parameter, $id)
{
    global $con;
    $sql = mysqli_query($con, "SELECT $parameter FROM mis_history WHERE mis_id='" . $id . "' AND $parameter IS NOT NULL AND $parameter <> '' ORDER BY id DESC");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result[$parameter];
}

$response = [];
$view = 0;

// Get pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$offset = ($page - 1) * $limit;

if (isset($_REQUEST['status'])) {
    $_status = $_REQUEST['status'];
    if ($_status == 1) {
        $baseQuery = "SELECT * FROM `material_inventory` WHERE status='" . $_status . "' AND material_inventory.mis_id IN (SELECT mis_details.id FROM mis_details, mis WHERE mis.id = mis_details.mis_id AND mis_details.status='material_requirement')";
    } else {
        $baseQuery = "SELECT * FROM material_inventory WHERE status='" . $_status . "' GROUP BY mis_id";
    }
    $view = 1;
} else {
    $baseQuery = "";
}

if ($view == 1) {
    // Get total count for pagination
    $totalQuery = "SELECT COUNT(*) as total FROM ($baseQuery) as total_table";
    $totalResult = mysqli_query($con, $totalQuery);
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalPages = ceil($totalRow['total'] / $limit);

    // Add pagination to the query
    $query = $baseQuery . " ORDER BY id DESC LIMIT $limit OFFSET $offset";

    // Execute the query
    $sql = mysqli_query($con, $query);

    if (mysqli_num_rows($sql) > 0) {
        $i = 1;
        while ($sql_result = mysqli_fetch_assoc($sql)) {
            $id = $sql_result['id'];
            $mis_id = $sql_result['mis_id'];

            $misdetail_sql = mysqli_query($con, "SELECT * FROM mis_details WHERE id='" . $mis_id . "'");
            $count = mysqli_num_rows($misdetail_sql);
            $misdetail_sql_result = mysqli_fetch_assoc($misdetail_sql);
            $main_mis = $misdetail_sql_result['mis_id'];

            $current_status = $misdetail_sql_result['status'];

            $mis_sql = mysqli_query($con, "SELECT * FROM mis WHERE id='" . $main_mis . "'");
            $mis_sql_result = mysqli_fetch_assoc($mis_sql);
            $location = $mis_sql_result['location'];
            $state = $mis_sql_result['state'];
            $zone = $mis_sql_result['zone'];
            $city = $mis_sql_result['city'];
            $customer = $mis_sql_result['customer'];
            $bank = $mis_sql_result['bank'];
            $_atmid = $mis_sql_result['atmid'];
            $bm_sql = mysqli_query($con, "SELECT bm FROM atm_info WHERE atmid LIKE '" . $_atmid . "'");
            $bm_sql_result = mysqli_fetch_assoc($bm_sql);
            $bm = $bm_sql_result['bm'];

            $mis_history = mysqli_query($con, "SELECT material_condition, created_by FROM mis_history WHERE mis_id='" . $mis_id . "' AND type='" . $current_status . "'");
            $mis_his_count = mysqli_num_rows($mis_history);
            $user_created_by = "";
            if ($mis_his_count > 0) {
                $mis_his_sql_result = mysqli_fetch_assoc($mis_history);
                $created_by_id = $mis_his_sql_result['created_by'];
                if ($created_by_id > 0) {
                    $mis_created_by_sql = mysqli_query($con, "SELECT name FROM mis_loginusers WHERE id='" . $created_by_id . "'");
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
                $response[] = [
                    'id' => $i,
                    'mis_id' => $sql_result['mis_id'],
                    'ticket_id' => mis_details_data('ticket_id', $sql_result['mis_id']),
                    'customer' => $customer,
                    'bank' => $bank,
                    'atmid' => mis_details_data('atmid', $sql_result['mis_id']),
                    'bm' => $bm,
                    'material_condition' => $material_condition,
                    'material' => $sql_result['material'],
                    'delivery_address' => mis_history_data('delivery_address', $sql_result['mis_id']),
                    'contact_person_name' => mis_history_data('contact_person_name', $sql_result['mis_id']),
                    'contact_person_mob' => mis_history_data('contact_person_mob', $sql_result['mis_id']),
                    'remark' => mis_history_data('remark', $sql_result['mis_id']),
                    'created_at' => $sql_result['created_at'],
                    'location' => $location,
                    'city' => $city,
                    'state' => $state,
                    'zone' => $zone,
                    'user_created_by' => $user_created_by
                ];
                $i++;
            }
        }
    }
}

echo json_encode([
    'success' => true,
    'totalRecords'=>$totalRow['total'],
    'data' => $response,
    'pagination' => [
        'total_pages' => $totalPages,
        'current_page' => $page
    ]
]);

mysqli_close($con);
?>