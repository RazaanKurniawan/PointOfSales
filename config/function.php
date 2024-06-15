<?php
session_start();
require 'dbcon.php';

// 
function validate($inputData) {
    global $conn;
    $validatedData = mysqli_real_escape_string($conn, $inputData);
    return trim($validatedData);
}

// 
function redirect($url, $status) {
    
    $_SESSION['status'] = $status;
    header('Location: ' . $url);
    exit(0);
     
}

// Display Massage
function alertMessage() {

    if (isset($_SESSION['status'])) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">  
        <h6> '.$_SESSION['status'].' </h6>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['status']);
    }
}

 // Add Data
function insert($tableName, $data) {
    
    global $conn;
    
    $table = validate($tableName);
    
    $columns = array_keys($data);
    $values = array_values($data);
    
    $finalColumns = implode(", ", $columns);
    $finalValues = "'" .implode("', '", $values). "'";
    
    $query = "INSERT INTO $table ($finalColumns) VALUES ($finalValues)";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Update
function update($tableName, $id, $data) {
    global $conn;

    $table = validate($tableName);

    $updateDataArray = [];
    foreach ($data as $column => $value) {
        $updateDataArray[] = "$column='$value'";
    }

    $updateDataString = implode(', ', $updateDataArray);

    $id = (int) $id;

    $query = "UPDATE $table SET $updateDataString WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return $result;
}

function getAll($tableName, $status = NULL) {
    
    global $conn;
    
    $table = validate($tableName);
    $status = validate($status);

    if ($status == 'status') 
    {
        $query = "SELECT * FROM $table WHERE status='0'";
    }
    else
    {
        $query = "SELECT * FROM $table";
    }
    return mysqli_query($conn, $query);
}

function getById($tableName, $id) {
    global $conn;
    
    $table = validate($tableName);
    $id = validate($id);
    
    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1 ";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $response = [
                'status' => 200,
                'data' => $row,
                'message' => 'Ketemu!'
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Data tidak ditemukan!'
            ];
        }
    } else {
        $response = [
            'status' => 500,
            'message' => 'Error!'
        ];
    }
    
    return $response;
}
// Delete Data
function delete($tableName, $id) {
    
    global $conn;

    $table = validate($tableName);
    $id = validate($id);
    
    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}

function checkParamId($type){

    if(isset($_GET[$type])){
        if($_GET[$type] != ''){

            return $_GET[$type];
        }else{

            return '<h5>ID Tidak ditemukan!</h5>';
        }

    }else{
        return '<h5>Tidak ada ID yang diberikan!</h5>';
    }

}

function logoutSession(){

    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}

function getCount($tableName)
{
    global $conn;

    $table = validate($tableName);

    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($conn, $query);
    if($query_run){

        $totalCount = mysqli_num_rows($query_run);
        return $totalCount;

    }else{
        return 'Somethin Went Wrong!';
    }
    
}

function getCountAdmin($tableName){
    global $conn;

    $table = validate($tableName);

    $query = "SELECT * FROM $table WHERE level='Admin'";
    $result = mysqli_query($conn, $query);
    if($result){

        $totalCount = mysqli_num_rows($result);
        return $totalCount;
    }else{
        return 'Somethin Went Wrong!';
    }
}

function jsonResponse($status, $status_type, $message){

    $response = [
        'status' => $status,
        'status_type' => $status_type,
        'message' => $message
    ];
    echo json_encode($response);
    return;
}

// function cariProduct($keyword) {

//     global $conn;
//     $keyword = validate($keyword);
//     $query = "SELECT * FROM products WHERE category_id = $keyword";
//     return mysqli_query($conn, $query);

// }

function searchProduct($keyword, $category_id, $stock_status) {
    global $conn;
    $sql = "SELECT * FROM products WHERE 1=1";

    if ($keyword) {
        $sql .= " AND (name LIKE '%$keyword%' OR product_code LIKE '%$keyword%')";
    }

    if ($category_id) {
        $sql .= " AND category_id = '$category_id'";
    }

    if ($stock_status) {
        if ($stock_status == 'tersedia') {
            $sql .= " AND quantity > 0";
        } elseif ($stock_status == 'habis') {
            $sql .= " AND quantity <= 0";
        }
    }

    $result = mysqli_query($conn, $sql);
    return $result;
}


function searchOrderProduct($keyword, $search) {
    global $conn;
    $query = "SELECT * FROM products WHERE 1";

    if ($keyword) {
        $query .= " AND category_id = '$keyword'";
    }

    if ($search) {
        $query .= " AND name LIKE '%$search%'";
    }

    return mysqli_query($conn, $query);
}

// Fungsi pencatatan riwayat login
function logLogin($adminId) {
    
}

// Fungsi pencatatan riwayat logout
function logLogout($adminId) {
    global $conn;
    $query = "UPDATE login_history SET logout_time = NOW() WHERE admin_id = '$adminId' AND logout_time IS NULL ORDER BY login_time DESC LIMIT 1";
    return mysqli_query($conn, $query);
}