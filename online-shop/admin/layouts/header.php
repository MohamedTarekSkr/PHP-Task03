<?php
require_once(BASE_PATH.'logic/authentication.php');
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= BASE_ADMIN_URL ?>plugins/fontawesome-free/css/all.min.css" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="<?= BASE_ADMIN_URL ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= BASE_ADMIN_URL ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= BASE_ADMIN_URL ?>plugins/jqvmap/jqvmap.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= BASE_ADMIN_URL ?>dist/css/adminlte.min.css" />
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= BASE_ADMIN_URL ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= BASE_ADMIN_URL ?>plugins/daterangepicker/daterangepicker.css" />
  <!-- summernote -->
  <link rel="stylesheet" href="<?= BASE_ADMIN_URL ?>plugins/summernote/summernote-bs4.min.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <h4>Shop AdminPanel</h4>
    </div>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light">Shop Admin</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= BASE_ADMIN_URL ?>dist/img/user2-160x160.jpg" class="img-circle elevation-2"
              alt="User Image" />
          </div>
          <div class="info">
            <a href="#" class="d-block">
              <?= $user['username'] ?>
            </a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="<?= BASE_ADMIN_URL ?>categories" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Categories</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= BASE_ADMIN_URL ?>products" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Products</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= BASE_ADMIN_URL ?>users" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Users</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= BASE_ADMIN_URL ?>sizes" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Sizes</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?= BASE_ADMIN_URL ?>colors" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Colors</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= BASE_ADMIN_URL ?>logout.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>Logout</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>