<?php
require_once(BASE_PATH.'dal/dal.php');
function getCategories()
{
    return get_rows("SELECT c.*,IFNULL(p.product_count,0) product_count FROM categories c 
    LEFT JOIN (SELECT COUNT(0) product_count,category_id FROM products) p ON c.id=p.category_id");
}