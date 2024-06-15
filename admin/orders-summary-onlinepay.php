<?php
require_once '../vendor/autoload.php'; // Sesuaikan path dengan kebutuhan Anda

include ('includes/header.php');

if (!isset($_SESSION['productItems'])) {

    echo '<script>window.location.href = "orders-create.php";</script>';
}



// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-j46jiMe2dZDoVY1DKRDC07xx';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

    $params = array(
        'transaction_details' => array(
            'order_id' => rand(),
            'gross_amount' => calculateTotalAmount($_SESSION['productItems']), // Menghitung total amount berdasarkan produk dalam session
        )
    );

    $customer_details = array(
        'first_name'    => "Jemie",
        'last_name'     => "Andrew",
        'email'         => "jemie@gmail.com",
        'phone'         => "081122334455",
        'billing_address'  => 0120121312314,
        'shipping_address' => 1029102910391145
    );

$snapToken = \Midtrans\Snap::getSnapToken($params);
$_SESSION['snapToken'] = $snapToken;

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
                                            <td colspan="4" align="end" style="font-weight: bold;">Bayar</td>
                                            <td colspan="1" style="font-weight: bold;">
                                                Rp. <?php echo number_format($totalAmount, 0, ',', '.'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;">Kembalian</td>
                                            <td colspan="1" style="font-weight: bold;">
                                                Rp. <?php echo number_format($totalAmount - $totalAmount, 0, ',', '.'); ?>
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
                            <a id="pay-button" class="btn btn-outline-success">Bayar Sekarang!</a>
                            <button type="button" onclick="downloadPDF('<?= $_SESSION['invoice_no'] ?>')" class="btn btn-warning"><i class="fa fa-download" aria-hidden="true"></i> Download
                                PDF</button>

                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include ('includes/footer.php'); ?>


<!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-YN2f67vc-ivLxYPk"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        // SnapToken acquired from previous step
        snap.pay('<?php echo $snapToken; ?>', {
            // Optional
            onSuccess: function (result) {
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                document.querySelector('.selesai').click();

            },
            // Optional
            onPending: function (result) {
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onError: function (result) {
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
    };


</script>
</body>

</html>

<?php
function calculateTotalAmount($products)
{
    $totalAmount = 0;
    foreach ($products as $product) {
        $totalAmount += $product['price'] * $product['quantity'];
    }
    return $totalAmount;
}
?>