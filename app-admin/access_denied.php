<?php
ob_start();
  session_start();
  $app  = 'app-admin';
  $page = 'index';
  require_once('../config.php');
  if (null == authorized()) {
    redirect('login.php');
  }
  $page_title = $lang['page_index'];
  // Start Content View
  require_once(ADMIN_TEMPLATE_PATH . 'header.php');
  require_once(ADMIN_TEMPLATE_PATH . 'sidebar.php');
  require_once(ADMIN_TEMPLATE_PATH . 'navbar.php'); ?>

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- 404 Error Text -->
    <div class="text-center">
      <div class="error mx-auto" data-text="404">403</div>
      <p class="lead text-gray-800 mb-5">Access Deneind</p>
      <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
      <a href="index.html">&larr; Back to Dashboard</a>
    </div>

  </div>
  <!-- /.container-fluid -->
<?php require_once(ADMIN_TEMPLATE_PATH . 'footer.php');

ob_end_flush();
