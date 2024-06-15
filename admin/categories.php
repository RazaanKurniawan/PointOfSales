<?php include ('includes/header.php'); ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header text-center">
            <h4 class="mb-0">
                Kategori Produk
                <a href="categories-create.php" class="btn btn-success float-end"><i class="fa fa-plus"
                        aria-hidden="true"></i> Tambah Kategori Produk</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $categories = getAll('categories');
            if (!$categories) {
                echo '<h4>Ada sesuatu yang salah!</h4>';
                return false;
            }

            if (mysqli_num_rows($categories) > 0) {

                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Jumlah Produk</th>
                                <th>Jumlah Stok</th>
                                <th>Status</th>
                                <?php if ($_SESSION['loggedInUser']['level'] == 'Admin' || $_SESSION['loggedInUser']['level'] == 'Manajer'): ?>
                                <th style="width: 145px;">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $item): ?>
                                <tr>
                                    <td><?= $item['id']; ?></td>
                                    <td><?= $item['name']; ?></td>
                                    <td>
                                        <?php
                                        // Query untuk mengambil jumlah produk sesuai kategori
                                        $category_id = $item['id'];
                                        $product_count_result = mysqli_query($conn, "SELECT COUNT(id) AS total FROM products WHERE category_id = $category_id");
                                        $product_count_row = mysqli_fetch_assoc($product_count_result);
                                        echo $product_count_row['total'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        // Query untuk mengambil jumlah stok produk sesuai kategori
                                        $stock_result = mysqli_query($conn, "SELECT SUM(quantity) AS total_stock FROM products WHERE category_id = $category_id");
                                        $stock_row = mysqli_fetch_assoc($stock_result);
                                        if ($stock_row['total_stock'] <= 0): ?>
                                        <p>0</p>
                                        <?php else: 
                                            echo $stock_row['total_stock'];
                                        endif;?>
                                    </td>
                                    <td>
                                        <?php if ($stock_row['total_stock'] <= 0): ?>
                                            <span class="badge bg-danger">Habis</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Tersedia</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if ($_SESSION['loggedInUser']['level'] == 'Admin' || $_SESSION['loggedInUser']['level'] == 'Manajer'): ?>
                                    <td>
                                            <a href="categories-edit.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm"><i
                                                    class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <?php if ($product_count_row['total'] <= 0): ?>
                                                <a href="categories-delete.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm"><i
                                                        class="fa fa-trash" aria-hidden="true"></i></a>
                                            <?php else: ?>
                                                <button><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if ($_SESSION['loggedInUser']['level'] == 'Admin' || $_SESSION['loggedInUser']['level'] == 'Manajer'): ?>
                    <p style="color: red;">Note: Kategori hanya bisa dihapus jika Produk kosong di Kategori tersebut.</p>
                    <?php endif; ?>
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