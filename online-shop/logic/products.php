<?php
require_once(BASE_PATH . 'dal/dal.php');
function getProducts($where = '1=1', $limit = '')
{
    $query = "SELECT p.*,c.name category_name,s.name size_name,cl.name color_name,r.rating,r.rating_count FROM 
    products p JOIN categories c ON p.category_id=c.id
    JOIN sizes s on s.id = p.size_id
    JOIN colors cl on cl.id = p.color_id
	LEFT JOIN (SELECT product_id,AVG(rate) rating,COUNT(0) rating_count FROM `ratings` GROUP BY product_id) r ON r.product_id = p.id
    WHERE $where 
    $limit";
    return get_rows($query);
}

function display_product($product, $class = 'col-lg-3 col-md-4 col-sm-6 pb-1')
{
    return '<div class="' . $class . '">
    <div class="product-item bg-light mb-4">
        <div class="product-img position-relative overflow-hidden">
            <img class="img-fluid w-100" src="' . $product['image_url'] . '" alt="" />
            <div class="product-action">
                <a class="btn btn-outline-dark btn-square" href="addproduct.php?id=' . $product['id'] . '"><i class="fa fa-shopping-cart"></i></a>
                <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-sync-alt"></i></a>
                <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-search"></i></a>
            </div>
        </div>
        <div class="text-center py-4">
            <a class="h6 text-decoration-none text-truncate" href="">' . $product['name'] . '</a>
            <div class="d-flex align-items-center justify-content-center mt-2">
                <h5>$' . ($product['price'] - ($product['price'] * $product['discount'])) . '</h5>
                <h6 class="text-muted ml-2"><del>$' . $product['price'] . '</del></h6>
            </div>
            <div class="d-flex align-items-center justify-content-center mb-1">
                <small class="fa fa-star text-primary mr-1"></small>
                <small class="fa fa-star text-primary mr-1"></small>
                <small class="fa fa-star text-primary mr-1"></small>
                <small class="fa fa-star text-primary mr-1"></small>
                <small class="fa fa-star text-primary mr-1"></small>
                <small>(' . $product['rating_count'] . ')</small>
            </div>
        </div>
    </div>
</div>';
}

function deleteProduct($id)
{
    $query = "DELETE FROM products WHERE id=$id";
    try {
        $result = execute($query);
    } catch (Exception $e) {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $_SESSION['error_message'] = "Error while deleting the product";
        $result = false;
        //$e->getMessage();
    }
    return $result;
}

function addProduct($values)
{
    $query = "INSERT INTO products (name,description,price,discount,image_url
,category_id,size_id,color_id,is_recent,is_featured,bar_code) VALUES (
        '" . $values['name'] . "','" . $values['description'] . "'," . $values['price'] . ",
        " . $values['discount'] . ",'" . $values['image_url'] . "'," . $values['category_id'] . "
        ," . $values['size_id'] . "," . $values['color_id'] . "," . $values['is_recent'] . "," . $values['is_featured'] . "
        ," . ($values['bar_code'] ? "'" . $values['bar_code'] . "'" : 'NULL') . ")";

    return execute($query);
}

function getProductById($id)
{
    $q = "SELECT * FROM products WHERE id=$id";
    return get_row($q);
}
function editProduct($values)
{
    $query = "UPDATE products SET 
    name='" . $values['name'] . "'
    ,description='" . $values['description'] . "'
    ,price=" . $values['price'] . "
    ,discount=" . $values['discount'] . "
    ,image_url='" . $values['image_url'] . "'
    ,category_id=" . $values['category_id'] . "
    ,size_id=" . $values['size_id'] . "
    ,color_id=" . $values['color_id'] . "
    ,is_recent=" . $values['is_recent'] . "
    ,is_featured=" . $values['is_featured'] . "
    ,bar_code=" . ($values['bar_code'] ? "'" . $values['bar_code'] . "'" : 'NULL') . "
    WHERE id=" . $values['id'];
    var_export($query);
    return execute($query);
}

function getProductsByFilter($page, $itemPerPage, $category_id, $keyword, $colors, $sizes, $prices)
{

    $limit = " limit " . ($page * $itemPerPage) . ",$itemPerPage";
    return getProducts(getWhere($category_id, $keyword, $colors, $sizes, $prices), $limit);
}

function getTotalCountByFilter($category_id, $keyword, $colors, $sizes, $prices)
{
    $q = "SELECT COUNT(0) AS cnt FROM products WHERE " . getWhere($category_id, $keyword, $colors, $sizes, $prices);
    return get_row($q)['cnt'];
}

function getWhere($category_id, $keyword, $colors, $sizes, $prices)
{
    $where = '1=1';
    if ($category_id) {
        $where .= " AND category_id=$category_id";
    }
    if ($keyword) {
        $where .= " AND p.name like '%$keyword%'";
    }
    if ($colors && !in_array('0', $colors)) {
        $where .= " AND color_id in (" . implode(',', $colors) . ")";
    }
    if ($sizes && !in_array('0', $sizes)) {
        $where .= " AND size_id in (" . implode(',', $sizes) . ")";
    }
    if ($prices && !in_array('0', $prices)) {
        $where .= " AND (" . implode(' OR ', array_map(fn($item) => "(price between " . str_replace('-', ' and ', $item) . ")", $prices)) . ")";
    }
    return $where;
}