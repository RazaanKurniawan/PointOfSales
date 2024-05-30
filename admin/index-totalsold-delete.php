<?php
require '../config/function.php';

if (!isset($_SESSION['loggedInUser'])) {
    redirect('../login.php', 'Login terlebih dahulu!');
    exit();
}


if ($_SESSION['loggedInUser']['level'] == 'Admin') {
    if (isset($_GET['id'])) {

        $productId = $_GET['id'];

        $deleteQuery = mysqli_query($conn, "DELETE FROM order_items WHERE product_id = $productId");

        if ($deleteQuery) {
            redirect('index.php', 'Produk berhasil dihapus!');
        }
    } else {
        redirect('index.php', 'ID Tidak ditemukan!');
    }
} else {
    redirect('index.php', 'Kamu bukan admin!');
}
?>
