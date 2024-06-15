<?php include ('includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <h1 class="mt-4">Beranda</h1>
                        <?php alertMessage();
                        date_default_timezone_set('Asia/Jakarta'); ?>
                        <div class="row">
                            <div class="col-md-6 col-xl-3">
                                <div class="card bg-c-blue order-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Total Kategori</h6>
                                        <h2 class="text-right">
                                            <i
                                                class="fa fa-fw fas fa-cash-register f-left"></i><span><?= getCount('categories'); ?></span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="card bg-c-green order-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Total Produk</h6>
                                        <h2 class="text-right">
                                            <i
                                                class="fa fa-fw fa-cube f-left"></i><span><?= getCount('products'); ?></span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="card bg-c-yellow order-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Total Admin</h6>
                                        <h2 class="text-right">
                                            <i
                                                class="fa fa-fw fa-user-tie f-left"></i><span><?= getCount('admin'); ?></span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-6 col-xl-3">
                                <div class="card bg-c-pink order-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Total Pelanggan</h6>
                                        <h2 class="text-right">
                                            <i
                                                class="fa fa-fw fa-user f-left"></i><span><?= getCount('customers'); ?></span>
                                        </h2>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <hr>
                                <h4>Pesanan</h4>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="card bg-primary order-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Produk Terjual Hari Ini</h6>
                                        <h2 class="text-right">
                                            <i class="fa fa-fw fa-clock f-left"></i><span>
                                                <?php
                                                // Mengambil tanggal hari ini
                                                $todayDate = date('Y-m-d');

                                                // Query untuk mengambil total produk yang terjual dari setiap pesanan yang dibuat pada tanggal hari ini
                                                $todayProductsSoldQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT product_id) AS totalProductsSold FROM order_items WHERE DATE(order_date) = '$todayDate'");

                                                // Mengambil hasil query
                                                $todayProductsSoldData = mysqli_fetch_assoc($todayProductsSoldQuery);

                                                // Mengambil total produk yang terjual hari ini
                                                $totalProductsSoldToday = $todayProductsSoldData['totalProductsSold'];

                                                // Menampilkan total produk yang terjual hari ini
                                                echo $totalProductsSoldToday !== null ? $totalProductsSoldToday : "0";
                                                ?>
                                            </span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3">
                                <div class="card bg-primary order-card">
                                    <div class="card-block">
                                        <h6 class="m-b-20">Total Produk Yang Terjual</h6>
                                        <h2 class="text-right">
                                            <i class="fa fa-fw fa-archive f-left"></i><span>
                                                <?php
                                                // Query untuk mengambil total produk yang terjual dari setiap pesanan yang dibuat pada tanggal hari ini
                                                $productsSoldQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT product_id) AS totalProductsSold FROM order_items");

                                                // Mengambil hasil query
                                                $productsSoldData = mysqli_fetch_assoc($productsSoldQuery);

                                                // Mengambil total produk yang terjual hari ini
                                                $totalProductsSold = $productsSoldData['totalProductsSold'];

                                                // Menampilkan total produk yang terjual hari ini
                                                echo $totalProductsSold !== null ? $totalProductsSold : "0";
                                                ?>
                                            </span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card shadow-sm mb-4">
                                    <div class="card-header">
                                        <h3 class="text-center">Total Penjualan Hari Ini</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $todayDate = date('Y-m-d');
                                        $todaySalesQuery = mysqli_query($conn, "SELECT product_id, SUM(quantity) AS total_sold FROM order_items WHERE DATE(order_date)='$todayDate' GROUP BY product_id");
                                        $totalSalesToday = 0;

                                        if ($todaySalesQuery && mysqli_num_rows($todaySalesQuery) > 0) { ?>
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-striped table-bordered align-items-center justify-content-center">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Produk</th>
                                                            <th>Terjual Hari Ini</th>
                                                            <th>Total Penjualan Hari Ini</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        while ($row = mysqli_fetch_assoc($todaySalesQuery)) {
                                                            $productId = $row['product_id'];
                                                            $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE id=$productId");
                                                            $product = mysqli_fetch_assoc($productQuery);

                                                            if ($product) {
                                                                $productName = $product['name'];
                                                                $totalSoldToday = $row['total_sold'];
                                                                $totalSalesProductToday = $totalSoldToday * $product['price'];
                                                                $totalSalesToday += $totalSalesProductToday; ?>
                                                                <tr>
                                                                    <td><?= $i++ ?></td>
                                                                    <td><?= $productName ?></td>
                                                                    <td><?= $totalSoldToday ?></td>
                                                                    <td>Rp.
                                                                        <?= number_format($totalSalesProductToday, 0, ',', '.') ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } else { ?>
                                                                <tr>
                                                                    <td><?= $i++ ?></td>
                                                                    <td>Produk telah dihapus</td>
                                                                    <td><?= $row['total_sold'] ?></td>
                                                                    <td>Rp. 0</td>
                                                                </tr>
                                                            <?php }
                                                        } ?>
                                                        <tr>
                                                            <td colspan="3" class="text-end"><b>Total Penghasilan Hari
                                                                    Ini:</b></td>
                                                            <td><b>Rp.
                                                                    <?= number_format($totalSalesToday, 0, ',', '.') ?></b>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <p class="text-center">Tidak ada penjualan hari ini</p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card shadow-sm mb-4">
                                    <div class="card-header">
                                        <h3 class="text-center">Total Penjualan Seluruh Produk</h3>
                                    </div>
                                    <div class="card-body">

                                        <!-- Date Filter Form -->
                                        <form method="GET" action="">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="start_date">Mulai Tanggal</label>
                                                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="end_date">Sampai Tanggal</label>
                                                        <input type="date" name="end_date" id="end_date" class="form-control" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group mt-4">
                                                        <button type="submit" class="btn btn-primary mt-2"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                                                        <a href="index.php" class="btn btn-danger mt-2"><i class="fas fa-sync-alt"></i> Reset</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <?php
                                        // Default date range is all time
                                        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '1970-01-01';
                                        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

                                        $query = "SELECT product_id, SUM(quantity) AS total_sold, MAX(order_date) AS last_order_date FROM order_items WHERE DATE(order_date) BETWEEN '$startDate' AND '$endDate' GROUP BY product_id";
                                        $result = mysqli_query($conn, $query);
                                        $productsData = [];
                                        $totalIncome = 0;

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $productId = $row['product_id'];
                                            $productQuery = mysqli_query($conn, "SELECT * FROM products WHERE id = $productId");
                                            $product = mysqli_fetch_assoc($productQuery);

                                            if ($product) {
                                                $productName = $product['name'];
                                                $totalSold = $row['total_sold'];
                                                $totalSalesProduct = $totalSold * $product['price'];
                                                $totalIncome += $totalSalesProduct;

                                                $productsData[$productId] = [
                                                    'name' => $productName,
                                                    'total_sold' => $totalSold,
                                                    'total_sales' => $totalSalesProduct,
                                                    'last_order_date' => $row['last_order_date'],
                                                ];
                                            } else {
                                                $productsData[$productId] = [
                                                    'name' => 'Produk telah dihapus',
                                                    'total_sold' => 0,
                                                    'total_sales' => 0,
                                                    'last_order_date' => null,
                                                ];
                                            }
                                        } ?>
                                        <div class="table-responsive">
                                            <table
                                                class="table table-striped table-bordered align-items-center justify-content-center">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Produk</th>
                                                        <th>Terjual</th>
                                                        <th>Total Harga</th>
                                                        <?php if ($_SESSION['loggedInUser']['level'] == 'Admin' || $_SESSION['loggedInUser']['level'] == 'Manajer'): ?>
                                                        <th>Aksi</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($productsData as $productId => $productData) { ?>
                                                        <tr>
                                                            <td><?= $i++; ?></td>
                                                            <td><?= date('d M, Y', strtotime($productData['last_order_date'])) ?></td>
                                                            <td><?= $productData['name'] ?></td>
                                                            <td><?= $productData['total_sold'] ?></td>
                                                            <td>Rp.
                                                                <?= number_format($productData['total_sales'], 0, ',', '.'); ?>
                                                            </td>
                                                            <?php
                                                            if ($_SESSION['loggedInUser']['level'] == 'Admin' || $_SESSION['loggedInUser']['level'] == 'Manajer'): 
                                                                ?>
                                                                <td>
                                                                    <a href="index-totalsold-delete.php?id=<?= $productId; ?>"
                                                                        class="btn btn-danger">Hapus</a>
                                                                </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <td colspan="4" class="text-end"><b>Total Penghasilan:</b></td>
                                                        <td><b>Rp. <?= number_format($totalIncome, 0, ',', '.') ?></b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include ('includes/footer.php'); ?>
