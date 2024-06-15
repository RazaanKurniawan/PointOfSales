<?php
require_once '../vendor/autoload.php'; // Sesuaikan path dengan kebutuhan Anda

include ('includes/header.php');

if (!isset($_SESSION['productItems'])) {

    echo '<script>window.location.href = "orders-create.php";</script>';
}



// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'Mid-client-HWVBymZi3_a0rNzA';
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

$snapToken = \Midtrans\Snap::getSnapToken($params);
$_SESSION['snapToken'] = $snapToken;

?>

<div class="card mt-3 container">
    <div class="card-header">
        <h1 id="totalbayar">Pembayaran Online Total: Rp.
            <?php echo isset($_SESSION['productItems']) ? number_format(array_sum(array_column($_SESSION['productItems'], 'price')), 0, ',', '.') : '0'; ?>
        </h1>
    </div>
    <div class="card-body">
        <table class="table">
            <?php if (isset($_SESSION['productItems']) && !empty($_SESSION['productItems'])) {
                $sessionProducts = $_SESSION['productItems']; ?>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                </tr>
                <?php
                $i = 1;
                $totalAmount = 0;
                foreach ($sessionProducts as $row) {
                    $totalAmount += $row['price'] * $row['quantity'];
                    ?>
                    <tr>
                        <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                        <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                        <td style="border-bottom: 1px solid #ccc;">Rp. <?= number_format($row['price'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="2">Total: </td>
                    <td>Rp. <?= number_format($totalAmount, 0, ',', '.'); ?></td>
                </tr>

            </table>
            <?php
            } else {
                echo '<h5 class="text-center">No Items added</h5>';
            }
            ?>

        <?php if (isset($_SESSION['productItems'])): ?>
            <div class="mt-4 text-end">
                <button id="pay-button" class="btn btn-outline-success">Bayar Sekarang</button>
                <button type="button" class="btn btn-primary px-4 mx-1 selesai" id="saveOrder"><i class="fa fa-upload"
                        aria-hidden="true"></i> Simpan</button>
            </div>
        <?php endif; ?>
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