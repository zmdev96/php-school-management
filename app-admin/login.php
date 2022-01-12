<?php
ob_start();
  session_start();
  $app  = 'app-admin';
  $page = 'login';
  require_once('../config.php');
  if (authorized()) {
    redirect('index.php');
  }
  $page_title = $lang['page_login'];
  // Start Content View
  require_once(ADMIN_TEMPLATE_PATH . 'header.php');
  $action = isset($_GET['action']) ? $_GET['action'] : 'index';
  if ($action == 'index') {?>
    <div class="">
  <div class="login">
    <div class="container-login text-center">
      <div class="wrap-login">
        <h2>SCHOOL</h2>
        <form action="login.php?action=submit" class="login-form" method="post">
          <span class="login-form-title">Login To Panel</span>
          <div class="login-error">
            <?php if (messagesGet()):?>
              <div class="col-md-12">
                <div class="alert alert-<?=messagesGet()['type']?>">
                  <?=messagesGet()['message']?>
                </div>
              </div>
            <?php endif; ?>
          </div>
          <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off" required/>
          <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="new-password" required />
          <input class="btn btn-default" name="submit" type="submit" value="Login" />
        </form>
      </div>
    </div>
  </div>
</div>

  <?php }elseif ($action == 'submit') {
    //fetch data from app-users for examinatuin
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $pass = crypt_pass($password);
    auth($username, $pass);

      if (auth($username, $pass) == 3) {
        messagesPut('danger', 'Your Account is disabled by admin');
        redirect('back');
      }elseif (auth($username, $pass) == 2) {
        messagesPut('danger', 'Your Account is pending by admin');
        redirect('back');
      }elseif (auth($username, $pass) == 1) {
        redirect('index.php');
      }

    }else {
      redirect('login.php');
    }
  }else {
    redirect('notfound.php');
  }
ob_end_flush();
