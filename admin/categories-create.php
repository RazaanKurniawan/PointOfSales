<?php 

include('includes/header.php'); 

if ($_SESSION['loggedInUser']['level'] != 'Admin' && $_SESSION['loggedInUser']['level'] != 'Manajer') {
    echo '<script>window.location.href = "index.php";</script>';
    exit();
}

?>

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0 text-center">Tambahkan Kategori
                <a href="categories.php" class="btn btn-danger float-end"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</a>
            </h4>
        </div>
        <div class="card-body">
        <?php alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Nama </label>
                        <input type="text" name="name" required class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- <div class="col-md-6">
                        <label>Status (Unchecked=Visible, Checked=Hidden)</label>
                        <br />
                        <input type="checkbox" name="status" style="width:3Øpx;height:30px">
                    </div> -->


                    <div class="col-md-6 mb-3 text-end">
                        <br>
                        <button type="submit" name="saveCategory" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> Save</button>
                    </div>


        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>