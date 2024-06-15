<?php 
include ('includes/header.php'); 

// Cek apakah level pengguna adalah Admin atau Manajer
if ($_SESSION['loggedInUser']['level'] != 'Admin' && $_SESSION['loggedInUser']['level'] != 'Manajer') {
    echo '<script>window.location.href = "index.php";</script>';
    exit();
}
?>

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0 text-center">Tambahkan Produk
                <a href="products.php" class="btn btn-danger float-end"><i class="fa fa-chevron-left"
                        aria-hidden="true"></i> Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="category">Pilih Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">Pilih Kategori</option>
                            <?php
                            $categories = getAll('categories');
                            if ($categories) {
                                if (mysqli_num_rows($categories) > 0) {
                                    foreach ($categories as $cateItem) {
                                        echo '<option value="' . $cateItem['id'] . '">' . $cateItem['name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Kategori tidak ditemukan!</option>';
                                }
                            } else {
                                echo '<option value="">Ada sesuatu yang salah!</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Nama Produk</label>
                        <input type="text" name="name" required class="form-control" placeholder="Nama Produk">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Kode Produk</label>
                        <input type="text" name="product_code" required class="form-control" placeholder="Kode Produk">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Deksripsi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi"></textarea>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Harga</label>
                        <input type="text" name="price" required class="form-control" placeholder="Contoh: 20000">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Stok</label>
                        <input type="text" name="quantity" required class="form-control" placeholder="Jumlah">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Gambar</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <!-- <div class="col-md-6">
                        <label>Status (Unchecked=Tersedia, Checked=Habis)</label>
                        <br />
                        <input type="checkbox" name="status" style="width:30px;height:30px">
                    </div> -->


                    <div class="col-md-6 mb-3 text-end">
                        <br>
                        <button type="submit" name="saveProduct" class="btn btn-primary"><i class="fa fa-upload"
                                aria-hidden="true"></i> Save</button>
                    </div>


                </div>
        </div>
    </div>
    <?php include ('includes/footer.php'); ?>