<?php include ('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-0 text-center">Orders</h4>
                </div>
                <div class="col-md-8">
                    <form action="" method="GET">
                        <div class="row g-1">
                            <div class="col-md-3">
                                <input type="date" name="date" class="form-control"
                                    value="<?= isset($_GET['date']) ? $_GET['date'] : ''; ?>" />
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="tracking_no" class="form-control" placeholder="Cari nomor tracking"
                                    value="<?= isset($_GET['tracking_no']) ? $_GET['tracking_no'] : ''; ?>" />
                            </div>
                            <div class="col-md-3">
                                <select name="payment_status" class="form-select">
                                    <option value="">Pilih Status Metode Pembayaran</option>
                                    <option value="Cash Payment" <?= isset($_GET['payment_status']) == true ?
                                        ($_GET['payment_status'] == 'Cash Payment' ? 'selected' : '')
                                        :
                                        '';
                                    ?>>
                                        Uang Tunai
                                    </option>
                                    <option value="Online Payment" <?=
                                        isset($_GET['payment_status']) == true
                                        ?
                                        ($_GET['payment_status'] == 'Online Payment' ? 'selected' : '')
                                        :
                                        '';
                                    ?>>Bayar Online</option>
                                </select>
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

            $orders = mysqli_query($conn, $query);
            if ($orders) {
                if (mysqli_num_rows($orders) > 0) {
                    ?>
                    <table class="table table-striped table-bordered align-items-center justify-content-center">
                        <thead>
                            <tr>
                                <th>Tracking No.</th>
                                <th>Total Amount</th>
                                <!-- <th>C Phone</th> -->
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $orderItem): ?>
                                <tr>
                                    <td class="fw-bold"><?= $orderItem['tracking_no'] ?></td>
                                    <td><?= $orderItem['total_amount'] ?></td>
                                    <!-- <td><?= $orderItem['phone'] ?></td> -->
                                    <td><?= date('d M, Y', strtotime($orderItem['order_date'])) ?></td>
                                    <td><?= $orderItem['order_status'] ?></td>
                                    <td><?= $orderItem['payment_mode'] ?></td>
                                    <td>
                                        <a href="orders-view.php?track=<?= $orderItem['tracking_no']; ?>"
                                            class="btn btn-info mb-0 px-2 btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                            View</a>
                                        <a href="orders-view-print.php?track=<?= $orderItem['tracking_no']; ?>"
                                            class="btn btn-primary mb-0 px-2 btn-sm"><i class="fa fa-print" aria-hidden="true"></i>
                                            Print</a>
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
<?php include ('includes/footer.php'); ?>
