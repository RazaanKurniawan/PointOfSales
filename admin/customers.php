<?php include ('includes/header.php'); ?>
    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header text-center">
                <h4 class="mb-0">
                    Pelanggan
                    <a href="customers-create.php" class="btn btn-success float-end"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Pelanggan</a>
                </h4>
            </div>
            <div class="card-body">

                <?php alertMessage(); ?>

                <?php
                $customers = getAll('customers');
                if (!$customers) {
                    echo '<h4>Ada sesuatu yang salah!</h4>';
                    return false;
                }

                if (mysqli_num_rows($customers) > 0) {

                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th style="width: 145px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $item): ?>
                                    <tr>
                                        <td><?= $item['id']; ?></td>
                                        <td><?= $item['name']; ?></td>
                                        <td><?= $item['class']; ?></td>
                                        <td>
                                            <?php
                                            if ($item['status'] == 1) {
                                                echo '<span class="badge bg-danger">Nonactive</span>';
                                            } else {
                                                echo '<span class="badge bg-success">Active</span>';
                                            }

                                            ?>
                                        </td>
                                        <td>
                                            <a href="customers-edit.php?id=<?= $item['id']; ?>"
                                                class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a href="customers-delete.php?id=<?= $item['id']; ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
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