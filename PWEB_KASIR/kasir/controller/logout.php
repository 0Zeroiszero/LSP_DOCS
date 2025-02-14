<?php

include_once '../model/database.php';
session_destroy();
session_unset();
header('Location: /kasir');
exit;
?>