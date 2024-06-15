<?php
require '../config/function.php';
require 'authentication.php';

$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>
        <?= $page == 'index.php' ? 'Dashboard' : ''; ?>
        <?= $page == 'admin-create.php' ? 'Tambah Admin' : ''; ?>
        <?= $page == 'admin-edit.php' ? 'Ubah Admin' : ''; ?>
        <?= $page == 'admin.php' ? 'Administrator' : ''; ?>
        <?= $page == 'categories.php' ? 'Kategori' : ''; ?>
        <?= $page == 'categories-create.php' ? 'Tambah Kategori' : ''; ?>
        <?= $page == 'categories-edit.php' ? 'Ubah Kategori' : ''; ?>
        <?= $page == 'customers-create.php' ? 'Tambah Pelanggan' : ''; ?>
        <?= $page == 'customers-edit.php' ? 'Ubah Pelanggan' : ''; ?>
        <?= $page == 'customers.php' ? 'Pelanggan' : ''; ?>
        <?= $page == 'orders-create.php' ? 'Tambah Pesanan' : ''; ?>
        <?= $page == 'orders-summary.php' ? 'Nota' : ''; ?>
        <?= $page == 'orders-view-print.php' ? 'Print Nota' : ''; ?>
        <?= $page == 'orders-view.php' ? 'Lampiran Pesanan' : ''; ?>
        <?= $page == 'orders.php' ? 'Pesanan' : ''; ?>
        <?= $page == 'products-create.php' ? 'Tambah Produk' : ''; ?>
        <?= $page == 'products-edit.php' ? 'Ubah Produk' : ''; ?>
        <?= $page == 'products.php' ? 'Produk' : ''; ?>
        <?= $page == 'display-product.php' ? 'Detail Produk' : ''; ?>
        <?= $page == 'orders-summary-onlinepay.php' ? 'Pembayaran Online' : ''; ?>
    </title>

    <!-- DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />

    <!-- Alertify CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css" />

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom and Vendor CSS -->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/custom.css" rel="stylesheet" />
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="assets/images/color-logo.png">

    <!-- Themify Icons and FontAwesome -->
    <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="assets/icon/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">

    <!-- Custom styles for this template-->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="sb-nav-fixed">

    <?php include ('navbar.php'); ?>

    <div id="layoutSidenav">

        <?php include ('sidebar.php'); ?>

        <div id="layoutSidenav_content">

            <main>