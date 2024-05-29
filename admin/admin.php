<?php include ('includes/header.php'); 
if (($_SESSION['loggedInUser']['level'] != 'Admin')) {

    echo '<script>window.location.href = "index.php";</script>';

}
?>

    <div class="container-fluid px-4">
        <div class="card mt-4 shadow-sm">
            <div class="card-header text-center">
                <h4 class="mb-0">
                    Admin/Staff
                    <a href="admin-create.php" class="btn btn-primary float-end"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Admin</a>
                </h4>
            </div>
            <div class="card-body">
                <?php alertMessage(); ?>
                
                <?php
                $admin = getAll('admin');
                if (!$admin) {
                    echo '<h4>Ada sesuatu yang salah!</h4>';
                    return false;
                }

                if (mysqli_num_rows($admin) > 0) {

                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No.</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th style="width: 145px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                foreach ($admin as $adminItem): 
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?= $adminItem['nama']; ?></td>
                                        <td><?= $adminItem['email']; ?></td>
                                        <td><?= $adminItem['level']; ?></td>
                                        <td>
                                            <?php
                                            $id = $adminItem['id'];
                                            $query = "SELECT * FROM admin WHERE id='$id'  LIMIT 1";
                                            $result = mysqli_query($conn, $query);

                                            $row = mysqli_fetch_assoc($result);

                                            if ($row['is_ban'] == 1) {
                                                echo '<span class="badge bg-danger">Banned</span>';
                                            } else {
                                                echo '<span class="badge bg-success">Active</span>';
                                            }

                                            ?>
                                        </td>
                                        <td>
                                            <a href="admin-edit.php?id=<?= $adminItem['id']; ?>"
                                                class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a href="admin-delete.php?id=<?= $adminItem['id']; ?>"
                                                class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
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