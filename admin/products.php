<?php include ('includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header text-center">
            <h4 class="mb-0">
                Products
                <a href="products-create.php" class="btn btn-primary float-end"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Produk</a>
            </h4>
            <hr>
        </div>
        <div class="card-body">

            <?php alertMessage(); ?>
            <?php
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

            if ($keyword) {
                $products = cariProduct($keyword);
            } else {
                $products = getAll('products');
            }

            if (!$products) {
                echo '<h4>Ada sesuatu yang salah!</h4>';
                return false;
            }

            if (mysqli_num_rows($products) > 0) {
                ?>
                <form action="" method="get" id="filterForm">
                    <div class="mb-3">
                        <label for="filterCategory" class="form-label">Filter berdasarkan kategori:</label>
                        <select class="form-select" id="filterCategory" name="keyword">
                            <option value="">-- Pilih Kategori --</option>
                            <?php
                            $categories = getAll('categories');

                            foreach ($categories as $category):
                                ?>
                                <option 
                                value="<?= $category['id']; ?>"
                                <?= isset($_GET['keyword']) == true ? 
                                        ($_GET['keyword'] == $category['id'] ? 'selected':'')
                                        :
                                        ''; 
                                        ?>
                                ><?= $category['name']; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </form>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                    <?php foreach ($products as $item): ?>
                        <div class="col mb-4">
                            <div class="card">
                                <div class="text-center">
                                    <img src="../<?= $item['image']; ?>" class="card-img-top img-fluid" alt="..."
                                        style="width: 118.23px; height: 130px;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $item['name']; ?></h5>
                                    <p class="card-text">Kode Produk: <?= $item['product_code']; ?></p>
                                    <p class="card-text">Harga: Rp.<?= number_format($item['price'], 0, ',', '.'); ?></p>
                                    <p class="card-text">Stok: <?= $item['quantity']; ?></p>
                                    <?php if ($item['quantity'] <= 0): ?>
                                        <span class="badge bg-danger">Habis</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Tersedia</span>
                                    <?php endif; ?>
                                    <div class="mt-3">
                                        <a href="products-edit.php?id=<?= $item['id']; ?>" class="btn btn-primary btn-sl">
                                            <i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="products-delete.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sl"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php
            } else {
                ?>
                <tr>
                    <h4 class="mb-0">Data tidak ditemukan!</h4>
                </tr>
            <?php } ?>
        </div>
    </div>
</div>
<?php include ('includes/footer.php'); ?>
<script>
    $(document).ready(function() {
        $('#filterCategory').change(function() { // Tambahkan event listener untuk perubahan dropdown kategori
            $('#filterForm').submit(); // Submit form secara otomatis saat nilai dropdown berubah
        });
    });
</script>


