<?php
include_once 'model/database.php';
include_once 'model/login-validator.php';

$validator = new LoginValidator($conn);

if (!$validator->check_login_status('login')) {

  if (isset($_SESSION['login_err']))
  {
    $login_err = '<p style="margin-bottom: 10px; color: red;">Username dan Password Salah</p>';
  }

  include_once 'view/login.php';

} else {
  include_once 'view/dashboard.php';
}

?>