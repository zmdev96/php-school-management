<?php
ob_start();
  $app  = 'app-admin';
  $page = 'users_groups';
  session_start();
  require_once('../config.php');
  $my_group = 1;
  $real_path = $_SERVER['REQUEST_URI'];
  $real_path = explode('/', $real_path);
  $path = end($real_path);
  pre($path);
  // get The user group name

  //display privileges vai group_id
  $stmt = $con->prepare("SELECT * FROM app_users_groups WHERE group_id = ? ");
  $stmt->execute(array($my_group));
  $groupinfo = $stmt->fetch();//fetch of data
  $my_group_id = $groupinfo['group_id'];//
  $user_group_name = $groupinfo['group_title_en'];//fetch the group it is in
  echo 'your group is:' . $user_group_name;//name of group belong
  echo "<br> and your privileges are:";
 $stmt1 = $con->prepare("SELECT augp.*, aup.* FROM app_users_groups_privileges augp INNER JOIN app_users_privileges aup ON aup.privilege_id = augp.privilege_id WHERE augp.group_id = $my_group_id ");
 $stmt1->execute();
 $priviinfo = $stmt1->fetchAll();//fetch dtata from app_users_groups_privileges
 $extracted_ids = [];
 foreach ($priviinfo as $pri) {
   //print of privilege_title_en+privilege_path
   echo "<li>" . $pri['privilege_title_en'] . " | " . $pri['privilege_path'] ."</li>";
 }
  $extracted_ids = [];
  foreach ($priviinfo as $pri) {
   $extracted_ids[] =  $pri['privilege_path'];
  }
  //check of privilege_title_en if allowed of user or not
  if (in_array($path, $extracted_ids )) {
    echo "<br>you are allowed to vist this page";
  }else {
    echo "<br>you are not allowed to vist this page";
  }
ob_end_flush();
