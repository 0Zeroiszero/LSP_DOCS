<?php
include_once '../model/database.php';
include_once '../model/database_crud.php';
include_once '../model/login-validator.php';

$crud = new DatabaseCRUD($conn);
$validator = new LoginValidator($conn);

if (!$validator->check_login_status('login')) {
    header("Location: /kasir");
    exit;
}

$update_status = $crud->update('produk', 'ProdukID', 'NamaProduk', 'Harga', 'Stok');
try{
    if ($update_status)
    {
        $info = '<p style="color: green;">BERHASIL DIUPDATE</p>';
    }
} catch (Exception $e) 
{
    $info = $e;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE Barang Data</title>
    <link rel="stylesheet" href="../assets/css/kelola_user.css">
</head>

<body>

</body>

</html>

<div class="form-container">
    <a href="/kasir/view/kelola_barang.php" style="text-decoration: none; color: white;">
        <button style="margin-bottom: 10px; font-weight: bold; background-color: red; width:100%;">&lt; KEMBALI</button>
    </a>
    <?= isset($info) ? $info : '';?>
    <form method="post">
        <label for="NamaProduk">Nama produk:</label><br>
        <input type="text" id="NamaProduk" name="NamaProduk" placeholder="Enter nama produk" value="<?php
                                                                                                $name = $crud->read('produk', 'ProdukID', 'NamaProduk');
                                                                                                print_r($name[0]['NamaProduk']); ?>" required><br>

        <label for="Harga">Harga produk:</label><br>
        <input type="text" id="Harga" name="Harga" placeholder="Enter harga" value="<?php
                                                                                                $harga = $crud->read('produk', 'ProdukID', 'Harga');
                                                                                                print_r($harga[0]['Harga']); ?>" required><br>

        <label for="Stok">Stok produk:</label><br>
        <input type="text" id="Stok" name="Stok" placeholder="Enter stok" value="<?php
                                                                                                $stok = $crud->read('produk', 'ProdukID', 'Stok');
                                                                                                print_r($stok[0]['Stok']); ?>" required><br>


        <button type="submit" class="tambah">Update data</button>
    </form>
</div>