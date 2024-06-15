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
    $money = validate($_POST['money']);
    $payment_mode = validate($_POST['payment_mode']);

    // Pastikan bahwa jumlah uang dan mode pembayaran ada
        $_SESSION['invoice_no'] = "INV-" . rand(111111, 999999);
        $_SESSION['money'] = $money;
        $_SESSION['payment_mode'] = $payment_mode;
        jsonResponse(200, 'success', 'Proses berhasil!');
}


//   Tutor 16
if (isset($_POST['saveCustomerBtn'])) {

    $name = validate($_POST['name']);
    $class = validate($_POST['class']);
    // $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);

    if ($name !== '' && $phone !== '') {

        $data = [
            'name' => $name,
            'class' => $class,
            // 'phone' => $phone,
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
    $invoice_No = validate($_SESSION['invoice_no']);
    $payment_mode = validate($_SESSION['payment_mode']);
    $money = $_SESSION['money'];
    $order_placed_by_id = $_SESSION['loggedInUser']['user_id'];
    $snapToken = $_SESSION['snapToken'];

    // Periksa apakah ada item produk yang akan dipesan
    if (!isset($_SESSION['productItems']) || empty($_SESSION['productItems'])) {
        jsonResponse(404, 'warning', 'Tidak ada barang untuk dipesan!');
    }

    $sessionProducts = $_SESSION['productItems'];

    // Hitung total jumlah pesanan
    $totalAmount = 0;
    foreach ($sessionProducts as $amItem) {
        $totalAmount += $amItem['price'] * $amItem['quantity'];
    }

    date_default_timezone_set('Asia/Jakarta');

    if ($payment_mode == "Bayar Online") {
        $money = $totalAmount;
    }

    // Data untuk disimpan
    $data = [
        'money' => $money,
        'tracking_no' => rand(11111, 99999),
        'invoice_no' => $invoice_No,
        'total_amount' => $totalAmount,
        'order_date' => date('Y-m-d'),
        'order_status' => 'Dipesan',
        'payment_mode' => $payment_mode,
        'order_placed_by_id' => $order_placed_by_id,
        'snapToken' => $snapToken
    ];

    // Simpan pesanan
    $result = insert('orders', $data);
    $lastOrderId = mysqli_insert_id($conn);

    // Simpan detail pesanan
    foreach ($sessionProducts as $prodItem) {
        $productId = $prodItem['product_id'];
        $price = $prodItem['price'];
        $quantity = $prodItem['quantity'];

        // Data untuk item pesanan
        $dataOrderItem = [
            'order_id' => $lastOrderId,
            'product_id' => $productId,
            'price' => $price,
            'quantity' => $quantity,
        ];

        // Simpan item pesanan
        $orderItemQuery = insert('order_items', $dataOrderItem);

        // Kurangi jumlah produk yang tersedia di inventaris
        $checkProductQuantityQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$productId'");
        $productQtyData = mysqli_fetch_assoc($checkProductQuantityQuery);
        $totalProductQuantity = $productQtyData['quantity'] - $quantity;

        // Perbarui jumlah produk di inventaris
        $dataUpdate = [
            'quantity' => $totalProductQuantity
        ];
        $updateProductQty = update('products', $productId, $dataUpdate);
    }

    // Bersihkan sesi setelah pesanan berhasil
    unset($_SESSION['productItemIds']);
    unset($_SESSION['productItems']);
    unset($_SESSION['money']);
    unset($_SESSION['payment_mode']);
    unset($_SESSION['invoice_no']);

    // Berikan respons berhasil
    if ($lastOrderId) {
        jsonResponse(200, 'success', 'Pesanan berhasil ditempatkan');
    } else {
        jsonResponse(500, 'error', 'Ada sesuatu yang salah saat menyimpan pesanan');
    }
}





