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

    <title>Kelola Pelanggan</title>
    <link rel="stylesheet" href="../assets/css/kelola_user.css">
</head>

<body>

    <div class="container">
        <h1>Kelola Pelanggan</h1>
        <a href="/kasir" style="text-decoration: none; color: white;">
            <button style="margin-bottom: 10px; font-weight: bold; background-color: red; width:100%;">&lt; KEMBALI</button>
        </a>
        <div class="overflow">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pelanggan ID</th>
                        <th>Alamat</th>
                        <th>NomorTelepon</th>
                        <th>Edit atau Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $data = $crud->read("pelanggan", '', "PelangganID", "Alamat", "NomorTelepon");

                    $no = 1;

                    foreach ($data as $row) {
                        echo "<tr>";

                        echo "<td>{$no}</td>";

                        echo "<td>{$row['PelangganID']}</td>";

                        echo "<td>{$row['Alamat']}</td>";

                        echo "<td>{$row['NomorTelepon']}</td>";

                        echo "<td>";
                        echo "<a href='../controller/pelanggan_update.php?PelangganID={$row['PelangganID']}'><button class='edit'>Edit</button></a> ";
                        echo "<a href='../controller/pelanggan_delete.php?PelangganID={$row['PelangganID']}'><button>Hapus</button></a>";
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
            <label for="NamaPelanggan">Nama pelanggan:</label><br>
            <input type="text" id="NamaProduk" name="NamaPelanggan" placeholder="Enter nama pelanggan" required><br>

            <label for="Alamat">Alamat:</label><br>
            <input type="text" id="Alamat" name="Alamat" placeholder="Enter alamat" required><br>

            <label for="NomorTelepon">Nomor telepon:</label><br>
            <input type="number" id="NomorTelepon" name="NomorTelepon" placeholder="Enter nomor telepon" required><br>


            <button type="submit" class="tambah">Update data</button>
            </form>
        </div>
    </div>
</body>

</html>