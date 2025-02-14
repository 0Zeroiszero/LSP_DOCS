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

$update_status = $crud->update('staff_kasir', 'user_id', 'username', 'password', 'peran');
if ($update_status)
{
    $info = '<p style="color: green;">BERHASIL DIUPDATE</p>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE User Data</title>
    <link rel="stylesheet" href="../assets/css/kelola_user.css">
</head>

<body>

</body>

</html>

<div class="form-container">
    <a href="/kasir/view/kelola_user.php" style="text-decoration: none; color: white;">
        <button style="margin-bottom: 10px; font-weight: bold; background-color: red; width:100%;">&lt; KEMBALI</button>
    </a>
    <?= isset($info) ? $info : '';?>
    <form method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" placeholder="Enter username" value="<?php
                                                                                                $name = $crud->read('staff_kasir', 'user_id', 'username');
                                                                                                print_r($name[0]['username']); ?>" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" placeholder="Enter password" required><br>

        <label for="peran">Pilih role:</label><br>
        <select id="peran" name="peran" required>
            <option value="administrator">Administrator</option>
            <option value="petugas">Petugas</option>
        </select><br>

        <button type="submit" class="tambah">Update data</button>
    </form>
</div>