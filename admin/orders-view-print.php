<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0 text-center">Orders
                <a href="orders.php" class="btn btn-danger float-end"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
            </h4>
        </div>
        <div class="card-body">
            <div id="myBillingArea">

                <?php
                if (isset($_GET['track'])) {
                    $trackingNo = validate($_GET['track']);
                    if ($trackingNo == '') {
                ?>
                        <div class="text-center py-5">
                            <h5>Please provide Tracking Number</h5>
                            <div>
                                <a href="orders.php" class="btn btn-primary mt-4 w-25">Go Back To Orders</a>
                            </div>
                        </div>
                    <?php
                    }

                    $orderQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.*, o.money as orderMoney, o.total_amount as totalAmount 
                    FROM orders o 
                    JOIN order_items oi ON oi.order_id = o.id 
                    JOIN products p ON p.id = oi.product_id 
                    WHERE o.tracking_no = '$trackingNo'";
                    $orderQueryRes = mysqli_query($conn, $orderQuery);

                    if (!$orderQueryRes) {
                        echo "<h5>Something When Wrong</h5>";
                        return false;
                    }

                    if (mysqli_num_rows($orderQueryRes) > 0) {
                        $orderDataRow = mysqli_fetch_assoc($orderQueryRes);
                        // print_r($orderDataRow);
                    ?>
                        <table style="width: 100%; margin-bottom: 20px; border-collapse: collapse; ">
                            
                                <tr>
                                    <td style="text-align: center; padding: 10px;" colspan="2">
                                        <h4 style="font-size: 23px; line-height: 30px; margin: 2px; padding: 0;">Bussines Center
                                            SMK
                                            Fatahillah</h4>
                                        <p style="font-size: 16px; line-height: 24px; margin: 2px; padding: 0;">Jl. Kp. Tengah,
                                            RT.06/RW.03, Cipeucang, Kec. Cileungsi, Kabupaten Bogor, Jawa Barat 16820</p>
                                        <p style="font-size: 16px; line-height: 24px; margin: 2px; padding: 0;">Tempat Jajanan
                                            Anak-Anak Fatahillah</p>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <td style="padding: 10px;" align="left" border-right="1px solid #ccc" width="50%" valign="top">
                                        <h5 style="font-size: 20px; line-height: 30px; margin: 0px; padding: 0;">
                                            Customer Details</h5>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer
                                            Name: <?= $orderDataRow['name'] ?> </p>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer
                                            Class: <?= $orderDataRow['class'] ?> </p>
                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Customer
                                            Phone No.: <?= $orderDataRow['phone'] ?> </p>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Customer
                                            Email Id: <?= $orderDataRow['email'] ?> </p>
                                    </td> -->
                                    </tr>
                                    </table>
                                    <hr>
                                    <table style="width: 100%; margin-bottom: 20px; border-collapse: collapse; ">
                                    <tr>
                                    <td style="padding: 10px;" align="center" width="50%" valign="top">
                                        <h5 style="font-size: 20px; line-height: 30px; margin: 0px; padding: 0;">Invoice
                                            Details</h5>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Invoice
                                            No: <?= $orderDataRow['invoice_no']; ?> </p>
                                            <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Invoice
                                            Date: <?= date('d/m/Y H:i:s'); ?> </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        echo "<h5>No Data Found</h5>";
                        return false;
                    }
                    $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, 
                          oi.price as orderItemPrice, 
                          o.*, 
                          oi.*, 
                          p.*, 
                          o.money as orderMoney, 
                          o.total_amount as totalAmount 
                   FROM orders o, 
                        order_items oi, 
                        products p 
                   WHERE oi.order_id = o.id 
                     AND p.id = oi.product_id 
                     AND o.tracking_no = '$trackingNo'";

                    $orderItemQueryRes = mysqli_query($conn, $orderItemQuery);

                    if ($orderItemQueryRes) {
                        if (mysqli_num_rows($orderItemQueryRes) > 0) {
                        ?>

                            <div class="table-responsive mb-3">
                                <table style="width: 100%;" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">No.</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;">Product Name</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Price</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Quantity</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="20%">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 1;
                                        foreach ($orderItemQueryRes as $key => $row) :
                                        ?>

                                            <tr>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;">Rp.
                                                    <?= number_format($row['orderItemPrice'], 0, ',', '.'); ?>
                                                </td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['orderItemQuantity']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                                    Rp.
                                                    <?= number_format($row['orderItemPrice'] * $row['orderItemQuantity'], 0, ',', '.'); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;">Grand Total:</td>
                                            <td colspan="1" style="font-weight: bold;">
                                                Rp. <?= number_format($row['totalAmount'], 0, ',', '.'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;">Tunai:</td>
                                            <td colspan="1" style="font-weight: bold;">
                                                Rp. <?= number_format($row['orderMoney'], 0, ',', '.'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;">Kembalian:</td>
                                            <td colspan="1" style="font-weight: bold;">
                                                Rp. <?= number_format($row['orderMoney'] - $row['totalAmount'], 0, ',', '.'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">Payment Mode: <?= $row['payment_mode']; ?></td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>

                    <?php
                        } else {
                            echo "<h5>No data found</h5>";
                            return false;
                        }
                    } else {
                        echo "<h5>Something When Wrong!</h5>";
                        return false;
                    }
                } else {
                    ?>
                    <div class="text-center py-5">
                        <h5>No Tracking Number Parameter Found</h5>
                        <div>
                            <a href="orders.php" class="btn btn-primary mt-4 w-25">Go Back To Orders</a>
                        </div>
                    </div>
                <?php

                }
                ?>
            </div>



            <div class="mt-4 text-end">
                <button class="btn btn-info px-4 mx-1" onclick="printMyBillingArea()"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                <button class="btn btn-primary px-4 mx-1" onclick="downloadPDF('<?= $orderDataRow['invoice_no']; ?>')">Download PDF</button>
            </div>

        </div>

    </div>
</div>
<?php include('includes/footer.php'); ?>