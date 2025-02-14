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

$update_status = $crud->update('penjualan', 'PenjualanID','TanggalPenjualan', 'TotalHarga', 'PelangganID');
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
    <title>UPDATE Transaksi Data</title>
    <link rel="stylesheet" href="../assets/css/kelola_user.css">
</head>

<body>

</body>

</html>

<div class="form-container">
    <a href="/kasir/view/kelola_transaksi.php" style="text-decoration: none; color: white;">
        <button style="margin-bottom: 10px; font-weight: bold; background-color: red; width:100%;">&lt; KEMBALI</button>
    </a>
    <?= isset($info) ? $info : '';?>
    <form method="post">
    <form action="../controller/create.php" method="post">
            <label for="TanggalPenjualan">Tanggal Penjualan:</label><br>
            <input type="date" id="TanggalPenjualan" name="TanggalPenjualan" value="<?php
                                                                                                $TanggalPenjualan = $crud->read('penjualan', 'PenjualanID', 'TanggalPenjualan');
                                                                                                print_r($TanggalPenjualan[0]['TanggalPenjualan']); ?>"  required><br>

            <label for="TotalHarga">Total harga:</label><br>
            <input type="text" id="TotalHarga" name="TotalHarga" value="<?php
                                                                                                $TotalHarga = $crud->read('penjualan', 'PenjualanID', 'TotalHarga');
                                                                                                print_r($TotalHarga[0]['TotalHarga']); ?>" required><br>

            <label for="PelangganID">Pilih pelanggan id:</label><br>
            <select id="PelangganID" name="PelangganID" required>
                <?php
                $pelanggan_data = $crud->read("pelanggan", '', "PelangganID", "NamaPelanggan");
                
                foreach ($pelanggan_data as $pelanggan_data_row)
                {
                    echo  "<option value=\"{$pelanggan_data_row['PelangganID']}\">{$pelanggan_data_row['PelangganID']} - {$pelanggan_data_row['NamaPelanggan']}</option>";
                }
                ?>
        </select><br>
    
        <button type="submit" class="tambah">Update data</button>
    </form>
</div>