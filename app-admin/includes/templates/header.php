<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $page_title?></title>

  <!-- Custom fonts for this template-->
  <link href="<?= $ADMIN_VENDOR?>fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= $ADMIN_CSS ?>sb-admin-2.min.css" rel="stylesheet">
  <?php
  $pages = ['users', 'classes', 'privileges', 'users_groups' ,'material', 'students_reg'];
  if ( isset($page) && in_array($page, $pages )) {
    echo '<link href="'. $ADMIN_VENDOR .'datatables/dataTables.bootstrap4.min.css" rel="stylesheet" />';
  }
   ?>
  <link href="<?= $ADMIN_CSS ?>app.admin.css" rel="stylesheet">
  <?php if ($_SESSION['app_lang'] == 'ar'): ?>
  <?php endif; ?>


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
