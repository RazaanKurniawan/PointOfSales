<?php 

include ('includes/header.php'); 

if ($_SESSION['loggedInUser']['level'] != 'Admin' && $_SESSION['loggedInUser']['level'] != 'Manajer') {
    echo '<script>window.location.href = "index.php";</script>';
    exit();
}

?>

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0 text-center">Ubah Produk
                <a href="products.php" class="btn btn-danger float-end"><i class="fa fa-chevron-left"
                        aria-hidden="true"></i> Kembali</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">

                <?php
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>ID tidak bernilai angka!</h5>';
                    return false;
                }

                $product = getById('products', $paramValue);
                if ($product) {

                    if ($product['status'] == 200) {

                        ?>

                        <input type="hidden" name="product_id" value="<?= $product['data']['id']; ?>">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="category">Pilih Kategori</label>
                                <select name="category_id" id="form-select" class="form-select">
                                    <option value="">Pilih Kategori</option>
                                    <?php
                                    $categories = getAll('categories');
                                    if ($categories) {
                                        if (mysqli_num_rows($categories) > 0) {
                                            foreach ($categories as $cateItem) {
                                                ?>

                                                <option value="<?= $cateItem['id']; ?>" <?= $product['data']['category_id'] == $cateItem['id'] ? 'selected' : ''; ?>>
                                                    <?= $cateItem['name']; ?>
                                                </option>

                                                <?php
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
                                <input type="text" name="name" value="<?= $product['data']['name']; ?>" required
                                    class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="">Kode Produk</label>
                                <input type="text" name="product_code" value="<?= $product['data']['product_code']; ?>" required class="form-control" placeholder="Kode Produk">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control"
                                    rows="3"><?= $product['data']['description']; ?></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Harga</label>
                                <input type="text" name="price" value="<?= $product['data']['price']; ?>" required
                                    class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Kuantitas</label>
                                <input type="text" name="quantity" value="<?= $product['data']['quantity']; ?>" required
                                    class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Gambar</label>
                                <input type="file" name="image" class="form-control mb-3" />
                                <!-- <img src="../<?= $product['data']['image']; ?>" alt="Img"
                                    style="width: 350px; height: 350px; ;" /> -->
                            </div>

                            <!-- <div class="col-md-6">
                                <label>Status (Unchecked=Visible, Checked=Hidden)</label>
                                <br />
                                <input type="checkbox" name="status" <?= $product['data']['quantity'] <= 0 ? 'checked' : ''; ?>
                                    style="width:3Øpx;height:30px">
                            </div> -->


                            <div class="col-md-6 mb-3 text-end">
                                <br>
                                <button type="submit" name="updateProduct" class="btn btn-primary">Update</button>
                            </div>


                        </div>
                        <?php
                    } else {
                        echo '<h5>' . $product['message'] . '</h5>';
                    }

                } else {
                    echo '<h5>Ada sesuatu yang salah!</h5>';
                    return false;
                }
                ?>
        </div>
    </div>
    <?php include ('includes/footer.php'); ?>