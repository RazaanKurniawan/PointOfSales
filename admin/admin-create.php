<?php include('includes/header.php'); 
if (($_SESSION['loggedInUser']['level'] != 'Admin')) {

    echo '<script>window.location.href = "index.php";</script>';

}
?>

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0 text-center">Tambahkan Admin
                <a href="admin.php" class="btn btn-danger float-end"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
            </h4>
        </div>
        <div class="card-body">
        <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name1">Nama </label>
                        <input type="text" name="nama" required class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name2">Email</label>
                        <input type="email" name="email" required class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name2">Password</label>
                        <input type="password" name="password" required class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name2">No Telp</label>
                        <input type="number" name="no_telp" required class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name2">Role</label>
                        <select name="level" id="level" class="form-select">
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff</option>
                            <option value="Owner">Owner</option>
                        </select>
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="name2" class="text-danger ">BAN</label>
                        </br>
                        <input type="checkbox" name="is_ban" style="width:30px;height:30px;">
                    </div>
                </div>
                <div class="col-md-12 mb-3 text-end">
                    <button type="submit" name="saveAdmin" class="btn btn-primary">Save</button>
         </div>


        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>