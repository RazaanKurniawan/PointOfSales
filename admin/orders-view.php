<?php include ('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0 text-center">Lampiran Pesanan
                <a href="orders-view-print.php?track=<?= $_GET['track'] ?>"
                    class="btn btn-info mx-2 btn-sm float-end"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
                <a href="orders.php" class="btn btn-danger mx-2 btn-sm float-end"><i class="fa fa-chevron-left"
                        aria-hidden="true"></i> Kembali</a>
            </h4>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>
            <?php
            if (isset($_GET['track'])) {

                if ($_GET['track'] == '') {
                    ?>
                    <div class="text-center py-5">
                        <h5>Nomor Tracking Tidak Ditemukan!</h5>
                        <div>
                            <a href="orders.php" class="btn btn-primary mt-4 w-25"><i class="fa fa-chevron-left"
                                    aria-hidden="true"></i> Kembali ke halaman pesanan</a>
                        </div>
                    </div>
                    <?php
                    return false;
                }

                $trackingNo = validate($_GET['track']);

                // Query untuk mengambil data dari tabel orders
                $query = "SELECT * FROM orders WHERE tracking_no = '$trackingNo' ORDER BY id DESC";

                $orders = mysqli_query($conn, $query);
                if ($orders && mysqli_num_rows($orders) > 0) {
                    $orderData = mysqli_fetch_assoc($orders);
                    $orderId = $orderData['id'];
                    ?>
                    <div class="card card-body shadow border-1 mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Detail Pesanan</h4>
                                <label class="mb-1">
                                    Nomor Invoice:
                                    <span class="fw-bold"><?= $orderData['invoice_no']; ?></span>
                                </label>
                                <br>
                                <label class="mb-1">
                                    Nomor Tracking:
                                    <span class="fw-bold"><?= $orderData['tracking_no']; ?></span>
                                </label>
                                <br>
                                <label class="mb-1">
                                    Tanggal Pesanan:
                                    <span class="fw-bold"><?= $orderData['order_date']; ?></span>
                                </label>
                                <br>
                                <label class="mb-1">
                                    Status Pesanan:
                                    <span class="fw-bold"><?= $orderData['order_status']; ?></span>
                                </label>
                                <br>
                                <label class="mb-1">
                                    Metode Pembayaran:
                                    <span class="fw-bold"><?= $orderData['payment_mode']; ?></span>
                                </label>
                                <br>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Query untuk mengambil data item pesanan
                    $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.*, o.money as orderMoney, o.total_amount as totalAmount 
                                           FROM orders o 
                                           JOIN order_items oi ON oi.order_id = o.id 
                                           JOIN products p ON p.id = oi.product_id 
                                           WHERE o.tracking_no = '$trackingNo'";

                    $orderItemsRes = mysqli_query($conn, $orderItemQuery);
                    if ($orderItemsRes && mysqli_num_rows($orderItemsRes) > 0) {
                        ?>
                        <h4>Detail Barang Pesanan</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Gambar Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderItemsRes as $orderItemRow): ?>
                                        <tr>
                                            <td><img src="<?= $orderItemRow['image'] != '' ? '../' . $orderItemRow['image'] : '/assets/images/no-img.jpg'; ?>"
                                                    style="max-width: 100px; max-height: 100px;" alt="Img"></td>
                                            <td><?= $orderItemRow['name']; ?></td>
                                            <td class=" text-center">Rp.
                                                <?= number_format($orderItemRow['orderItemPrice'], 0, ',', '.'); ?>
                                            </td>
                                            <td class=" text-center"><?= $orderItemRow['orderItemQuantity']; ?> Pcs</td>
                                            <td class=" text-center">Rp.
                                                <?= number_format($orderItemRow['orderItemPrice'] * $orderItemRow['orderItemQuantity'], 0, ',', '.'); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Total Price:</td>
                                        <td class="text-end fw-bold">Rp.
                                            <?= number_format($orderData['total_amount'], 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Tunai:</td>
                                        <td class="text-end fw-bold">
                                            Rp.
                                            <?php
                                            if ($orderData['payment_mode'] == "Bayar Online") {
                                                echo number_format($orderData['total_amount'], 0, ',', '.');
                                            } else if ($orderData['payment_mode'] == "Uang Tunai") {
                                                echo number_format($orderData['money'], 0, ',', '.');
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Kembalian:</td>
                                        <td class="text-end fw-bold">
                                            Rp.
                                            <?php
                                            if ($orderData['payment_mode'] == "Bayar Online") {
                                                echo "0";
                                            } else if ($orderData['payment_mode'] == "Uang Tunai") {
                                                echo number_format($orderData['money'] - $orderData['total_amount'], 0, ',', '.');
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <?php
                    } else {
                        echo '<h5>No Items Found!</h5>';
                    }
                } else {
                    echo '<h5>No Records Found!</h5>';
                }
            } else {
                ?>
                <div class="text-center py-5">
                    <h5>No Tracking Number Found</h5>
                    <div>
                        <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<?php include ('includes/footer.php'); ?>