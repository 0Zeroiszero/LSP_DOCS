<?php
include_once '../model/database.php';
include_once '../model/login-validator.php';

if (isset($_POST['password']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $validator = new LoginValidator($conn);
    $validator->validate($username, $password);

    header("Location: /kasir");
    exit;
}

?>