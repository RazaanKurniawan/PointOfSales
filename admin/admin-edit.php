<?php include ('includes/header.php'); 
if (($_SESSION['loggedInUser']['level'] == 'Staff')) {

    echo '<script>window.location.href = "index.php";</script>';

}
?>

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0 text-center">Edit Admin
                <a href="admin.php" class="btn btn-danger float-end"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">

                <?php
                if (isset($_GET['id'])) {
                    if ($_GET['id'] != '') {
                        $adminId = $_GET['id'];
                    } else {
                        echo 'ID Tidak Ditemukan!';
                        return false;
                    }
                } else {
                    echo '<h5>Tidak ada ID yang diberikan!</h5>';
                    return false;
                }

                
                $adminData = getById('admin', $adminId);
                if ($adminData) {
                    if ($adminData['status'] == 200) {
                        ?>
                        <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>">
                        <div class="row">
                        <div class="col-md-12 mb-3">
                                <label for="name1">Nama </label>
                                <input type="text" name="nama" required value="<?= $adminData['data']['nama']; ?>" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="name2">Email</label>
                                <input type="email" name="email" required value="<?= $adminData['data']['email']; ?>" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="name2">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="name2">No Telp</label>
                                <input type="number" name="no_telp" required value="<?= $adminData['data']['no_telp']; ?>" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="name2" class="text-danger">BAN</label>
                    </br>
                                <input type="checkbox" name="is_ban" <?= $adminData['data']['is_ban'] == true ? 'checked':''; ?> style="width:30px;height:30px;">
                            </div>
                        </div>
                        <?php
                    } else {

                    }
                } else {
                    echo 'Ada sesuatu yang salah!';
                    return false;
                }
                ?>

                <div class="col-md-12 mb-3 text-end">
                    <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                </div>


        </div>
    </div>
</div>
<?php include ('includes/footer.php'); ?>