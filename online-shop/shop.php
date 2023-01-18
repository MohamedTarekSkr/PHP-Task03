<?php
define('BASE_PATH', './');
require_once('./logic/products.php');
require_once('./logic/colors.php');
require_once('./logic/sizes.php');

$page = isset($_GET['page']) ? $_GET['page'] : 0;
$itemPerPage = isset($_GET['itemPerPage']) ? $_GET['itemPerPage'] : 9;


$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;
$colors = isset($_GET['colors']) ?$_GET['colors'] : null;
$sizes = isset($_GET['sizes']) ? $_GET['sizes'] : null;
$prices = isset($_GET['prices']) ? $_GET['prices'] : null;

$products = getProductsByFilter($page, $itemPerPage, $category_id, $keyword, $colors, $sizes, $prices);
$totalCount = getTotalCountByFilter($category_id, $keyword, $colors, $sizes, $prices);

$page_count = ceil($totalCount / $itemPerPage);

$_colors = getColors();
$_sizes = getSizes();

$getPageUrl = function ($i) use ($itemPerPage, $category_id, $keyword, $colors, $sizes, $prices) {
    return $_SERVER['PHP_SELF'] . '?' . http_build_query([
        'page' => $i,
        'itemPerPage' => $itemPerPage,
        'category_id' => $category_id,
        'keyword' => $keyword,
        'colors' => $colors,
        'sizes' => $sizes,
        'prices' => $prices
    ]);
};

$getHasSize = function ($s) use ($sizes) {
    return $sizes && in_array($s, $sizes);
};

$getHasColor = function ($c) use ($colors) {
    return $colors && in_array($c, $colors);
};

$getHasPrice = function ($p) use ($prices) {
    return $prices && in_array($p, $prices);
};

require_once('./layouts/header.php');
?>
<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Shop List</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<form method="get" action="<?=htmlspecialchars($_SERVER['PHP_SELF']) ?>">
<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                    price</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-all" name="prices[]" value="0" <?=$getHasPrice('0')?'checked':''?>>
                        <label class="custom-control-label" for="price-all">All Price</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-1"  name="prices[]" value="0-100"  <?=$getHasPrice('0-100')?'checked':''?>>
                        <label class="custom-control-label" for="price-1">$0 - $100</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-2"  name="prices[]" value="100-200"  <?=$getHasPrice('100-200')?'checked':''?>>
                        <label class="custom-control-label" for="price-2">$100 - $200</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-3"  name="prices[]" value="200-300"  <?=$getHasPrice('200-300')?'checked':''?>>
                        <label class="custom-control-label" for="price-3">$200 - $300</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-4"  name="prices[]" value="300-400"  <?=$getHasPrice('300-400')?'checked':''?>>
                        <label class="custom-control-label" for="price-4">$300 - $400</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-control-input" id="price-5"  name="prices[]" value="400-500"  <?=$getHasPrice('400-500')?'checked':''?>>
                        <label class="custom-control-label" for="price-5">$400 - $500</label>
                    </div>
                </form>
            </div>
            <!-- Price End -->

            <!-- Color Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                    color</span></h5>
            <div class="bg-light p-4 mb-30">
                
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input name="colors[]" value="0" type="checkbox" class="custom-control-input" id="color-all"  <?=$getHasColor('0')?'checked':''?>>
                        <label class="custom-control-label" for="color-all" >All Color</label>
                    </div>
                    <?php
                    foreach ($_colors as $c) {
                        ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input value="<?=$c['id']?>" type="checkbox" class="custom-control-input" name="colors[]" id="color-<?=$c['id']?>" <?=$getHasColor($c['id'])?'checked':''?>>
                            <label class="custom-control-label" for="color-<?=$c['id']?>"><?= $c['name'] ?></label>
                        </div>
                        <?php
                    }
                    ?>
                    
                
            </div>
            <!-- Color End -->

            <!-- Size Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by
                    size</span></h5>
            <div class="bg-light p-4 mb-30">
                
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input name="sizes[]" value="0" type="checkbox" class="custom-control-input" id="size-all" <?=$getHasSize('0')?'checked':''?>>
                        <label class="custom-control-label" for="size-all">All Size</label>
                    </div>
                    <?php
                    foreach ($_sizes as $s) {
                        ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input  value="<?=$s['id']?>" type="checkbox" class="custom-control-input" name="sizes[]" id="size-<?=$s['id']?>" <?=$getHasSize($s['id'])?'checked':''?>>
                            <label class="custom-control-label" for="size-<?=$s['id']?>"><?= $s['name'] ?></label>
                            
                        </div>
                        <?php
                    }
                    ?>
                
            </div>
            <!-- Size End -->
            <button class="btn btn-block btn-primary">Filter</button>
        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                            <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                        </div>
                        <div class="ml-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                    data-toggle="dropdown">Sorting</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Latest</a>
                                    <a class="dropdown-item" href="#">Popularity</a>
                                    <a class="dropdown-item" href="#">Best Rating</a>
                                </div>
                            </div>
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                    data-toggle="dropdown">Showing</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">10</a>
                                    <a class="dropdown-item" href="#">20</a>
                                    <a class="dropdown-item" href="#">30</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                foreach ($products as $product) {
                    echo display_product($product, 'col-lg-4 col-md-6 col-sm-6 pb-1');
                }

                ?>
                <div class="col-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?=($page <= 0 ? 'disabled' : '') ?>"><a class="page-link"
                                    href="<?=$getPageUrl($page-1)?>">Previous</span></a></li>
                            <?php
                            for ($i = 0; $i < $page_count; $i++) {
                                echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="'.$getPageUrl($i).'">' . ($i + 1) . '</a></li>';
                            }
                            ?>
                            <li class="page-item <?=($page >= ($page_count - 1) ? 'disabled' : '') ?>"><a
                                    class="page-link" href="<?=$getPageUrl($page+1)?>">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->

<input name="page" value="<?=$page?>"  type="hidden"/>
<input name="itemPerPage" value="<?=$itemPerPage?>"  type="hidden"/>
<input name="category_id" value="<?=$category_id?>"  type="hidden"/>
<input name="keyword" value="<?=$keyword?>"  type="hidden"/>
</form>
<?php require('./layouts/footer.php'); ?>