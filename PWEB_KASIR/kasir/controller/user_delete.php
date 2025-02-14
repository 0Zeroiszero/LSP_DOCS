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

$crud->delete('staff_kasir', 'user_id');
header('Location: /kasir/view/kelola_user.php');
exit;