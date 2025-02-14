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

    <title>Kelola Penjualan</title>
    <link rel="stylesheet" href="../assets/css/kelola_user.css">
</head>

<body>

    <div class="container">
        <h1>Kelola Penjualan</h1>
        <a href="/kasir" style="text-decoration: none; color: white;">
            <button style="margin-bottom: 10px; font-weight: bold; background-color: red; width:100%;">&lt; KEMBALI</button>
        </a>
        <div class="overflow">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Detail ID</th>
                        <th>Penjualan ID</th>
                        <th>Produk ID</th>
                        <th>Jumlah Produk</th>
                        <th>Subtotal</th>
                        <th>Edit atau Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $data = $crud->read("detailpenjualan", '', "DetailID", "PenjualanID", "ProdukID", "JumlahProduk", "Subtotal");

                    $no = 1;

                    foreach ($data as $row) {
                        echo "<tr>";

                        echo "<td>{$no}</td>";

                        echo "<td>{$row['DetailID']}</td>";

                        echo "<td>{$row['PenjualanID']}</td>";

                        echo "<td>{$row['ProdukID']}</td>";

                        echo "<td>{$row['JumlahProduk']}</td>";

                        echo "<td>{$row['Subtotal']}</td>";

                        echo "<td>";
                        echo "<a href='../controller/penjualan_update.php?DetailID={$row['DetailID']}'><button class='edit'>Edit</button></a> ";
                        echo "<a href='../controller/penjualan_delete.php?DetailID={$row['DetailID']}'><button>Hapus</button></a>";
                        echo "</td>";

                        echo "</tr>";

                        $no++;
                    }


                    ?>
                </tbody>
            </table>
        </div>
        <div class="form-container">
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
            <input type="number" id="JumlahProduk" name="JumlahProduk" placeholder="Enter jumlah produk" required><br>
            
            <label for="Subtotal">Subtotal:</label><br>
            <input type="number" id="Subtotal" name="Subtotal" placeholder="Enter subtotal" required><br>

            <button type="submit" class="tambah">Update data</button>
            </form>
        </div>
    </div>
</body>

</html>