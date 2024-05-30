<?php
require '../config/function.php';

if (!isset($_SESSION['loggedInUser'])) {
    redirect('../login.php', 'Login terlebih dahulu!');
    exit();
}

if ($_SESSION['loggedInUser']['level'] == 'Admin') {
    if (isset($_GET['track']) && !empty($_GET['track'])) {

        $tracking_no = $_GET['track'];

        $query = "DELETE FROM orders WHERE tracking_no = '$tracking_no'";

        $result = mysqli_query($conn, $query);

        // Periksa apakah penghapusan berhasil
        if ($result) {
            redirect('orders.php', 'Pesanan berhasil dihapus');
        } else {
            redirect('orders.php', 'Gagal menghapus pesanan');
        }
    } else {
        redirect('orders.php', 'Nomor tracking tidak valid');
    }
}
?>