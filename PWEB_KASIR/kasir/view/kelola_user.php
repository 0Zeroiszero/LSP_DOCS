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

    <title>Kelola User</title>
    <link rel="stylesheet" href="../assets/css/kelola_user.css">
</head>

<body>

    <div class="container">
        <h1>Kelola User</h1>
        <a href="/kasir" style="text-decoration: none; color: white;">
            <button style="margin-bottom: 10px; font-weight: bold; background-color: red; width:100%;">&lt; KEMBALI</button>
        </a>
        <div class="overflow">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Edit atau Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $data = $crud->read("staff_kasir", '', "user_id", "username", "password", "peran");

                    $no = 1;

                    foreach ($data as $row) {
                        echo "<tr>";

                        echo "<td>{$no}</td>";

                        echo "<td>{$row['username']}</td>";

                        echo "<td>{$row['password']}</td>";

                        echo "<td>{$row['peran']}</td>";

                        echo "<td>";
                        echo "<a href='../controller/user_update.php?user_id={$row['user_id']}&from=user'><button class='edit'>Edit</button></a> ";
                        echo "<a href='../controller/user_delete.php?user_id={$row['user_id']}&from=user'><button>Hapus</button></a>";
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
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" placeholder="Enter username" required><br>

                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" placeholder="Enter password" required><br>

                <label for="peran">Pilih role:</label><br>
                <select id="peran" name="peran" required>
                    <option value="administrator">Administrator</option>
                    <option value="petugas">Petugas</option>
                </select><br>

                <button type="submit" class="tambah">Tambah data</button>
            </form>
        </div>
    </div>
</body>

</html>