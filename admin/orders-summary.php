<?php include('includes/header.php');
if (!isset($_SESSION['productItems'])) {

    echo '<script>window.location.href = "orders-create.php";</script>';
}
?>

<div class="modal fade" id="orderSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">

                <div class="mb-3 p-4">
                    <h5 id="orderPlaceSuccessMessage"></h5>
                </div>

                <a href="orders.php" class="btn btn-secondary"><i class="fa fa-times-circle" aria-hidden="true"></i>
                    Close</a>
                <button type="button" onclick="printMyBillingArea()" class="btn btn-danger"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                <button type="button" onclick="downloadPDF('<?= $_SESSION['invoice_no'] ?>')" class="btn btn-warning"><i class="fa fa-download" aria-hidden="true"></i> Download PDF</button>

            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4 align="center">Ringkasan <a href="orders-create.php" class="btn btn-danger float-end"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali ke buat pesanan</a>
                    </h4>
                </div>
                <div class="card-body">

                    <?php alertMessage(); ?>

                    <div id="myBillingArea">

                        <?php
                        // if (isset($_SESSION['cphone'])) {

                        //     $phone = validate($_SESSION['cphone']);
                        $invoiceNo = validate($_SESSION['invoice_no']);

                        //     $customerQuery = mysqli_query($conn, "SELECT * FROM customers WHERE phone = '$phone' LIMIT 1");
                        //     if ($customerQuery) {
                        //         if (mysqli_num_rows($customerQuery) > 0) {


                        //             $cRowData = mysqli_fetch_assoc($customerQuery);
                        //             
                        ?>

                        <table style="width: 100%; margin-bottom: 20px;">
                            <tbody>
                                <tr>
                                    <td style="text-align: center; padding: 10px;" colspan="2">
                                        <h4 style="font-size: 23px; line-height: 30px; margin: 2px; padding: 0;">
                                            Bussines Centre SMK Fatahillah</h4>
                                        <p style="font-size: 16px; line-height: 24px; margin: 2px; padding: 0;">Jl. Kp.
                                            Tengah, RT.06/RW.03, Cipeucang, Kec. Cileungsi, Kabupaten Bogor, Jawa Barat
                                            16820</p>
                                        <p style="font-size: 16px; line-height: 24px; margin: 2px; padding: 0;">Tempat
                                            Jajanan
                                            Anak-Anak Fatahillah</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <table style="width: 100%; margin-bottom: 20px;">
                            <tbody>
                                <tr>
                                    <?php date_default_timezone_set('Asia/Jakarta'); ?>
                                    <td style="padding: 10px;" align="center" width="50%" valign="top">
                                        <h5 style="font-size: 20px; line-height: 30px; margin: 0px; padding: 0;">Detail Nota</h5>
                                        <p style="font-size: 14px; line-height: 20px; margin: 0px; padding: 0;">Nomor Nota: <?= $invoiceNo; ?> </p>
                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Tanggal Nota: <?= date('d/m/Y H:i:s'); ?> </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                        <?php
                        //         } else {
                        //             echo "<h5>No Customer Found</h5>";
                        //             return;
                        //         }


                        //     }
                        // }
                        ?>

                        <?php
                        if (isset($_SESSION['productItems'])) {
                            $sessionProducts = $_SESSION['productItems'];
                        ?>
                            <div class="table-responsive mb-3">
                                <table style="width: 100%; " cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">No.</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;">Nama Produk</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Harga</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Jumlah
                                            </th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Total Harga
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 1;
                                        $totalAmount = 0;
                                        foreach ($sessionProducts as $key => $row) :
                                            $totalAmount += $row['price'] * $row['quantity']

                                        ?>

                                            <tr>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;">
                                                    Rp. <?= number_format($row['price'], 0, ',', '.'); ?>
                                                </td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['quantity'] ?></td>
                                                <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                                    Rp. <?= number_format($row['price'] * $row['quantity'], 0, ',', '.'); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;">Total Keseluruhan:</td>
                                            <td colspan="1" style="font-weight: bold;">
                                                Rp. <?php echo number_format($totalAmount, 0, ',', '.'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;">Tunai</td>
                                            <td colspan="1" style="font-weight: bold;">
                                                Rp. <?php echo number_format($_SESSION['money'], 0, ',', '.'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;">Kembalian</td>
                                            <td colspan="1" style="font-weight: bold;">
                                                Rp. <?php echo number_format($_SESSION['money'] - $totalAmount, 0, ',', '.'); ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="5">Metode Pembayaran: <?php echo $_SESSION['payment_mode']; ?></td>
                                        </tr>
                                    </tbody>

                                </table>

                            </div>
                        <?php
                        } else {
                            echo '<h5 class="text-center"> No Items added </h5>';
                        }
                        ?>


                    </div>

                    <?php if (isset($_SESSION['productItems'])) : ?>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-primary px-4 mx-1" id="saveOrder"><i class="fa fa-upload" aria-hidden="true"></i> Simpan</button>
                            <button class="btn btn-info px-4 mx-1" onclick="printMyBillingArea()"><i class="fa fa-print" aria-hidden="true"></i> Cetak</button>
                            <!-- <a href="orders-pay.php" class="btn btn-outline-success">Bayar Sekarang!</a> -->
                            <button type="button" onclick="downloadPDF('<?= $_SESSION['invoice_no'] ?>')" class="btn btn-warning"><i class="fa fa-download" aria-hidden="true"></i> Download
                                PDF</button>

                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>