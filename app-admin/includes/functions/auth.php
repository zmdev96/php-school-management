<?php

// [active 1]
// [pending 2]
// [disabled 3]

// Check if the user exists in database
function auth($username, $password){
  global $con;
  $stmt = $con->prepare("SELECT * FROM app_users WHERE username = ? AND password = ? ");
  $stmt->execute(array($username, $password));
  $loged_user = $stmt->fetch();

  if ($loged_user !== false) {
    if ($loged_user['status'] == 'pending') {
      return 2;
    }elseif ($loged_user['status'] == 'disabled') {
      return 3;
    }else {
      $stmt1 = $con->prepare("SELECT * FROM app_users_profiles WHERE user_id = ?");
      $stmt1->execute(array($loged_user['user_id']));
      $loged_user_profile = $stmt1->fetch();
      $merged_array = array_merge($loged_user, $loged_user_profile);
      $_SESSION['authUser'] = $merged_array;
      return 1;
    }

  }
}

// Check if the user authorized or not
function authorized(){
  return isset($_SESSION['authUser']);
}

// return the given key from user array
function authUser($key){
  return $_SESSION['authUser'][$key];
}

// Check if the user has access to the current URL
function hasAccess(){
  global $con;

  $real_path = $_SERVER['REQUEST_URI'];
  $real_path = explode('/', $real_path);
  $path = end($real_path);
  $check = strstr($path, '&');
  if ($check) {
    $path = str_replace($check, '', $path);
  }
  $execludeUrls = [
    'login.php',
    'login.php?action=submit',
    'logout.php',
    'index.php',
    'lang_handler.php?lang=en',
    'lang_handler.php?lang=ar',
    ];

    // get all users privileges from the middel Table
    $stmt1 = $con->prepare("SELECT augp.*, aup.* FROM app_users_groups_privileges augp INNER JOIN app_users_privileges aup ON aup.privilege_id = augp.privilege_id WHERE augp.group_id = " . authUser('group_id'));
    $stmt1->execute();
    $priviinfo = $stmt1->fetchAll();//fetch dtata from app_users_groups_privileges
    $extracted_ids = [];
    foreach ($priviinfo as $pri_path) {
     $extracted_ids[] =  $pri_path['privilege_path'];
    }

    //check of privilege_title_en if allowed of user or not
    if (in_array($path, $execludeUrls) || in_array($path, $extracted_ids)) {
    }else {
      redirect('access_denied.php');
    }
}
