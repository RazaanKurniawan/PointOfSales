<?php
require_once('vendor/autoload_.php'); // Sesuaikan path dengan kebutuhan Anda

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

// Set kredensial Midtrans
Config::$serverKey = 'SB-Mid-server-m45d0AqjVWgNo_jhPp1LJnkl';
Config::$isProduction = false;
Config::$isSanitized = true;
Config::$is3ds = true;

// Ambil data dari formulir pembayaran
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$amount = $_POST['amount'];

var_dump($_POST);
// Generate ID transaksi unik
$transaction_id = uniqid();

// Konfigurasi item pembelian (bisa disesuaikan dengan kebutuhan Anda)
$items = [
    [
        'id' => 'item1',
        'price' => 31212313321,
        'quantity' => 1,
        'name' => 'Dummy Item',
        'brand' => 'Dummy Brand',
        'category' => 'Dummy Category',
        'merchant_name' => 'Dummy Merchant'
    ]
];

// Buat payload untuk request pembayaran
$transaction_details = [
    'order_id' => rand(),
    'gross_amount' => 1000000,
];

$customer_details = [
    'first_name' => 'rangga bayu',
    'email' => 'fsdifsopdif@gmail.com',
    'phone' => 1239142784130,
];

$transaction_data = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $items,
);

// Buat transaksi Snap
$snapToken = Snap::getSnapToken($transaction_data);

// Kembalikan token untuk pembayaran ke frontend
echo json_encode(['token' => $snapToken]);
