<?php

include_once 'model/database.php';
include_once 'model/login-validator.php';
include_once 'model/database_crud.php';

$validator = new LoginValidator($conn);
$crud = new DatabaseCRUD($conn);

$total_users = $crud->count_data('staff_kasir', 'user_id');
$total_barang = $crud->count_data('produk', 'ProdukID');
$total_detail_penjualan = $crud->count_data('detailpenjualan', 'DetailID');
$total_pelanggan = $crud->count_data('pelanggan', 'PelangganID');
$total_penjualan = $crud->count_data('penjualan', 'PenjualanID');

if (!$validator->check_login_status('login')) {
    header("Location: /kasir");
    exit;
}

$name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Staff';

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/dashboard.css">
    <title>Dashboard - Staff</title>
</head>

<body>
    <div class="container">
        <h1 class="overflow"><?php echo ("Selamat Datang, " . htmlentities($name)); ?></h1>

        <a href="controller/logout.php" style="text-decoration: none; color: white;">
            <button>LOGOUT</button>
        </a>

        <div class="menu-container">

            <?php
            if ($_SESSION['role'] == 'administrator')
            {

                echo
                '
            <a href="view/kelola_user.php">
                <div class="menu-box">
                <span class="badge">'.$total_users.'</span>
                <span class="icon">&#128100;</span>
                <p>Kelola user</p>
                </div>
            </a>
            ';
            }
            
            ?>

            <a href="view/kelola_barang.php">
            <div class="menu-box">
                <span class="badge"><?= $total_barang; ?></span>
                <span class="icon">&#128230;</span>
                <p>Kelola barang</p>
            </div>
            </a>

            <a href="view/kelola_penjualan.php">
            <div class="menu-box">
                <span class="badge"><?= $total_detail_penjualan; ?></span>
                <span class="icon">&#128179;</span>
                <p>Kelola penjualan</p>
            </div>
            </a>

            <a href="view/kelola_transaksi.php">
            <div class="menu-box">
                <span class="badge"><?= $total_penjualan; ?></span>
                <span class="icon">&#128220;</span>
                <p>Kelola transaksi</p>
            </div>
            </a>

            <a href="view/kelola_pelanggan.php">
            <div class="menu-box">
                <span class="badge"><?= $total_pelanggan; ?></span>
                <span class="icon">&#128101;</span>
                <p>Kelola pelanggan</p>
            </div>
            </a>

        </div>
    </div>
</body>

</html>