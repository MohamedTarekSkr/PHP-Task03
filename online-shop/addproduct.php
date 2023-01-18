<?php
define('BASE_PATH', './');
require_once('./logic/products.php');
require_once('./logic/cart.php');
if (isset($_GET['id'])) {
    $product = getProductById($_GET['id']);
    if ($product) {
        addProductToCart($product);
    }
}
header('Location:cart.php');
?>