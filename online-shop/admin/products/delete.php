<?php
define('BASE_PATH', '../../');
require_once('../../logic/authentication.php');
protectAdmin();
require_once('../../logic/products.php');
if (isset($_REQUEST['id']) && $_REQUEST['id'])
  deleteProduct($_REQUEST['id']);
header('Location:index.php');
die();
?>