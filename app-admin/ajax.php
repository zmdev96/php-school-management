<?php
ob_start();
  session_start();
  $app  = 'app-admin';
  $page = 'users';
  require_once('../config.php');
  if (null == authorized()) {
    redirect('login.php');
  }
if (isset($_POST['action']) && $_POST['action'] == 'get_user') {
  $user_id = $_POST['user_id'];
  $check = check('user_id', 'app_users', $user_id );
  if ($check) {
    // get the user info
    $stmt = $con->prepare("SELECT * FROM app_users WHERE user_id = ? ");
    $stmt->execute(array($user_id));
    $userinfo = $stmt->fetch();
    // get the user profile
    $stmt1 = $con->prepare("SELECT * FROM app_users_profiles WHERE user_id = ? ");
    $stmt1->execute(array($user_id));
    $userprofile = $stmt1->fetch();

    $all_data = array_merge($userinfo, $userprofile);
    echo json_encode($all_data);
  }


}


ob_end_flush();
