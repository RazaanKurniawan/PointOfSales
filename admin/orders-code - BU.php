<?php

include ('../config/function.php');

if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}
if (!isset($_SESSION['productItemIds'])) {
    $_SESSION['productItemIds'] = [];
}

if (isset($_POST['addItem'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId' LIMIT 1");
    if ($checkProduct) {
        if (mysqli_num_rows($checkProduct) > 0) {

            $row = mysqli_fetch_assoc($checkProduct);
            if ($row['quantity'] < $quantity) {
                redirect('orders-create.php', 'Hanya ' . $row['quantity'] . ' barang tersisa');
            }

            $productData = [
                'product_id' => $row['id'],
                'name' => $row['name'],
                'image' => $row['image'],
                'price' => $row['price'],
                'quantity' => $quantity,
            ];

            if (!in_array($row['id'], $_SESSION['productItemIds'])) {

                array_push($_SESSION['productItemIds'], $row['id']);
                array_push($_SESSION['productItems'], $productData);

            } else {

                foreach ($_SESSION['productItems'] as $key => $prodSessionItem) {
                    if ($prodSessionItem['product_id'] == $row['id']) {

                        $newQuantity = $prodSessionItem['quantity'] + $quantity;

                        $productData = [
                            'product_id' => $row['id'],
                            'name' => $row['name'],
                            'image' => $row['image'],
                            'price' => $row['price'],
                            'quantity' => $newQuantity,
                        ];
                        $_SESSION['productItems'][$key] = $productData;
                    }
                }

            }
            redirect('orders-create.php', 'Item Ditambah ' . $row['name']);
        } else {

            redirect('orders-create.php', 'Produk tidak ditemukan!');
        }
    } else {
        redirect('orders-create.php', 'Ada sesuatu yang salah!');
    }
}

if (isset($_POST['product_code'])) {
    $product_code = validate($_POST['product_code']);
    $quantity = validate($_POST['quantity']);

    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE product_code='$product_code' LIMIT 1");
    if ($checkProduct) {
        if (mysqli_num_rows($checkProduct) > 0) {

            $row = mysqli_fetch_assoc($checkProduct);
            if ($row['quantity'] < $quantity) {
                redirect('orders-create.php', 'Hanya ' . $row['quantity'] . ' barang tersisa');
            }

            $productData = [
                'product_id' => $row['id'],
                'name' => $row['name'],
                'image' => $row['image'],
                'price' => $row['price'],
                'quantity' => $quantity,
            ];

            if (!in_array($row['id'], $_SESSION['productItemIds'])) {

                array_push($_SESSION['productItemIds'], $row['id']);
                array_push($_SESSION['productItems'], $productData);

            } else {

                foreach ($_SESSION['productItems'] as $key => $prodSessionItem) {
                    if ($prodSessionItem['product_id'] == $row['id']) {

                        $newQuantity = $prodSessionItem['quantity'] + $quantity;

                        $productData = [
                            'product_id' => $row['id'],
                            'name' => $row['name'],
                            'image' => $row['image'],
                            'price' => $row['price'],
                            'quantity' => $newQuantity,
                        ];
                        $_SESSION['productItems'][$key] = $productData;
                    }
                }

            }
            redirect('orders-create.php', 'Item Ditambah ' . $row['name']);
        } else {

            redirect('orders-create.php', 'Produk tidak ditemukan!');
        }
    } else {
        redirect('orders-create.php', 'Ada sesuatu yang salah!');
    }
}

if (isset($_POST['productIncDec'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $flag = false;

    foreach ($_SESSION['productItems'] as $key => $item) {
        if ($item['product_id'] == $productId) {

            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;

        }
    }
    if ($flag) {

        jsonResponse(200, 'success', 'Kuantitas Diupdate!');
    } else {

        jsonResponse(500, 'error', 'Ada sesuatu yang salah!. Coba muat ulang');
    }

}

// Tutor 15

if (isset($_POST['proceedToPlaceBtn'])) {
    $phone = validate($_POST['cphone']);
    $payment_mode = validate($_POST['payment_mode']);

    //Cek untuk pelanggan

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");

    if ($checkCustomer) {
        if (mysqli_num_rows($checkCustomer) > 0) {
            $_SESSION['invoice_no'] = "INV-" . rand(111111, 999999);
            $_SESSION['cphone'] = $phone;
            $_SESSION['payment_mode'] = $payment_mode;
            jsonResponse(200, 'success', 'Pelanggan Ditemukan!');
        } else {
            $_SESSION['cphone'] = $phone;
            jsonResponse(404, 'warning', 'Pelanggan tidak ditemukan!');
        }
    } else {
        jsonResponse(500, 'error', 'Ada sesuatu yang salah!');
    }
}

//   Tutor 16
if (isset($_POST['saveCustomerBtn'])) {

    $name = validate($_POST['name']);
    $class = validate($_POST['class']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);

    if ($name !== '' && $phone !== '') {

        $data = [
            'name' => $name,
            'class' => $class,
            'phone' => $phone,
            'email' => $email
        ];
        $result = insert('customers', $data);
        if ($result) {

            jsonResponse(200, 'success', 'Customer data saved successfully');
        } else {

            jsonResponse(500, 'error', 'Failed to save customer data');
        }
    } else {

        jsonResponse(404, 'warning', 'Please fill all required fields');
    }
}

//  Tutor 17
if (isset($_POST['saveOrder'])) {

    $phone = validate($_SESSION['cphone']);
    $invoice_No = validate($_SESSION['invoice_no']);
    $payment_mode = validate($_SESSION['payment_mode']);
    $order_placed_by_id = $_SESSION['loggedInUser']['user_id'];


    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone'");
    if (!$checkCustomer) {
        jsonResponse(500, 'error', 'Something Went Wrong!');
    }
    if (mysqli_num_rows($checkCustomer) > 0) {

        $customerData = mysqli_fetch_assoc($checkCustomer);

        if (!isset($_SESSION['productItems'])) {
            jsonResponse(404, 'warning', 'No items to place order!');
        }

        $sessionProducts = $_SESSION['productItems'];


        $totalAmount = 0;
        foreach ($sessionProducts as $amItem) {
            $totalAmount += $amItem['price'] * $amItem['quantity'];
        }

        date_default_timezone_set('Asia/Jakarta');

        $data = [
            'customer_id' => $customerData['id'],
            'tracking_no' => rand(11111, 99999),
            'invoice_no' => $invoice_No,
            'total_amount' => $totalAmount,
            'order_date' => date('Y-m-d'),
            'order_status' => 'booked',
            'payment_mode' => $payment_mode,
            'order_placed_by_id' => $order_placed_by_id
        ];

        $result = insert('orders', $data);
        $lastOrderId = mysqli_insert_id($conn);

        foreach ($sessionProducts as $prodItem) {

            $productId = $prodItem['product_id'];
            $price = $prodItem['price'];
            $quantity = $prodItem['quantity'];

            // Memasukan data
            $dataOrderItem = array(
                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity,
            );

            $orderItemQuery = insert('order_items', $dataOrderItem);

            $checkProductQuantityQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId'");
            $productQtyData = mysqli_fetch_assoc($checkProductQuantityQuery);
            $totalProductQuantity = $productQtyData['quantity'] - $quantity;
            
            $dataUpdate = [
                'quantity' => $totalProductQuantity
            ];
            $updateProductQty = update('products', $productId, $dataUpdate);



        }

        unset($_SESSION['productItemIds']);
        unset($_SESSION['productItems']);
        unset($_SESSION['cphone']);
        unset($_SESSION['payment_mode']);
        unset($_SESSION['invoice_no']);
        
        if ($lastOrderId) {
            jsonResponse(200, 'success', 'Order Placed Successfully');
        } else {
            jsonResponse(404, 'warning', 'No Customer Found!');
        }
        

    }
}


