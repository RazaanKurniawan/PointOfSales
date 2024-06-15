<?php
include ('../config/function.php');

if (isset($_POST['productCode'])) {
    $productCode = mysqli_real_escape_string($conn, $_POST['productCode']);
    $query = "SELECT name, price, image FROM products WHERE product_code = '$productCode'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'data' => $product]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>

