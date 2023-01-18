<?php
define('BASE_ADMIN_URL', '/online-shop/admin/');
define('BASE_URL', '/online-shop/');
define('BASE_PATH', '../../');
require_once('../../logic/authentication.php');
protectAdmin();
require_once('../../logic/categories.php');
require_once('../../logic/sizes.php');
require_once('../../logic/colors.php');
require_once('../../logic/products.php');
require_once('../../logic/validation.php');
require_once('../../logic/files.php');


$product = false;
if (isset($_GET['id']) && $_GET['id']) {
  $product = getProductById($_GET['id']);
}
if (!$product) {
  header('Location:index.php');
  die();
}
$values = $product;

if (session_status() === PHP_SESSION_NONE)
  session_start();



$categories = getCategories();
$colors = getColors();
$sizes = getSizes();


if ($_POST) {
  $errors = [];
  $name = validate($_REQUEST, 'name');
  if (!$name)
    $errors['name'] = 'Please enter a valid name';
  else
    $values['name'] = $name;
  $image = validateFile($_FILES, 'image', 2 * 1024 * 1024, ['image/jpeg']);
  if ($image) {
    $values['image_url'] = uploadFile($image);
  }
  if ($_REQUEST['price'] > 0) {
    $values['price'] = (float) $_REQUEST['price'];
  } else {
    $errors['price'] = 'Please enter a valid price';
  }
  if ($_REQUEST['discount'] >= 0 && $_REQUEST['discount'] <= 100) {
    $values['discount'] = (float) $_REQUEST['discount'] / 100.0;
  } else {
    $errors['discount'] = 'Please enter a valid discount value';
  }
  $values['description'] = $_REQUEST['description'];
  $values['bar_code'] = $_REQUEST['bar_code'];
  $values['category_id'] = $_REQUEST['category_id'];
  $values['color_id'] = $_REQUEST['color_id'];
  $values['size_id'] = $_REQUEST['size_id'];
  $values['is_recent'] = isset($_REQUEST['is_recent']) ? 1 : 0;
  $values['is_featured'] = isset($_REQUEST['is_featured']) ? 1 : 0;

  if (!$errors) {
    editProduct($values);
    header('Location:index.php');
    die();
  }
}

require_once('../layouts/header.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Product</h1>
        </div>

      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <?php
          if (isset($_SESSION['error_message'])) {
            echo "<div class='text-danger'>" . $_SESSION['error_message'] . "</div>";
            unset($_SESSION['error_message']);
          }
          ?>
          <form class="row" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?id=<?= $product['id'] ?>" method="post"
            enctype="multipart/form-data">
            <div class="form-group col-6">
              <label>Name</label>
              <input name="name" class="form-control" value="<?= isset($values['name']) ? $values['name'] : '' ?>" />
              <?= isset($errors['name']) ? '<span class="text-danger">' . $errors['name'] . '</span>' : '' ?>
            </div>
            <div class="form-group col-6">
              <label>Image</label>
              <img src="<?= BASE_URL . $values['image_url'] ?>" width="250" height="250" />
              <input name="image" type="file" />
              <?= isset($errors['image']) ? '<span class="text-danger">' . $errors['image'] . '</span>' : '' ?>
            </div>
            <div class="form-group col-12">
              <label>Description</label>
              <textarea name="description"
                class="form-control"><?= isset($values['description']) ? $values['description'] : '' ?></textarea>
            </div>
            <div class="form-group col-6">
              <label>Price</label>
              <input name="price" class="form-control" type="number" min="0"
                value="<?= isset($values['price']) ? $values['price'] : '' ?>" />
              <?= isset($errors['price']) ? '<span class="text-danger">' . $errors['price'] . '</span>' : '' ?>
            </div>
            <div class="form-group col-6">
              <label>Discount %</label>
              <input name="discount" type="number" min="0" max="100" class="form-control"
                value="<?= isset($values['discount']) ? $values['discount'] * 100 : '' ?>" />
              <?= isset($errors['discount']) ? '<span class="text-danger">' . $errors['discount'] . '</span>' : '' ?>
            </div>
            <div class="form-group col-6">
              <label>Bar Code</label>
              <input name="bar_code" class="form-control"
                value="<?= isset($values['bar_code']) ? $values['bar_code'] : '' ?>" />
            </div>
            <div class="form-group col-6">
              <label>Category</label>
              <select name="category_id" class="form-control">
                <?php
                foreach ($categories as $category) {
                  echo '<option value="' . $category['id'] . '"' . (isset($values['category_id']) && $values['category_id'] == $category['id'] ? 'selected' : '') . '>' . $category['name'] . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="form-group col-6">
              <label>Color</label>
              <select name="color_id" class="form-control">
                <?php
                foreach ($colors as $c) {
                  echo '<option value="' . $c['id'] . '" ' . (isset($values['color_id']) && $values['color_id'] == $c['id'] ? 'selected' : '') . '>' . $c['name'] . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="form-group col-6">
              <label>Size</label>
              <select name="size_id" class="form-control">
                <?php
                foreach ($sizes as $s) {
                  echo '<option value="' . $s['id'] . '" ' . (isset($values['size_id']) && $values['size_id'] == $s['id'] ? 'selected' : '') . '>' . $s['name'] . '</option>';
                }
                ?>
              </select>
            </div>
            <div class="form-group col-6">
              <label>Recent</label>
              <input type="checkbox" name="is_recent" <?= isset($values['is_recent']) && $values['is_recent'] ? 'checked' : '' ?> />
            </div>
            <div class="form-group col-6">
              <label>Featured</label>
              <input type="checkbox" name="is_featured" <?= isset($values['is_featured']) && $values['is_featured'] ? 'checked' : '' ?> />
            </div>
            <button class="btn btn-success">Edit</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<?php
require_once('../layouts/footer.php');
?>