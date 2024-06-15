<?php include ('includes/header.php'); 
if ($_SESSION['loggedInUser']['level'] != 'Admin') {
    echo '<script>window.location.href = "index.php";</script>';
}
?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header text-center">
            <h4 class="mb-0">
                Administrator/Pekerja
                <a href="admin-create.php" class="btn btn-success float-end"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Admin</a>
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

                $loggedInUserLevel = $_SESSION['loggedInUser']['level'];
                $sameLevelAdmins = [];
                $otherLevelAdmins = [];

                // Pisahkan akun dengan level yang sama dari daftar akun lainnya
                foreach ($admin as $adminItem) {
                    if ($adminItem['level'] == $loggedInUserLevel) {
                        $sameLevelAdmins[] = $adminItem;
                    } else {
                        $otherLevelAdmins[] = $adminItem;
                    }
                }

                ?>
                <div class="table-responsive">
                    <h5>Admin</h5>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Bagian</th>
                                <th>Status</th>
                                <th style="width: 145px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            foreach ($sameLevelAdmins as $adminItem): 
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?= $adminItem['nama']; ?> <?php if ($adminItem['id'] == $_SESSION['loggedInUser']['user_id']) echo "<span class='badge bg-primary'>Sedang Login</span>"; ?></td>
                                    <td><?= $adminItem['email']; ?></td>
                                    <td><?= $adminItem['level']; ?></td>
                                    <td>
                                        <?php if ($adminItem['is_ban'] == 1): ?>
                                            <span class="badge bg-danger">Banned</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="admin-edit.php?id=<?= $adminItem['id']; ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <!-- No delete button for same level users -->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <h5>Manajer/Pekerja</h5>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Bagian</th>
                                <th>Status</th>
                                <th style="width: 145px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $j = 1;
                            foreach ($otherLevelAdmins as $adminItem): 
                                ?>
                                <tr>
                                    <td><?php echo $j++; ?></td>
                                    <td><?= $adminItem['nama']; ?></td>
                                    <td><?= $adminItem['email']; ?></td>
                                    <td><?= $adminItem['level']; ?></td>
                                    <td>
                                        <?php if ($adminItem['is_ban'] == 1): ?>
                                            <span class="badge bg-danger">Banned</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="admin-edit.php?id=<?= $adminItem['id']; ?>" class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="admin-delete.php?id=<?= $adminItem['id']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                ?>
                <h4 class="mb-0">Data tidak ditemukan!</h4>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php include ('includes/footer.php'); ?>
