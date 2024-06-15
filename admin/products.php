<?php include ('includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header text-center">
            <h4 class="mb-0">
                Produk
                <?php if ($_SESSION['loggedInUser']['level'] == 'Admin' || $_SESSION['loggedInUser']['level'] == 'Manajer'): ?>
                    <a href="products-create.php" class="btn btn-success float-end"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Produk</a>
                <?php endif; ?>
            </h4>
            <hr>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>
            
            <!-- Form pencarian produk -->
            <form action="" method="get" id="searchForm">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="filterCategory" class="form-label">Filter berdasarkan kategori:</label>
                        <select class="form-select" id="filterCategory" name="category_id">
                            <option value="">-- Pilih Kategori --</option>
                            <?php
                            $categories = getAll('categories');
                            foreach ($categories as $category):
                                ?>
                                <option 
                                value="<?= $category['id']; ?>"
                                <?= isset($_GET['category_id']) && $_GET['category_id'] == $category['id'] ? 'selected' : ''; ?>
                                ><?= $category['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filterStatus" class="form-label">Filter berdasarkan status:</label>
                        <select class="form-select" id="filterStatus" name="stock_status">
                            <option value="">-- Pilih Status --</option>
                            <option value="tersedia" <?= isset($_GET['stock_status']) && $_GET['stock_status'] == 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                            <option value="habis" <?= isset($_GET['stock_status']) && $_GET['stock_status'] == 'habis' ? 'selected' : ''; ?>>Habis</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="searchProduct" class="form-label">Cari Produk:</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchProduct" name="search" placeholder="Masukkan kata kunci"
                                value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Cari</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Akhir Form pencarian produk -->

            <?php
            // Mendapatkan nilai dari form pencarian
            $keyword = isset($_GET['search']) ? $_GET['search'] : '';
            $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
            $stock_status = isset($_GET['stock_status']) ? $_GET['stock_status'] : '';

            // Memanggil fungsi searchProduct() jika ada kata kunci pencarian atau filter kategori atau filter status
            $products = searchProduct($keyword, $category_id, $stock_status);

            // Memeriksa apakah ada produk yang ditemukan
            if ($products && mysqli_num_rows($products) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kode Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <?php if ($_SESSION['loggedInUser']['level'] == 'Admin' || $_SESSION['loggedInUser']['level'] == 'Manajer'): ?>
                                <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $item): ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="../<?= !empty($item['image']) ? $item['image'] : 'assets/uploads/products/default.png' ?>"
                                             class="img-fluid" alt="Gambar Produk" style="width: 100px; height: 100px; object-fit: contain;">
                                    </td>
                                    <td><?= $item['name']; ?></td>
                                    <td><?= $item['product_code']; ?></td>
                                    <td>Rp.<?= number_format($item['price'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php if ($item['quantity'] <= 0): ?>
                                            <span class="badge bg-danger">Habis</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Tersedia</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if ($_SESSION['loggedInUser']['level'] == 'Admin' || $_SESSION['loggedInUser']['level'] == 'Manajer'): ?>
                                    <td>
                                            <a href="products-edit.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm">
                                                <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a href="products-delete.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm"
                                               onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
                // Jika tidak ada produk yang ditemukan, tampilkan pesan
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Kode Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <?php if ($_SESSION['loggedInUser']['level'] == 'Admin' || $_SESSION['loggedInUser']['level'] == 'Manajer'): ?>
                                <th>Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $item): ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="../<?= !empty($item['image']) ? $item['image'] : 'assets/uploads/products/default.png' ?>"
                                             class="img-fluid" alt="Gambar Produk" style="width: 100px; height: 100px; object-fit: contain;">
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <?php if ($_SESSION['loggedInUser']['level'] == 'Admin' || $_SESSION['loggedInUser']['level'] == 'Manajer'): ?>
                                    <td></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <h4 class="text-center">Produk Tidak Ditemukan!</h4>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<?php include ('includes/footer.php'); ?>
<script>
    $(document).ready(function() {
        $('#filterCategory, #filterStatus').change(function() {
            $('#searchForm').submit();
        });
    });
</script>
