<?php

include_once '../model/database.php';
include_once '../model/login-validator.php';
include_once '../model/database_crud.php';

$crud = new DatabaseCRUD($conn);
$validator = new LoginValidator($conn);

if (!$validator->check_login_status('login')) {
    header("Location: /kasir");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Transaksi</title>
    <link rel="stylesheet" href="../assets/css/kelola_user.css">
</head>

<body>

    <div class="container">
        <h1>Kelola Transaksi</h1>
        <a href="/kasir" style="text-decoration: none; color: white;">
            <button style="margin-bottom: 10px; font-weight: bold; background-color: red; width:100%;">&lt; KEMBALI</button>
        </a>
        <div class="overflow">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Transaksi ID</th>
                        <th>Tanggal Penjualan</th>
                        <th>Total Harga</th>
                        <th>Pelanggan ID</th>
                        <th>Edit atau Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $data = $crud->read("penjualan", '', "PenjualanID", "TanggalPenjualan", "TotalHarga", "PelangganID");

                    $no = 1;

                    foreach ($data as $row) {
                        echo "<tr>";

                        echo "<td>{$no}</td>";

                        echo "<td>{$row['PenjualanID']}</td>";

                        echo "<td>{$row['TanggalPenjualan']}</td>";

                        echo "<td>{$row['TotalHarga']}</td>";

                        echo "<td>{$row['PelangganID']}</td>";

                        echo "<td>";
                        echo "<a href='../controller/transaksi_update.php?PenjualanID={$row['PenjualanID']}'><button class='edit'>Edit</button></a> ";
                        echo "<a href='../controller/transaksi_delete.php?PenjualanID={$row['PenjualanID']}'><button>Hapus</button></a>";
                        echo "</td>";

                        echo "</tr>";

                        $no++;
                    }

                    ?>
                </tbody>
            </table>
        </div>
        <div class="form-container">
            <?= "<a href='../controller/transaksi_print.php'><button style='background-color: blue;'>🖨️ PRINT SELURUH DATA TRANSAKSI</button></a>" ?>
            
            <h2 style="margin-bottom: 10px;">INPUT DATA</h2>
            <?php 
            if (isset($_SESSION['create-success']))
            {
                echo $_SESSION['create-success'];
                unset($_SESSION['create-success']);
            } else if (isset($_SESSION['create-error']))
            {
                echo $_SESSION['create-error'];
                unset($_SESSION['create-error']);
            }
            ?>
            <form action="../controller/create.php" method="post">

            <label for="TanggalPenjualan">Tanggal Penjualan:</label><br>
            <input type="date" id="TanggalPenjualan" name="TanggalPenjualan" value="<?= date("Y-m-d") ?>" required><br>

            <label for="TotalHarga">Total harga:</label><br>
            <input type="number" id="TotalHarga" name="TotalHarga" placeholder="Enter total harga" required><br>

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
    </div>
</body>

</html>