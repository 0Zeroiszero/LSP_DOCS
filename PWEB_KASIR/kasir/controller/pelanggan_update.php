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

$update_status = $crud->update('pelanggan', 'PelangganID', 'NamaPelanggan', 'Alamat', 'NomorTelepon');
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
    <title>UPDATE Pelanggan Data</title>
    <link rel="stylesheet" href="../assets/css/kelola_user.css">
</head>

<body>

</body>

</html>

<div class="form-container">
    <a href="/kasir/view/kelola_pelanggan.php" style="text-decoration: none; color: white;">
        <button style="margin-bottom: 10px; font-weight: bold; background-color: red; width:100%;">&lt; KEMBALI</button>
    </a>
    <?= isset($info) ? $info : '';?>
    <form method="post">
        <label for="NamaPelanggan">Nama pelanggan:</label><br>
        <input type="text" id="NamaPelanggan" name="NamaPelanggan" placeholder="Enter nama pelanggan" value="<?php
                                                                                                $name = $crud->read('pelanggan', 'PelangganID', 'NamaPelanggan');
                                                                                                print_r($name[0]['NamaPelanggan']); ?>" required><br>

        <label for="Alamat">Alamat:</label><br>
        <input type="text" id="Alamat" name="Alamat" placeholder="Enter alamat" value="<?php
                                                                                                $alamat = $crud->read('pelanggan', 'PelangganID', 'alamat');
                                                                                                print_r($alamat[0]['alamat']); ?>" required><br>

        <label for="NomorTelepon">Nomor telepon:</label><br>
        <input type="number" id="NomorTelepon" name="NomorTelepon" placeholder="Enter nomor telepon" value="<?php
                                                                                                $nomor_telepon = $crud->read('pelanggan', 'PelangganID', 'NomorTelepon');
                                                                                                print_r($nomor_telepon[0]['NomorTelepon']); ?>" required><br>


        <button type="submit" class="tambah">Update data</button>
    </form>
</div>