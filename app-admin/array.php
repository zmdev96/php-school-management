<?php
ob_start();
  $app  = 'app-admin';
  $page = 'users_groups';
  session_start();
  require_once('../config.php');
  $array_one = ['zeyad', 'hadeel', 'ahamd'];
  $array_new = ['zeyad', 'hadeel', 'khaled'];
  $deleted_name = array_diff($array_one, $array_new);
  $added_name = array_diff($array_new, $array_one);

  pre($deleted_name);
  pre($added_name);

/*  $password = 'zeyadmoslem';
  $salt = '$2a$07$yeNCSNwRpYopOhv0TrrReP$';
  $crypted_password = crypt($password, $salt);
  pre($crypted_password);*/
  $pass = 'moslem';
  $hashed_pass = sha1($pass);
  pre($hashed_pass);


ob_end_flush();
