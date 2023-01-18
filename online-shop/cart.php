<?php
define('BASE_PATH', './');
require_once('./logic/cart.php');
$products = getCart();
// foreach($products as $product){
//     var_export($product);
// };
// die();
$subTotal = subTotal();
$shipping = shipping();
$total = total();
require_once('./layouts/header.php');
?>
<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Shopping Cart</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle" id="products">
                    <?php
foreach ($products as $product){
    ?>
                    <tr>
                        <td class="align-middle">
                            <img src="<?= $product['product']['image_url']?>" alt="" style="width: 50px" />
                            <?=$product['product']['name']?>
                        </td>
                        <td class="align-middle">
                            $<?=$product['product']['price'] * (1-$product['product']['discount'])?></td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px">
                                <div class="input-group-btn">
                                    <a type="button" class="decBtn btn btn-sm btn-primary btn-minus"
                                        href="decQuantity.php?id=<?=$product['product']['id']?>">
                                        <i class="fa fa-minus"></i>
                                    </a>
                                </div>
                                <input type="text"
                                    class="quantityVal form-control form-control-sm bg-secondary border-0 text-center"
                                    value="<?=$product['quantity']?>" />
                                <div class="input-group-btn">
                                    <a type="button" class="incBtn btn btn-sm btn-primary btn-plus"
                                        href="addproduct.php?id=<?=$product['product']['id']?>">
                                        <i class=" fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">$<?=$subTotal?></td>
                        <td class="align-middle">
                            <a class="btn btn-sm btn-danger" type="button"
                                href="delete.php?id=<?=$product['product']['id']?>">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>

                    <?php    
                    }?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <form class="mb-30" action="">
                <div class="input-group">
                    <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code" />
                    <div class="input-group-append">
                        <button class="btn btn-primary">Apply Coupon</button>
                    </div>
                </div>
            </form>
            <h5 class="section-title position-relative text-uppercase mb-3">
                <span class="bg-secondary pr-3">Cart Summary</span>
            </h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6 id="sub-total">$<?=$subTotal?></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium" id="shipping">$<?=$shipping?></h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>$<?=$total?></h5>
                        <h5 id="total"></h5>
                    </div>
                    <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">
                        Proceed To Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
<?php
require_once('./layouts/footer.php');