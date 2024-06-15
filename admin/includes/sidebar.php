<?php

$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);

?>
<style>
    .bg-darkgreen {
        background-color: #28B463;
    }

    ;
</style>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark bg-darkgreen" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Bagian Utama</div>
                <a class="nav-link <?= $page == 'index.php' ? 'active' : ''; ?>" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Beranda
                </a>
                <a class="nav-link <?= $page == 'orders-create.php' ? 'active' : ''; ?>" href="orders-create.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                    Buat Pesanan
                </a>
                <a class="nav-link <?= $page == 'orders.php' ? 'active' : ''; ?>" href="orders.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Pesanan
                </a>
                <a class="nav-link <?= $page == 'display-product.php' ? 'active' : ''; ?>" href="display-product.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div>
                    Detail Produk
                </a>

                <div class="sb-sidenav-menu-heading">Produk & Kategori</div>

                <a class="nav-link <?= $page == 'categories.php' ? 'active' : ''; ?>" href="categories.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                    Kategori
                </a>
                <a class="nav-link <?= $page == 'products.php' ? 'active' : ''; ?>" href="products.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-cube"></i></div>
                    Produk
                </a>
                

                <!-- <a class="nav-link <?= ($page == 'categories-create.php') || ($page == 'categories.php') ? 'collapse active' : 'collapsed'; ?>"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseCategories" aria-expanded="false"
                    aria-controls="collapseCategories">
                    <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                    Categories
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse 
                <?= ($page == 'categories-create.php') || ($page == 'categories.php') ? 'show' : ''; ?>"
                    id="collapseCategories" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'categories-create.php' ? 'active' : ''; ?>"
                            href="categories-create.php">Create Category</a>
                        <a class="nav-link <?= $page == 'categories.php' ? 'active' : ''; ?>" href="categories.php">View
                            Category</a>
                    </nav>
                </div>

                <a class="nav-link <?= ($page == 'products-create.php') || ($page == 'products.php') ? 'collapse active' : 'collapsed'; ?>"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseProducts" aria-expanded="false"
                    aria-controls="collapseProducts">
                    <div class="sb-nav-link-icon"><i class="fas fa-cube"></i></div>
                    Products
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == 'products-create.php') || ($page == 'products.php') ? 'show' : ''; ?>"
                    id="collapseProducts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'products-create.php' ? 'active' : ''; ?>"
                            href="products-create.php">Create Products</a>
                        <a class="nav-link <?= $page == 'products.php' ? 'active' : ''; ?>" href="products.php">View
                            Products</a>
                    </nav>
                </div> -->

                <div class="sb-sidenav-menu-heading">Kelola Pengguna</div>

                <a class="nav-link <?= $page == 'login-history.php' ? 'active' : ''; ?>" href="login-history.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Riwayat Login
                </a>

                <a class="nav-link <?= $page == 'customers.php' ? 'active' : ''; ?>" href="customers.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Pelanggan
                </a>
                <?php
                if ($_SESSION['loggedInUser']['level'] == 'Admin') {
                    ?>
                    <a class="nav-link <?= $page == 'admin.php' ? 'active' : ''; ?>" href="admin.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                        Administrator/Pekerja
                    </a>
                <?php } ?>

                <!-- <a class="nav-link <?= ($page == 'customers-create.php') || ($page == 'customers.php') ? 'collapse active' : 'collapsed'; ?>"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseCustomer" aria-expanded="false"
                    aria-controls="collapseCustomer">

                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Customer
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == 'customers-create.php') || ($page == 'customers.php') ? 'show' : ''; ?>"
                    id="collapseCustomer" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == 'customers-create.php' ? 'active' : ''; ?>"
                            href="customers-create.php">Tambah Pelanggan</a>
                        <a class="nav-link <?= $page == 'customers.php' ? 'active' : ''; ?>" href="customers.php">View
                            Pelanggan</a>
                    </nav>
                </div>

                <?php
                if ($_SESSION['loggedInUser']['level'] != 'Staff') {
                    ?>
                    <a class="nav-link <?= ($page == 'admin-create.php') || ($page == 'admin.php') ? 'collapse active' : 'collapsed'; ?>"
                        href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmin" aria-expanded="false"
                        aria-controls="collapseAdmin">

                        <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                        Admin/Staff
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse <?= ($page == 'admin-create.php') || ($page == 'admin.php') ? 'show' : ''; ?>"
                        id="collapseAdmin" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link <?= $page == 'admin-create.php' ? 'active' : '' ?>"
                                href="admin-create.php">Tambah Admin</a>
                            <a class="nav-link <?= $page == 'admin.php' ? 'active' : ''; ?>" href="admin.php">View Admin</a>
                        </nav>
                    </div>
                <?php } ?> -->

            </div>
        </div>
        <style>
            .bg-green {
                background-color: #24DF00;
            };
        </style>
        <div class="sb-sidenav-footer bg-success">
            <div class="small">Masuk sebagai:</div>
            <?= $_SESSION['loggedInUser']['nama'] ?> | <?= $_SESSION['loggedInUser']['level'] ?>
        </div>
    </nav>
</div>