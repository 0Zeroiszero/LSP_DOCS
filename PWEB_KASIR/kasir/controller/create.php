<?php

include_once '../model/database.php';
include_once '../model/login-validator.php';
include_once '../model/database_crud.php';

$validator = new LoginValidator($conn);
$validator->check_login_status('login');

$crud = new DatabaseCRUD($conn);

if (isset($_POST['password']))
{
    $crud->create('staff_kasir', true, 'username', 'password', 'peran');
    header('Location: ../view/kelola_user.php');
    exit;
}

if (isset($_POST['NamaProduk']))
{
    $crud->create('produk', '', 'NamaProduk', 'Harga', 'Stok');
    header('Location: ../view/kelola_barang.php');
    exit;
}

if (isset($_POST['PelangganID']) && !isset($_POST['NomorTelepon']))
{
    $crud->create('penjualan', '', 'TanggalPenjualan', 'TotalHarga', 'PelangganID');
    header('Location: ../view/kelola_transaksi.php');
    exit;
}

if (isset($_POST['NomorTelepon']))
{
    $crud->create('pelanggan', '', 'NamaPelanggan', 'Alamat', 'NomorTelepon');
    header('Location: ../view/kelola_pelanggan.php');
    exit;
}

if (isset($_POST['Subtotal']))
{
    $crud->create('detailpenjualan', '', 'PenjualanID', 'ProdukID', 'JumlahProduk', 'Subtotal');
    header('Location: ../view/kelola_penjualan.php');
    exit;
}