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

    <title>Kelola Barang</title>
    <link rel="stylesheet" href="../assets/css/kelola_user.css">
</head>

<body>

    <div class="container">
        <h1>Kelola Barang</h1>
        <a href="/kasir" style="text-decoration: none; color: white;">
            <button style="margin-bottom: 10px; font-weight: bold; background-color: red; width:100%;">&lt; KEMBALI</button>
        </a>
        <div class="overflow">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Produk ID</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Edit atau Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $data = $crud->read("produk", '', "ProdukID", "NamaProduk", "Harga", "Stok");

                    $no = 1;

                    foreach ($data as $row) {
                        echo "<tr>";

                        echo "<td>{$no}</td>";

                        echo "<td>{$row['ProdukID']}</td>";

                        echo "<td>{$row['NamaProduk']}</td>";

                        echo "<td>{$row['Stok']}</td>";

                        echo "<td>{$row['Harga']}</td>";

                        echo "<td>";
                        echo "<a href='../controller/barang_update.php?ProdukID={$row['ProdukID']}'><button class='edit'>Edit</button></a> ";
                        echo "<a href='../controller/barang_delete.php?ProdukID={$row['ProdukID']}'><button>Hapus</button></a>";
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

            <label for="NamaProduk">Nama produk:</label><br>
            <input type="text" id="NamaProduk" name="NamaProduk" placeholder="Enter nama produk" required><br>

            <label for="Harga">Harga produk:</label><br>
            <input type="number" id="Harga" name="Harga" placeholder="Enter harga" required><br>

            <label for="Stok">Stok produk:</label><br>
            <input type="text" id="Stok" name="Stok" placeholder="Enter stok" required><br>


            <button type="submit" class="tambah">Update data</button>
            </form>
        </div>
    </div>
</body>

</html>