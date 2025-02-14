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

$update_status = $crud->update('detailpenjualan', 'DetailID', 'ProdukID', 'JumlahProduk', 'Subtotal');
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
    <title>UPDATE Penjualan Data</title>
    <link rel="stylesheet" href="../assets/css/kelola_user.css">
</head>

<body>

</body>

</html>

<div class="form-container">
    <a href="/kasir/view/kelola_penjualan.php" style="text-decoration: none; color: white;">
        <button style="margin-bottom: 10px; font-weight: bold; background-color: red; width:100%;">&lt; KEMBALI</button>
    </a>
    <?= isset($info) ? $info : '';?>
    <form method="post">

        <label for="PenjualanID">Pilih penjualan id:</label><br>
        <select id="PenjualanID" name="PenjualanID" required>
            <?php
            $pelanggan_data = $crud->read("penjualan", '', "PenjualanID");
            
            foreach ($pelanggan_data as $pelanggan_data_row)
            {
                echo  "<option value=\"{$pelanggan_data_row['PenjualanID']}\">{$pelanggan_data_row['PenjualanID']}</option>";
            }
            ?>
        </select><br>

        <label for="ProdukID">Pilih produk id:</label><br>
        <select id="ProdukID" name="ProdukID" required>
            <?php
            $pelanggan_data = $crud->read("produk", '', "ProdukID", "NamaProduk");
            
            foreach ($pelanggan_data as $pelanggan_data_row)
            {
                echo  "<option value=\"{$pelanggan_data_row['ProdukID']}\">{$pelanggan_data_row['ProdukID']} - {$pelanggan_data_row['NamaProduk']}</option>";
            }
            ?>
        </select><br>

        <label for="JumlahProduk">Jumlah produk:</label><br>
        <input type="number" id="JumlahProduk" name="JumlahProduk" placeholder="Enter jumlah produk" value="<?php
                                                                                                $jumlah_produk = $crud->read('detailpenjualan', 'ProdukID', 'JumlahProduk');
                                                                                                print_r($jumlah_produk[0]['JumlahProduk']); ?>" required><br>

        <label for="Subtotal">Harga produk:</label><br>
        <input type="number" id="Subtotal" name="Subtotal" placeholder="Enter harga" value="<?php
                                                                                                $subtotal = $crud->read('detailpenjualan', 'ProdukID', 'Subtotal');
                                                                                                print_r($subtotal[0]['Subtotal']); ?>" required><br>

        <button type="submit" class="tambah">Update data</button>
    </form>
</div>