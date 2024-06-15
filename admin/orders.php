<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-0 text-center">Pesanan</h4>
                </div>
                <div class="col-md-8">
                    <?php alertMessage() ?>
                    <form action="" method="GET">
                        <div class="row g-1">
                            <div class="col-md-3">
                                <input type="date" name="date" class="form-control"
                                    value="<?= isset($_GET['date']) ? $_GET['date'] : ''; ?>" />
                            </div>
                            <!-- <div class="col-md-3">
                                <input type="text" name="tracking_no" class="form-control"
                                    placeholder="Cari nomor tracking"
                                    value="<?= isset($_GET['tracking_no']) ? $_GET['tracking_no'] : ''; ?>" />
                            </div> -->
                            <div class="col-md-3">
                                <select name="payment_status" class="form-select">
                                    <option value="">Pilih Status Metode Pembayaran</option>
                                    <option value="Uang Tunai" <?= isset($_GET['payment_status']) == true ?
                                        ($_GET['payment_status'] == 'Uang Tunai' ? 'selected' : '')
                                        :
                                        '';
                                    ?>>
                                        Uang Tunai
                                    </option>
                                    <option value="Bayar Online" <?=
                                        isset($_GET['payment_status']) == true
                                        ?
                                        ($_GET['payment_status'] == 'Bayar Online' ? 'selected' : '')
                                        :
                                        '';
                                    ?>>Bayar Online</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="invoice_no" class="form-control" placeholder="Cari nomor invoice"
                                    value="<?= isset($_GET['invoice_no']) ? $_GET['invoice_no'] : ''; ?>" />
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"
                                        aria-hidden="true"></i> Cari</button>
                                <a href="orders.php" class="btn btn-danger"><i class="fas fa-sync-alt"></i> Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">

            <?php
            $query = "SELECT * FROM orders WHERE 1";

            if (isset($_GET['date']) && !empty($_GET['date'])) {
                $date = validate($_GET['date']);
                $query .= " AND DATE(order_date) = '$date'";
            }

            if (isset($_GET['payment_status']) && !empty($_GET['payment_status'])) {
                $paymentStatus = validate($_GET['payment_status']);
                $query .= " AND payment_mode = '$paymentStatus'";
            }

            if (isset($_GET['tracking_no']) && !empty($_GET['tracking_no'])) {
                $trackingNo = validate($_GET['tracking_no']);
                $query .= " AND tracking_no LIKE '%$trackingNo%'";
            }

            if (isset($_GET['invoice_no']) && !empty($_GET['invoice_no'])) {
                $invoiceNo = validate($_GET['invoice_no']);
                $query .= " AND invoice_no LIKE '%$invoiceNo%'";
            }

            $orders = mysqli_query($conn, $query);
            if ($orders) {
                if (mysqli_num_rows($orders) > 0) {
                    ?>
                    <table class="table table-striped table-bordered align-items-center justify-content-center">
                        <thead>
                            <tr>
                                <th>Nomor Invoice</th>
                                <th>Nomor Tracking</th>
                                <th>Total Harga</th>
                                <!-- <th>C Phone</th> -->
                                <th>Tanggal Pemesanan</th>
                                <th>Status Pemesanan</th>
                                <th>Metode Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $orderItem): ?>
                                <tr>
                                    <td class="fw-bold"><?= $orderItem['invoice_no'] ?></td>
                                    <td class="fw-bold"><?= $orderItem['tracking_no'] ?></td>
                                    <td>Rp. <?= number_format($orderItem['total_amount'], 0, ',', '.') ?></td>
                                    <!-- <td><?= $orderItem['phone'] ?></td> -->
                                    <td><?= date('d M, Y', strtotime($orderItem['order_date'])) ?></td>
                                    <td><?= $orderItem['order_status'] ?></td>
                                    <td><?= $orderItem['payment_mode'] ?></td>
                                    <td>
                                        <a href="orders-view.php?track=<?= $orderItem['tracking_no']; ?>"
                                            class="btn btn-info mb-0 px-2 btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                            Tampilan</a>
                                        <a href="orders-view-print.php?track=<?= $orderItem['tracking_no']; ?>"
                                            class="btn btn-primary mb-0 px-2 btn-sm"><i class="fa fa-print" aria-hidden="true"></i>
                                            Cetak</a>
                                        <?php
                                        if ($_SESSION['loggedInUser']['level'] == 'Admin') {
                                            ?>
                                            <a href="orders-view-delete.php?track=<?= $orderItem['tracking_no']; ?>"
                                                class="btn btn-danger mb-0 px-2 btn-sm"><i class="fa fa-trash" aria-hidden="true"></i>
                                                Hapus</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php

                } else {
                    echo "<h5>No Records Found</h5>";
                }
            } else {
                echo "<h5>Something Went Wrong</h5>";
            }
            ?>


        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
